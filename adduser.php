<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once('db/db.php');

// Conexión a la base de datos
$conn = conectar();


//Recibimos por parametros los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user = $_POST['username'];
    $email = $_POST['correo'];
    $pass = $_POST['pass'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];




   $password_hash = password_hash($pass, PASSWORD_BCRYPT);

    
	// Preparar y enlazar
    $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, first_name, last_name) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error en la consulta: " . $conn->error);
    }
    $stmt->bind_param("sssss", $user, $email, $password_hash, $first_name, $last_name);

    if ($stmt->execute()) {
        echo "Registro exitoso!";
        echo '<a href="index.php">Inicio</a>';
    } else {
        echo "Error: " . $stmt->error;
    }

    

$stmt->close();


}



?>