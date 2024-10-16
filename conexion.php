<?php
    $dbHost='127.0.0.1';
    $dbName='bd_acrivera';
    $dbUser='root';
    $dbPass="";
    $con=mysqli_connect($dbHost,$dbUser,$dbPass,$dbName);
    try{
        if(isset($con)){
            return $con;
			echo"conexion yes";
        }
    }catch(Exception $ex){
        echo $ex=getMessage();
        echo 'error';
    }
?>