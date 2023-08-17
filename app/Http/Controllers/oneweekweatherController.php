<?php
 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDO;

class oneweekweatherController extends Controller
{
    public function showoneweekweather(Request $request)
    {
        $cityNumber = $request->input('citynumber');
        $weather = $request->input('weather');
        if($weather == 3) {
                $ch = curl_init();
    
                // 從檔案中讀取資料到PHP變數 
                curl_setopt($ch, CURLOPT_URL, "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-1B423024-C23F-44A7-9E83-AB17227AC4A3&elementName=,MinT,MaxT,Wx");//一週天氣
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

                $sql = "Truncate table oneweekweather";
                $truncate = $pdo->prepare($sql);
                $truncate ->execute();

                foreach($data["records"]["locations"][0]["location"] as $i){//一週天氣
                    $city=$i["locationName"];
                    for($k=0;$k<14;$k++){
                        //$description = $i["weatherElement"][1]["time"][$k]["elementValue"][0]["value"];
                        $minT = $i["weatherElement"][8]["time"][$k]["elementValue"][0]["value"];
                        $maxT = $i["weatherElement"][12]["time"][$k]["elementValue"][0]["value"];
                        
                        $starttime = $i["weatherElement"][0]["time"][$k]["startTime"];
                        $endtime = $i["weatherElement"][0]["time"][$k]["endTime"];

                        $sql = "INSERT INTO oneweekweather(`cityid`, `MinT`, `MaxT`, `startTime`, `endTime`) VALUES (?,?,?,?,?)";
                        $insertData = $pdo->prepare($sql);
                        $insertData->execute([$city, $minT, $maxT, $starttime, $endtime]);
                        }
                }
                
                $sql = "SELECT city.cityid, `MinT`, `MaxT`, `startTime`, `endTime` FROM oneweekweather LEFT JOIN city 
                        ON city.cityid = oneweekweather.cityid where city.id =?";
                $select = $pdo->prepare($sql);
                $select->execute([$cityNumber]);
                $result = $select->fetchAll(PDO::FETCH_ASSOC);
                
                $min = 99;
                $max = 0;
                for($i = 0; $i<14; $i++){
                    if($result[$i]['MinT'] <= $min){
                        $min = $result[$i]['MinT'];
                    }
                    if($result[$i]['MaxT'] >= $max){
                        $max = $result[$i]['MaxT'];
                    }
                    if($i %2 == 1){
                        $advData[($i+1)/2]['startTime'] = $result[$i-1]['startTime'];
                        $advData[($i+1)/2]['endTime'] = $result[$i]['endTime'];
                        $advData[($i+1)/2]['cityid'] = $result[$i]['cityid'];
                        $advData[($i+1)/2]['minT'] = $min;
                        $advData[($i+1)/2]['maxT'] = $max;
                        $min = 99;
                        $max = 0;
                    }
                }
                
        }
        return $advData;
    }
}
        
?>