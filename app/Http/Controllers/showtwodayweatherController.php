<?php
 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDO;

class showtwodayweatherController extends Controller
{
    public function showtwodayweather(Request $request)
    {
        $cityNumber = $request->input('citynumber');
        $weather = $request->input('weather');
        if($weather == 2) {
                $ch = curl_init();
    
                // 從檔案中讀取資料到PHP變數 
                curl_setopt($ch, CURLOPT_URL, "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-1B423024-C23F-44A7-9E83-AB17227AC4A3&elementName=PoP12h,T,WeatherDescription");
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

                $sql = "Truncate table twodayweather";
                $truncate = $pdo->prepare($sql);
                $truncate ->execute();

                foreach($data["records"]["locations"][0]["location"] as $i){//兩天天氣
                    $city = $i["locationName"];
                    for($k=0;$k<24;$k++){
                        $descriptionT = $i["weatherElement"][1]["time"][$k]["elementValue"][0]["value"];
                        $Description = $i["weatherElement"][2]["time"][$k]["elementValue"][0]["value"];
                        $startTime = $i["weatherElement"][2]["time"][$k]["startTime"];
                        $endTime = $i["weatherElement"][2]["time"][$k]["endTime"];
        
                        $sql = "INSERT INTO twodayweather(`cityid`, `descriptionT`, `Description`, `startTime`, `endTime`) VALUES (?,?,?,?,?)";
                        $insertData = $pdo->prepare($sql);
                        $insertData->execute([$city, $descriptionT, $Description, $startTime, $endTime]);
                    } 
                }
                $sql = "SELECT city.cityid, `descriptionT`, `Description`, `startTime`, `endTime` FROM twodayweather LEFT JOIN city 
                        ON city.cityid = twodayweather.cityid where city.id =?";
                $select = $pdo->prepare($sql);
                $select->execute([$cityNumber]);
                $result = $select->fetchAll(PDO::FETCH_ASSOC);
                for($i=0;$i<24;$i++){
                    $spiltData = explode("。",$result[$i]['Description']);
                    $resultData[$i]['cityid'] = $result[$i]['cityid'];
                    $resultData[$i]['startTime'] = $result[$i]['startTime'];
                    $resultData[$i]['endTime'] = $result[$i]['endTime'];
                    $resultData[$i]['weather'] = $spiltData[0];
                    $resultData[$i]['rainProbability'] = $spiltData[1];
                    $resultData[$i]['temp'] = $spiltData[2];
                    $resultData[$i]['tempFeel'] = $spiltData[3];
                    $resultData[$i]['wind'] = $spiltData[4];
                    $resultData[$i]['RelativeHumidity'] = $spiltData[5];
                }
        }
        return $resultData;
    }
}
        
?>