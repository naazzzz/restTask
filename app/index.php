<?php
global $entityManager;

require $_SERVER['DOCUMENT_ROOT']."/src/controllers/Settings.php";
use controllers\Settings;



$controller = null;
$action = null;


$uri_pattern = explode('/', "/v1/{controller}/{action}");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);


if (count($uri) < count($uri_pattern)) {
    header("HTTP/1.1 404 Not Found");
    exit();
} else
{
    for ($x = 0; $x < count($uri); $x++) {
        if ($x < count($uri_pattern)) {
            if ($uri_pattern[$x] == "{controller}") {
                $controller = $uri[$x];
            } else
                if ($uri_pattern[$x] == "{action}") {
                $action = $uri[$x];
            } else
                if ($uri_pattern[$x] != $uri[$x]) {
                header("HTTP/1.1 404 Not Found");
                exit();
            }
        }
    }
}


$settings = new Settings($entityManager);
$controllerInstance=$settings->GetControllerInstance($controller);
if ($controllerInstance == null) {
    header("HTTP/1.1 404 Not Found");
    exit();
}


$method = $_SERVER["REQUEST_METHOD"];
switch ($method) {
    case "POST":
        $json=file_get_contents("php://input");
        $obj=json_decode($json,true);
        $controllerInstance->{$action . 'PostAction'}($obj);
        break;
    default:
        $controllerInstance->{$action . 'Action'}($_GET);
        break;
}