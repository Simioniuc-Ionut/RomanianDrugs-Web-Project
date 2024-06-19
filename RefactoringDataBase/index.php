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
    // Adăugați aici alte rute...
];




if ($method == 'POST') {
    if (isset($routes[$route])) {
        $routes[$route]();
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Route not found"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
}
?>
