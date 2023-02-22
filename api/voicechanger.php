<?php
/**
 * Created by PhpStorm.
 * User: ussaidiqbal
 * Date: 2021-06-21
 * Time: 12:00
 */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods', '*');
header('Access-Control-Allow-Headers', 'api-key,content-type');
header('Access-Control-Allow-Credentials', true);
include "../includes/parse-config.php";

$response = array();
$response["success"] = 0;
$response["message"] = "Unknown request: 404!";

if(isset($_POST["WHICH"]) && isset($_POST["FILE-URL"])){


}
echo json_encode($response);