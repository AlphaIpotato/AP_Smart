<?php
header("Content-Type: text/html;charset=UTF-8");

$host = 'localhost';
$user = 'root';
$pw = 'apmsetup';
$dbName = 'mushroom';
$mysqli = new mysqli($host, $user, $pw, $dbName);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $temp = $_POST['temperature'];
   $humi = $_POST['humidity'];
   $soil_humi = $_POST['soil_humidity'];
   $led = $_POST['led'];

   $query = "INSERT INTO tempnhumi (temp, humi, soil_humi, led) VALUES ('$temp','$humi','$soil_humi', '$led')";
   mysqli_query($mysqli, $query);
}

$sql = "SELECT * FROM tempnhumi ORDER BY id DESC LIMIT 1";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
   $row = $result->fetch_assoc();
   $temp = $row['temp'];
   $humi = $row['humi'];
   $soil_humi = $row['soil_humi'];
   $led = $row['led'];  
} else {
   $temp = "No data";
   $humi = "No data";
   $soil_humi = "No data";
   $led = "No data";  
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Temperature and Humidity</title>
    <style>
        body {
            background-color: black;
            color: white;
            text-align: center; 
        }
        .header {
            position: fixed;
            top: 0;
            width: 100%;
        }
        .container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 100vh;  
        }
        .data-box { 
            border: 1px solid white;
            padding: 10px;
            margin: 10px;
            width: 150px;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
        }
        .status-button {
            width: 100px;
            height: 50px;
            border: none;
            border-radius: 25px;
            margin-top: 5px;
            color: white;
        }
        .low-temp {
        background-color: #FFB6B6; /* 연한 빨강 */
        }
        .mid-temp {
            background-color: #FF6A6A; /* 중간 빨강 */
        }
        .high-temp {
            background-color: #FF0000; /* 진한 빨강 */
        }
        .low-humi {
            background-color: #B2D8FF; /* 연한 파랑 */
        }
        .mid-humi {
            background-color: #579AFF; /* 중간 파랑 */
        }
        .high-humi {
            background-color: #006AFF; /* 진한 파랑 */
        }
        .low-soil {
            background-color: #FFF7B2; /* 연한 황색 */
        }
        .mid-soil {
            background-color: #FFE057; /* 중간 황색 */
        }
        .high-soil {
            background-color: #FFD700; /* 진한 황색 */
        }
        .led-off {
            background-color: #7F7F7F; /* LED가 꺼져 있을 때의 배경색. 여기서는 회색으로 설정했습니다. */
        }
        .led-on {
            background-color: #00FF00; /* LED가 켜져 있을 때의 배경색. 여기서는 초록색으로 설정했습니다. */
        }
			
    </style>
</head>
<body>
    <div class="header">
        <h1>Mush Room!</h1>
        <h2>Smart Farm</h2>
        
    </div>
    <div class="container">
        <div class="data-box">
            <h3>온도</h3>
            <h2 id="temp-status"><?php echo $temp; ?>°C</h2>
            <button class="status-button <?php echo ($temp < 20) ? 'low-temp' : ($temp < 27) ? 'mid-temp' : 'high-temp'; ?>" onclick="updateValue('temp')"></button>
        </div>
        <div class="data-box">
            <h3>습도</h3>
            <h2 id="humi-status"><?php echo $humi; ?>%</h2>
            <button class="status-button <?php echo ($humi < 30) ? 'low-humi' : ($humi < 60) ? 'mid-humi' : 'high-humi'; ?>" onclick="updateValue('humi')"></button>
        </div>
        <div class="data-box">
            <h3>토양습도</h3>
            <h2 id="soil-status"><?php echo $soil_humi; ?>%</h2>
            <button class="status-button <?php echo ($soil_humi < 30) ? 'low-soil' : ($soil_humi < 60) ? 'mid-soil' : 'high-soil'; ?>" onclick="updateValue('soil')"></button>
        </div>
        <div class="data-box">
            <h3>LED</h3>
            <h2 id="led-status"><?php echo $led; ?></h2>
            <button class="status-button <?php echo ($led == 'No data') ? 'led-off' : 'led-on'; ?>" onclick="updateValue('led')"></button>
        </div>

        <div class="container" style="justify-content: center;">
            <iframe src="http://192.168.62.16" style="width:80%; height: 30vh; border: none;"></iframe>
        </div>

    </div>

    <script>
         function updateSensors() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_sensors.php', true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    document.getElementById('temp-status').innerText = data.temp;
                    document.getElementById('humi-status').innerText = data.humi;
                    document.getElementById('soil-status').innerText = data.soil_humi;
                    document.getElementById('led-status').innerText = data.led;
                }
            }

            xhr.send();
        }

        // 30초마다 센서 데이터를 새로고침
        setInterval(updateSensors, 10000);
    </script>
</body>
</html>
