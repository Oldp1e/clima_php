<?php

//Este é um pequeno software para verificação do Clima Utilizando a API do OpenWeather e PHP Curl para enviar as requisições para a API

//Define Localização e Zona de Tempo e formatação de Data e Hora
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');


//Chave da API do Open Weather
$apiKey = "CHAVE DA API";

    //ID da Cidade de São Paulo para teste 3448433
    //Recebe do GET a Variavel de Idade obtida no arquivo JSON disponivel no GitHub
    if(isset($_GET['cityId'])){
        $cityId = $_GET['cityId'];
    } else{
        //Define a cidade padrão para São Paulo caso não obtenha nenhuma ID personalizada
        $cityId = '3448433';
    }





$googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=en&units=metric&APPID=" . $apiKey;

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);

curl_close($ch);
$data = json_decode($response);
$currentTime = time();
?>
<!doctype html>
<html>
<head>
<title>Previsão do Tempo</title>
<style>
/* CSS BÁSICO DO HTML */
body {
    font-family: Arial;
    font-size: 0.95em;
    color: #929292;
}

.report-container {
    border: #E0E0E0 1px solid;
    padding: 20px 40px 40px 40px;
    border-radius: 2px;
    width: 550px;
    margin: 0 auto;
}

.weather-icon {
    vertical-align: middle;
    margin-right: 20px;
}

.weather-forecast {
    color: #212121;
    font-size: 1.2em;
    font-weight: bold;
    margin: 20px 0px;
}

span.min-temperature {
    margin-left: 15px;
    color: #929292;
}

.time {
    line-height: 25px;
}
</style>

</head>
<body>
    <div class="report-container">
        <h2>Situação do Clima em <?php echo $data->name; ?></h2>
        <div class="time">
            <div><?php echo date('H:i:s');  ?></div>
            <div><?php //Exibe a Data no Formato em Portugues
            echo strftime('%A, %d de %B de %Y', strtotime('today')); ?></div>
            <div><?php echo ucwords($data->weather[0]->description); ?></div>
        </div>
        <div class="weather-forecast">
            <img
                src="http://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png"
                class="weather-icon" /> <?php echo $data->main->temp_max; ?>°C<span
                class="min-temperature"><?php echo $data->main->temp_min; ?>°C</span>
        </div>
        <div class="time">
            <div>Umidade: <?php echo $data->main->humidity; ?> %</div>
            <div>Vento: <?php echo $data->wind->speed; ?> km/h</div>
        </div>
    </div>
</body>
</html>
