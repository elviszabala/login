<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once('db/db.php');

$conn = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Validar entrada
    if (empty($email)) {
        echo "Por favor, introduce tu correo electrónico.";
        exit;
    }

    // Comprobar si el correo electrónico existe en la base de datos
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
     if (!$stmt) {
        die("Error en la consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    if (!$user_id) {
        echo "No se encontró una cuenta con ese correo electrónico." . $email;
        exit;
    }

    // Generar un token de restablecimiento
    $token = bin2hex(random_bytes(50));
    $expires_at = date("Y-m-d H:i:s", strtotime('+1 hour'));

    // Guardar el token en la base de datos
    $stmt = $conn->prepare("INSERT INTO password_resets (id, email, token, expires_at) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Error en la consulta de la tabla password_resets: " . $conn->error);
    }
    $stmt->bind_param("isss", $user_id, $email, $token, $expires_at);
    $stmt->execute();
    $stmt->close();



    // Enviar el correo electrónico con el enlace de restablecimiento
    $reset_link = "http://elvis.dtn.cl/log/reset_password.php?token=$token";
    $subject = "Restablecimiento de Contraseña";
    $message = "Haz clic en el siguiente enlace para restablecer tu contraseña: $reset_link";
    $headers = "From: no-reply@elvis.dtn.cl/log";

    if (mail($email, $subject, $message, $headers)) {
        echo "Se ha enviado un enlace de restablecimiento a tu correo electrónico.";
    } else {
        echo "Error al enviar el correo electrónico.";
    } 
}

$conn->close();
?>

