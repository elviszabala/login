<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once('db/db.php');

$conn = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = trim($_POST['new_password']);
    
    // Validación de la entrada
    if (empty($new_password)) {
        echo "El campo de nueva contraseña es obligatorio.";
        exit;
    }
    
    // Buscar el token en la base de datos
    $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ?");
    if (!$stmt) {
        die("Error en la consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();
    
    if ($email) {
        // Encriptar la nueva contraseña
        $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);
        
        // Actualizar la contraseña en la tabla de usuarios
        $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
        if (!$stmt) {
            die("Error en la consulta: " . $conn->error);
        }
        $stmt->bind_param("ss", $new_password_hash, $email);
        if ($stmt->execute()) {
            // Eliminar el token de restablecimiento
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
            if ($stmt) {
                $stmt->bind_param("s", $token);
                $stmt->execute();
                $stmt->close();
            }
            echo "Su contraseña ha sido restablecida con éxito.";
        } else {
            echo "Error al actualizar la contraseña: " . $stmt->error;
        }
    } else {
        echo "Token inválido o expirado.";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Restablecer Contraseña</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Geve </b>nis</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Restablecer Contraseña</p>

      <form action="reset_password.php" method="post">
        <div class="input-group mb-3">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>" required>
          <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Nueva Contraseña">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
        </div>
        
        <div class="row">
         <div class="col-8">
            
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" value="enviar" name="enviar">Enviar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     <div class="row">
            &nbsp;
          </div>

      
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html> 
