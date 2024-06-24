<?php
require './DataBase.php';
require './controller/DataController.php';

//pt a lua url ul si a - l imparti intr un array cu segmente
function getSegments(): string
{
    if (isset($_SERVER['PATH_INFO'])) {
        return trim($_SERVER['PATH_INFO'], '/');
    }
    return '';
}

$method = $_SERVER['REQUEST_METHOD'];
$route = getSegments();

$dbConnection = new DataBase();
$controller = new DataController($dbConnection);

//partea de rutare
$routes = [
    'upload' => function() use ($controller) {
        $controller->processRequest('upload');
    },
    'update/description' => function() use ($controller) {
        $controller->processRequest('update/description');
    },
    'update/name' => function() use ($controller) {
        $controller->processRequest('update/name');
    },
    'update/image' => function() use ($controller) {
        $controller->processRequest('update/image');
    },
    'update/type' => function() use ($controller) {
        $controller->processRequest('update/type');
    },
    'get/drugsName' => function() use ($controller) { // Noua rută pentru a obține lista de droguri
        $controller->processRequest('get/drugsName');
    },
    'delete/drug' => function() use ($controller) { // Noua rută pentru a șterge un drog
        $controller->processRequest('delete/drug');
    },
    'add/drug' => function() use ($controller) {
        $controller->processRequest('add/drug');
    },
    'drug/details' => function() use ($controller) { // Rută nouă pentru detalii
        $controller->processRequest('drug/details');
    },
    'drug/graph' => function() use ($controller) { // Rută nouă pentru datele grafice
        $controller->processRequest('drug/graph');
    },
    'get/allDrugs' => function() use ($controller) {
        $controller->processRequest('get/allDrugs');
    },
    'generateDataInJudete' => function() use ($controller) {
    $controller->processRequest('generateDataInJudete');
    },
    'getDataFromJudete' => function() use ($controller) {
        $controller->processRequest('getDataFromJudete');
    },
    'generateDataInCampanii' => function() use ($controller) {
    $controller->processRequest('generateDataInCampanii');
    },
    'generateDataInInfractiuni' => function() use ($controller) {
    $controller->processRequest('generateDataInInfractiuni');
    },
    'generateDataInUrgenteMedicale' => function() use ($controller) {
    $controller->processRequest('generateDataInUrgenteMedicale');
    },
    'contact' => function() use ($controller) {

       $controller->processRequest('contact');

    }
    // Adăugați aici alte rute...
];




if ($method == 'POST') {
    if (isset($routes[$route])) {
        $routes[$route]();
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Route not found"]);
    }
} else if ($method == 'GET' && isset($routes[$route])) {
    $routes[$route]();
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
}
?>
