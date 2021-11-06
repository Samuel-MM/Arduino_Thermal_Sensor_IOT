<?php
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory())->withDatabaseUri('https://your-firebase-link.firebaseio.com/');

$database = $factory->createDatabase();
$temperature = $database->getReference('temperature: ')->getSnapshot();
$data = $database->getReference('data')->getSnapshot();
?>