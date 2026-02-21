<?php 

$start_time = microtime(true);

require_once('./../config/config.php');
require_once( ROOT . '/vendor/autoload.php' );
require_once( HELPERS . '/helpers.php' );

use Core\Application;
$app = new Application();
require_once( APP . '/routes.php' );
$app->run();

echo "<p>Excecuted in: " . microtime(true) - $start_time . '</p>';