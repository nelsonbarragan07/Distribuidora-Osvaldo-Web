<?php
  // configuramos los parametros de la conexion
  $servidor = "localhost";
  $usuario = "root";
  $pass = ""; // uds cadena vacía
  $bd = "distribuidora-osvaldo"; 
  
  // esteblecemos la conexión a la base de datos
  $con = mysqli_connect($servidor, $usuario, $pass, $bd);
  
  // verificamos la conexión
  if ($con){
	  //echo "Conexión exitosa";
  }
  else{
	  echo "Conexión fallida";	  
  }
  
  
  
  

?>