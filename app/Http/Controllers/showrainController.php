<?php
 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDO;

class showrainController extends Controller
{
    public function showrain(Request $request)
    {
        $cityNumber = $request->input('citynumber');
        $weather = $request->input('weather');
        if($weather == 4) {
                $ch = curl_init();
    
                // 從檔案中讀取資料到PHP變數 
                curl_setopt($ch, CURLOPT_URL, "https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-1B423024-C23F-44A7-9E83-AB17227AC4A3&elementName=RAIN,HOUR_24&parameterName=CITY");//雨量
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
                $sql = "Truncate table rain";
                $truncate = $pdo->prepare($sql);
                $truncate ->execute();

                foreach($data["records"]["location"] as $i){//雨量
                    $time = $i["time"]["obsTime"];
                    $city = $i["parameter"][0]["parameterValue"];
                    $onehourrain = $i["weatherElement"][0]["elementValue"];
                    $onedayrain = $i["weatherElement"][1]["elementValue"];

                    if($onehourrain == -998)
                        $onehourrain = 0;

                    $sql = "INSERT INTO rain(`cityid`, `onehourRain`, `onedayRain`, `rainDate`) VALUES (?,?,?,?)";
                    $insertData = $pdo->prepare($sql);
                    $insertData->execute([$city, $onehourrain, $onedayrain, $time]);
                }
                
                $sql = "SELECT city.cityid, onehourRain, onedayRain, rainDate FROM rain LEFT JOIN city 
                        ON city.cityid = rain.cityid where city.id =?";
                $select = $pdo->prepare($sql);
                $select->execute([$cityNumber]);
                $pdo->commit();

                $avgoneRain = 0;
                $avgonedayRain = 0;
                $cnt = 0;
                $result = $select->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row){
                    $avgoneRain += $row['onehourRain'];
                    $avgonedayRain += $row['onedayRain'];
                    $cnt += 1;
                }
                $showData =['cityid' => $row['cityid'], 'onehourRain' => round($avgoneRain/$cnt, 2), 'onedayRain' => round($avgonedayRain/$cnt, 2), 'timeNow' => $time];
                unset($pdo);
        }
        return $showData;
    }
}
        
?>