<?php



$servername = "localhost";

$username = "root";

$password = "";

$db = "cabinet";

$pw_sare = "465dtF2WcqrnlB0qcD6yHvmpfdNOqkirYChEpppKr1tYeRZxUnl0Xio6fqTaPEsjWzIw5QRUE2AMDkQAyEjXqmfDBnw9j9SHiLvUD7NpmIAQ2kmORJHdTZ9H";
$pw_piper = "qwW5y4ljUUn8txHicg6qZ4eNeAy485A6z6dBrXduaw6gO6dJElNpxxpGqmaCXm6mxjxdAtX2rwMqjmpc6IZ1AF7EBdd6qzcYkWBsuM2tITPR2Mg21IWVUq0j";



try 

{

    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);

    // set the PDO error mode to exception

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}

catch(PDOException $e)

{

	echo 'nu';

}

$status = session_status();

if($status == PHP_SESSION_NONE){

    //There is no active session

    session_start();

}



if(!isset($_SESSION['lang']) || empty($_SESSION['lang'])) {

    $_SESSION['lang'] = "ro";

}



?>

