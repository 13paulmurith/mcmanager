<?php
error_reporting(E_ERROR | E_PARSE);
include_once 'minecraft.php';
function getServerStatus($serverip){
    $status = new MinecraftServerQuery();
    $response = $status->getStatus($serverip);
    return $response;
}
?>