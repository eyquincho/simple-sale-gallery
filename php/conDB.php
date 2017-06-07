﻿<?php
// definimos unas constanstes 
// para la conexion a la DB
define('_SERV','localhost'); // Servidor
define('_USER','root'); 	 // usuario de la DB
define('_PASS','pass'); 		 // password de la DB
define('_DATAB','nombre_tabla'); 	 // nombre de la tabla

// funcion para conexion a MYSQL
function conexionDB()
{
   if (!($cnx=mysqli_connect(_SERV,_USER,_PASS))) {
      echo "Error conectando a la base de datos.";
      exit();
   }
   if (!mysqli_select_db($cnx, _DATAB)) {
      echo "Error seleccionando la base de datos.";
      exit();
   }
   return $cnx;
}
$linkcon=mysqli_connect(_SERV,_USER,_PASS,_DATAB);
$linkcon->set_charset("utf8");
$_SESSION['con']= $linkcon;
?>