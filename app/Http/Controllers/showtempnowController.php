<?php
 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDO;

class showtempnowController extends Controller
{
    public function showtempnow(Request $request)
    {
        $cityNumber = $request->input('citynumber');
        $weather = $request->input('weather');
        if($weather == 1) {
                $ch = curl_init();
    
                // 從檔案中讀取資料到PHP變數 
                curl_setopt($ch, CURLOPT_URL, "https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0003-001?Authorization=CWB-1B423024-C23F-44A7-9E83-AB17227AC4A3&format=JSON&elementName=TIME,TEMP&parameterName=CITY");//當前天氣
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HEADER, 0); 
                    
                $pageContent = curl_exec($ch);        
                // 4. 關閉與釋放資源
                curl_close($ch);   
                
                // 用引數true把JSON字串強制轉成PHP陣列  
                $data = json_decode($pageContent, true);

                $dsn="mysql:host=127.0.0.1;port=3306;dbname=weatherdb"; 
                $username="root"; 
                $password="";
                $pdo = new PDO($dsn,$username,$password);

                $pdo->beginTransaction();
                $sql = "Truncate table tempnow";
                $truncate = $pdo->prepare($sql);
                $truncate ->execute();

                foreach($data["records"]["location"] as $i){//當前天氣
                    $time = $i["time"]["obsTime"];
                    $city = $i["parameter"][0]["parameterValue"];
                    $temp = $i["weatherElement"][0]["elementValue"]; 
                    
                    if($temp>=0){
                        $sql = "INSERT INTO tempnow(`cityid`, `temp`, `timeNow`) VALUES (?,?,?)";
                        $insertData = $pdo->prepare($sql);
                        $insertData->execute([$city, $temp, $time]);
                    }
                }
                
                $sql = "SELECT city.cityid, temp, timeNow FROM tempnow LEFT JOIN city 
                        ON city.cityid = tempnow.cityid where city.id =?";
                $select = $pdo->prepare($sql);
                $select->execute([$cityNumber]);
                $pdo->commit();

                $cnt = 0;
                $avgTemp = 0;
                $result = $select->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row){
                    $avgTemp += $row['temp'];
                    $cnt +=1 ;
                }
                $showData =['cityid' => $row['cityid'] ,'temp' => round($avgTemp/$cnt, 2), 'timeNow' => $time];
                unset($pdo);
        }
        return $showData;
    }
}
        
?>