<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

class Conexion2{
	var $mysqli;
	//Lista de Tablas
	
/* FUNCION QUE CONECTA LA BASE DE DATOS CON EL SISTEMA PHP */
	public function __construct(){
		//conexion de la base de datos
		$this->mysqli=new mysqli('localhost', 'elvis_geve', 'Qb6AG~6f)4~_', 'elvis_log', '3306'); /* SERVIDOR LOCAL, USUARIO, CLAVE, BASE DE DATOS */
		/* comprobar la conexión */
		if ($this->mysqli->connect_errno) {
			printf("FALLÓ LA CONEXION CON LA BASE DE DATOS. Inicie el servidor donde está alojada o reinicie los servicios", $this->mysqli->connect_error);
			exit();
		}
	}
	/* FUNCION QUE DEVUELVE LOS REGISTROS QUE COINCIDAN CON LA BUSQUEDA EN LA BASE DATOS */
	public function consultar($sql){
		$this->mysqli->set_charset("utf8");
		$consulta = $this->mysqli->query($sql)or die("ERROR DE CONSULTA A LA BASE DE DATOS: ".$this->mysqli->error."CODIGO DE ERROR: ".$this->mysqli->errno);
		$fila = $consulta->fetch_array(MYSQLI_ASSOC); //si exite datos en la consulta de la base de datos
		return $fila;                                        //retorna 
		$consulta->close();  		                        // cerrar la consulta
		$this->mysqli->close();                             // cerrar la conexión
	}		
		/* FUNCION QUE DEVUELVE EL PRIMER REGISTRO QUE COINCIDA CON LA BUSQUEDA EN LA BASE DATOS */
	public function consultar2($sql){
		$this->mysqli->set_charset("utf8");
		$consulta = $this->mysqli->query($sql)or die("ERROR DE CONSULTA A LA BASE DE DATOS: ".$this->mysqli->error."CODIGO DE ERROR: ".$this->mysqli->errno);
		return $consulta;                                        //retorna 
		$consulta->close();  		                        // cerrar la consulta
		$this->mysqli->close();                             // cerrar la conexión
	}
		/* FUNCION QUE DEVUELVE LA CANTIDAD DE REGISTROS QUE COINCIDAN CON LA BUSQUEDA EN LA BASE DATOS */
	public function contar_filas($sql){
		$consulta = $this->mysqli->query($sql)or die("ERROR DE CONSULTA A LA BASE DE DATOS: ".$this->mysqli->error."CODIGO DE ERROR: ".$this->mysqli->errno);
		$consulta->num_rows; 		        //determinar el número de filas de la consulta */
		return $consulta->num_rows;         //retorna el numero total de registros de la consulta
		$consulta->close();
		$this->mysqli->close();
	}	   
	public function insertar($sql){
		$guardo=NULL;
		$this->mysqli->set_charset("utf8");
		$guardo = $this->mysqli->query($sql)or die("ERROR DE CONSULTA A LA BASE DE DATOS: ".$this->mysqli->error."CODIGO DE ERROR: ".$this->mysqli->errno);
		return $guardo;         //retorna el numero total de registros de la consulta
		$guardo->close();
		$this->mysqli->close();
	}	   
	public function editar($sql){
		$editar=NULL;
		$this->mysqli->set_charset("utf8");
		$editar = $this->mysqli->query($sql)or die("ERROR DE CONSULTA A LA BASE DE DATOS: ".$this->mysqli->error."CODIGO DE ERROR: ".$this->mysqli->errno);
		return $editar;         //EDITAR LOS NUMERO DE REGISTROS
		$editar->close();
		$editar->free();
		$this->mysqli->close();
	}
	
	public function eliminar($sql){
		$eliminar=NULL;
		$this->mysqli->set_charset("utf8");
		$eliminar = $this->mysqli->query($sql)or die("ERROR DE CONSULTA A LA BASE DE DATOS: ".$this->mysqli->error."CODIGO DE ERROR: ".$this->mysqli->errno);
		return $eliminar;         //EDITAR LOS NUMERO DE REGISTROS
		$eliminar->close();
		$eliminar->free();
		$this->mysqli->close();
	}

	
}

/**
 * 
 */

function conectar(){

	$servername = "localhost";
    $username = "elvis_geve";
    $password = "Qb6AG~6f)4~_";
    $dbname = "elvis_log";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}else{
	return $conn;
}

}









?>