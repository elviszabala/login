<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

/**
 * 
 */

function conectar(){

	$servername = "localhost";
    $username = "";
    $password = "";
    $dbname = "";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}else{
	return $conn;
}

}









?>