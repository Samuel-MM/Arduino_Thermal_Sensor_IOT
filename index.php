<?php
  require('config.php');
  require('submit.php');
?>

<!doctype html>
<html>
  <script>
    window.onload = function () {
    
    var dps = []; // dataPoints
    var chart = new CanvasJS.Chart("chartContainer", {
      title :{
        text: "Temperatura x Tempo"
      },
      axisY:{
        title: "Temperatura (ºC)",
      },
      axisX:{
        title: "Tempo (min)",
      },
      data: [{
        type: "line",
        dataPoints: dps
      }]
    });
    
    var xVal = 0;
    var yVal = 100; 
    var updateInterval = 1000;
    var dataLength = 20; // number of dataPoints visible at any point
    
    var updateChart = function (count) {
    
      count = count || 1;
    
      for (var j = 0; j < count; j++) {
        yVal = yVal +  Math.round(5 + Math.random() *(-5-5));
        dps.push({
          x: xVal,
          y: yVal
        });
        xVal++;
      }
    
      if (dps.length > dataLength) {
        dps.shift();
      }
    
      chart.render();
    };
    
    updateChart(dataLength);
    setInterval(function(){updateChart()}, updateInterval);
    
    }
    </script>
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Arduino</title>
      <script src='https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js'></script>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <script src="https://kit.fontawesome.com/7ec1664cb8.js" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="style.css">
   </head>
   <body>
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <a class="navbar-brand mx-lg-5" href="#">Sefitel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-lg-auto mx-lg-5">
            <li class="nav-item">
              <img src="https://www.w3schools.com/howto/img_avatar.png" class="rounded-circle userImg" alt="...">
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <main class="container">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Home</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="config-tab" data-bs-toggle="tab" data-bs-target="#config" type="button" role="tab" aria-controls="config" aria-selected="false">Configurações</button>
        </li>
      </ul>
      <div class="tab-content pb-5 mx-md-5 mx-1" id="myTabContent">
        <div class="tab-pane fade show active  mt-5" id="home" role="tabpanel" aria-labelledby="home-tab">
          <section class="py-4 mx-md-5 px-md-5 px-2 dataSection shadow-sm">
              <ul>
                <li>Temperatura atual: <span><?= substr($temperature->getValue(), 0, 5)."ºC";?></span></li>
                <li class="my-4">Temperatura máxima: <span><?= $data->getValue()['maxTemp']."ºC";?></span></li>
                <li>Temperatura mínima: <span><?= $data->getValue()['minTemp']."ºC";?></span></li>
                <li class="my-4">Temperatura ideal: <span><?= $data->getValue()['idealTemp']."ºC";?></span></li>
                <li><div class="container">
                  <div class="row ">
                    <div class="col">
                      Maior temperatura alcançada: <span>117ºC</span>
                    </div>
                    <div class="col">
                      Data: <span>27/10/2021 às 16:45:13</span>
                    </div>
                  </div>
                </li>
                <li class="my-4"><div class="container">
                  <div class="row ">
                    <div class="col">
                      Menor temperatura alcançada: <span>90ºC</span>
                    </div>
                    <div class="col">
                      Data: <span>27/10/2021 às 16:20:45</span>
                    </div>
                  </div>
                </li>
                <li class="my-4">Última manutenção realizada: <span><?= date('d/m/Y', strtotime($data->getValue()['lastManutention']));?></span></li>
                <p class="text-center statusMessage pt-3">A temperatura atual apresenta estabilidade</p>
              </ul>
          </section>
          <div class="my-5">
            <h2 class="text-center">Gráfico em tempo real</h2>
            <div id="chartContainer" style="height: 300px;" class="my-5 w-100"></div>
          </div>
        </div>
        <div class="tab-pane fade mt-5" id="config" role="tabpanel" aria-labelledby="config-tab">
          <section class="py-4 mx-md-5 px-md-5 px-2 dataSection shadow-sm">
            <h2 class="text-center py-3">Informações gerais</h2>
            <hr>
            <form method="POST" action="submit.php">
              <ul class="py-3">
                <li><div class="container">
                  <div class="row ">
                    <div class="col">
                      Temperatura máxima:
                    </div>
                    <div class="col">
                      <input type="text" id="maxTemp" class="form-control w-50" name="maxTemperature"
                      value="<?=$data->getValue()['maxTemp'];?>">
                    </div>
                  </div>
                </li>
                <li class="my-4"><div class="container">
                  <div class="row ">
                    <div class="col">
                      Temperatura mínima:
                    </div>
                    <div class="col">
                      <input type="text" id="minTemp" class="form-control w-50" name="minTemperature"
                      value="<?=$data->getValue()['minTemp'];?>">
                    </div>
                  </div>
                </li>
                <li class="my-4"><div class="container">
                  <div class="row ">
                    <div class="col">
                      Temperatura ideal:
                    </div>
                    <div class="col">
                      <input type="text" id="idealTemp" class="form-control w-50" name="idealTemp"
                      value="<?=$data->getValue()['idealTemp'];?>">
                    </div>
                  </div>
                </li>
                <li><div class="container">
                  <div class="row ">
                    <div class="col">
                      Data da última manutenção: 
                    </div>
                    <div class="col">
                      <input type="date" id="lastChecked" class="form-control w-50" name="lastCheckedDate"
                      value="<?= $data->getValue()['lastManutention'];?>">
                    </div>
                  </div>
                </li>
                <li class="my-4"><div class="container">
                  <div class="row ">
                    <div class="col">
                      Quantia de aferições para o alerta:
                    </div>
                    <div class="col">
                      <input type="text" id="alertNumber" class="form-control w-50" name="alertNumber"
                      value="<?=$data->getValue()['alertNumber'];?>">
                    </div>
                  </div>
                </li>
                <li><div class="container">
                  <div class="row ">
                    <div class="col">
                      Tempo entre aferições: 
                    </div>
                    <div class="col">
                      <input type="text" id="timeBetween" class="form-control w-50" name="timeBetween"
                      value="<?=$data->getValue()['timeBetween'];?>">
                    </div>
                  </div>
                </li>
              </ul>
            <hr>
            <h2 class="text-center py-3">Dados do responsável</h2>
            <hr>
              <ul class="py-3">
                <li><div class="container">
                  <div class="row ">
                    <div class="col">
                      Responsável técnico: 
                    </div>
                    <div class="col">
                      <input type="text" id="user" class="form-control w-50" name="user"
                      value="<?=$data->getValue()['user'];?>">
                    </div>
                  </div>
                </li>
                <li class="my-4"><div class="container">
                  <div class="row ">
                    <div class="col">
                      Número de telefone: 
                    </div>
                    <div class="col">
                      <input type="tel" id="phone" class="form-control w-50" name="phone"
                      value="<?=$data->getValue()['phone'];?>">
                    </div>
                  </div>
                </li>
                <li><div class="container">
                  <div class="row ">
                    <div class="col">
                      E-mail: 
                    </div>
                    <div class="col">
                      <input type="email" id="email" class="form-control w-50" name="email"
                      value="<?=$data->getValue()['email'];?>">
                    </div>
                  </div>
                </li>
              </ul>
              <hr>
              <div class="text-center pt-3">
                <button class="text-center w-25 submitButton py-1">Enviar</button>
              </div>
            </form>
        </section>
        </div>
      </div>
    </main>
   </body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</html>