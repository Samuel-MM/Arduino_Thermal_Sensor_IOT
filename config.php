<?php
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory())->withDatabaseUri('https://sefitel-416a0-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();
$temperature = $database->getReference('temperature: ')->getSnapshot();
?>