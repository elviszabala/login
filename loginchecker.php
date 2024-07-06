<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once('db/db.php');
session_start();
if (!isset($_SESSION['username'])) {
 
}else{
  header("Location:index.php");
}


// Configurar opciones de sesión seguras
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_only_cookies', 1);
session_regenerate_id(true); // Regenerar el ID de sesión para prevenir fijación de sesión

// Conexión a la base de datos
$conn = conectar();

//Tomo los datos desde el form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user=$_POST['user'];
	$pass=$_POST['pass'];

 // Preparar y ejecutar la consulta para obtener el hash de la contraseña
    $stmt = $conn->prepare("SELECT password_hash, email FROM users WHERE username = ?");
     if (!$stmt) {
        die("Error en la consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($password, $email);
    $stmt->fetch();
    
    // Verificar la contraseña
    if ($password && password_verify($pass, $password)) {
        echo "Inicio de sesión exitoso!";
        $_SESSION['username']= $user;
        
        header("Location:index.php");


    } else {
        echo "Nombre de usuario o contraseña incorrectos.";
        
        header("Location:login.php");
    }

    $stmt->close();
}

$conn->close();




?>