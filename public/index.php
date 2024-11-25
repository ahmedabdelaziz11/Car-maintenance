<?php

define("DS",DIRECTORY_SEPARATOR);
define("ROOT",dirname(__DIR__).DS);
define("APP",ROOT."app".DS);
define("CONTROLLER",APP."Controllers".DS);
define("CORE",APP."core".DS);
define("MODEL",APP."Models".DS);
define("VIEW",APP."views".DS);
define("CONFIG",APP."config".DS);
define("BASE_URL", "http://localhost/car/public");


// config 
define("SERVER","localhost");
define("USERNAME","root");
define("PASSWORD","");
define("DATABASE","cars");
define("DATABASE_TYPE","mysql");
define("DOMAIN_NAME","http://localhost/");

require_once ("../vendor/autoload.php");

require_once '../app/core/helpers.php';

$app = new MVC\core\app();