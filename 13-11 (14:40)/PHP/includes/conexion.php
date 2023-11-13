<?php
   ini_set('display_errors',1);
   ini_set('display_startup_errors',1);
   error_reporting(E_ALL);


   $conexion = new PDO('mysql:host=192.168.4.244;dbname=bolsa_trabajo', 'team0', 'Te@mteam123');
   //$conexion = new PDO('mysql:host=localhost;dbname=bolsa_trabajo', 'root', '');

?>