<link href="Assets/css/style.css" rel="stylesheet" />

<?php
require_once('Controller/Routeur.php');

$router = new Router();
$router->routeReq();