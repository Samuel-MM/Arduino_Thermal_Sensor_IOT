<?php
require __DIR__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;
$msg = '';
if(isset($_POST['maxTemperature'])){

  $factory = (new Factory())->withDatabaseUri('https://your-firebase-link.firebaseio.com/');

  $database = $factory->createDatabase();
  $information = [
    'maxTemp' => $_POST['maxTemperature'],
    'minTemp' => $_POST['minTemperature'],
    'idealTemp' => $_POST['idealTemp'],
    'lastManutention' => $_POST['lastCheckedDate'],
    'alertNumber' => $_POST['alertNumber'],
    'timeBetween' => $_POST['timeBetween'],
    'user' => $_POST['user'],
    'phone' => $_POST['phone'],
    'email' => $_POST['email']
  ];
  $database->getReference('data')->set($information);
  $msg = 'Sucesso!';
  header("Location: index.php");
}
