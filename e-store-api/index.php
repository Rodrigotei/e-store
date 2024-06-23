<?php

use Api\ApplicationGET;
use Api\ApplicationPOST;

include 'settings/config.php';
include 'vendor/autoload.php';


$method = $_SERVER['REQUEST_METHOD'];


//$endpoint[0] => page
//$endpoint[1] => parameter


switch ($method){
    case 'GET':
        if(!empty($_GET['url'])){
            $endpoint = explode('/',$_GET['url']);
            $parameter = isset($endpoint[1]) ? $endpoint[1] : '';
            $app = new ApplicationGET;
            $response = $app->initApp($endpoint[0], $parameter);
            echo json_encode($response);
        }else{
            echo json_encode('PAGE DEFAULT');
        }
        break;
    case 'POST':
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $app = new ApplicationPOST;
            $response = $app->initApp($data);
            echo json_encode($response);
        } else {
            echo json_encode('Invalid JSON');
        }
        break;
    default:
        echo json_encode('ERROR');
        exit;
}