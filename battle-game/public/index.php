<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
//Cand un utilizator acceseaza aplicatia ta, serverul ruleaza exact acest fisier index.php
//porneste motorul Laravel
define('LARAVEL_START', microtime(true));


//Daca lucrezi la site-ul tau live si vrei sa il opresti temporar pentru utilizatori (folosind comanda php artisan down),
// Laravel creeaza acel fisier maintenance.php
// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}


//El apeleaza compozitorul de pachete (vendor/autoload.php) si apoi porneste scriptul din folderul bootstrap/app.php
// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';
// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';


// Request::capture() aduna toate datele trimise de utilizator, iar handleRequest() porneste rutele si
// trimite raspunsul inapoi (ex: JSON-ul cu lupta).
$app->handleRequest(Request::capture());
