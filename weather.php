<?php
if(isset($_GET['searchCity'])) {
    $city = $_GET['searchCity'];
} else {
    $city = 'Dhaka'; 
}

$apiKey = '218c4b33847098d10c1bd8de1f6ee0a9';
$url = "http://api.openweathermap.org/data/2.5/weather?q=" . $city . "&units=metric&appid=" . $apiKey;

$contents = file_get_contents($url);
$clima = json_decode($contents);

$cityName = $clima->name;
$currentDay = date("l");
$humidity = $clima->main->humidity;
$windSpeed = $clima->wind->speed;
$pressure = $clima->main->pressure;
$tempMax = $clima->main->temp_max;

$forecastUrl = "http://api.openweathermap.org/data/2.5/forecast?q=" . $city . "&units=metric&appid=" . $apiKey;
    $forecastContents = file_get_contents($forecastUrl);
    $forecastData = json_decode($forecastContents);
    
    
    $dates = array();
    $forecastCount = 0;
    
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="Assignment-4.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Vithkuqi&family=Work+Sans:wght@200&display=swap" rel="stylesheet">

</head>
<body>
    <div class="header">
       
        <h1>Weather Forecast</h1>
        <form action="" method="">
        <input type="text" id="cityName" name="searchCity" placeholder="Enter City Name">
        <button type="submit" id="searchbtn"><span class="material-symbols-outlined">
            search
            </span></button>
        </form>
    </div>
    <div class="weatherToday">
        <div class="weatherDetails">
            <div class="card1">
                <div class="city">
                    <h2 id="cityName"><?= $cityName ?></h2>
                </div>
                <div class="day">
                    <h4 id="currentDay"><?= $currentDay ?></h4>
                </div>
                <div class="current">
                    <p class="weatherIndicator weatherIndicatorhumidity">
                    <span class="material-symbols-outlined" >
                humidity_percentage
                </span>
                        <span class="value" id="humidityValue"><?= $humidity ?></span>
                    <p class="weatherIndicator weatherIndicatorwind">
                    <span class="material-symbols-outlined">wind_power</span>
                        <span class="value"><?= $windSpeed ?></span>m/s</p>
                    <p class="weatherIndicator weatherIndicatorpressure">
                        <span class="material-symbols-outlined">readiness_score</span>
                        <span class="value" id="pressureValue"><?= $pressure ?></span>hPa</p>
                </div>
            </div>
            <div class="weatherTemp">
                <span class="material-symbols-outlined">thermostat</span>
                <span class="value" id="tempMaxValue"><?= $tempMax ?></span>&deg;C
            </div>
        </div>
    </div>
    <div class="weatherForecast">
    <?php
    
    $dates = array();
    $forecastCount = 0;

   
    foreach ($forecastData->list as $day) {
        $date = date("Y-m-d", strtotime($day->dt_txt));

        
        if (!in_array($date, $dates)) {
            $dates[] = $date;
            $tempMax = $day->main->temp_max;

            
            echo '<article class="forecastitem">';
            echo '<h3 class="weatherForecastDay">' . date("l", strtotime($date)) . '</h3>';
            echo '<p class="weatherIndicator  weatherIndicatorTemp"> <span class="material-symbols-outlined">thermostat</span><span class="value">' . $tempMax . '</span>&deg;C</p>';
            echo '<p class="weatherIndicator weatherIndicatorhumidity">
                    <span class="material-symbols-outlined">
                humidity_percentage
                </span>
                        <span class="value">'. $humidity .'</span>';

             echo       '<p class="weatherIndicator weatherIndicatorwind">
                    <span class="material-symbols-outlined">wind_power</span>
                        <span class="value">'. $windSpeed.'</span>m/s</p>';
             echo       '<p class="weatherIndicator weatherIndicatorpressure">
                        <span class="material-symbols-outlined">readiness_score</span>
                        <span class="value" id="pressureValue">'. $pressure.'</span>hPa</p>';
            echo '</article>';

            $forecastCount++;

            
            if ($forecastCount >= 4) {
                break;
            }
        }
    }
    ?>
</div>
</body>
</html>
