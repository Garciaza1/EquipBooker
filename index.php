<?php

require_once("vendor/autoload.php");

use EquipReservs\System\Router;

session_start();

Router::dispatch();
