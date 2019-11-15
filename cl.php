<?php

    if(!isset($_GET['lang']) || empty($_GET['lang'])) {
        header("location:index");
        exit;
    }

    if(isset($_GET['lang']) && !empty($_GET['lang'])) {
        $id = $_GET['lang'];
        if($id == "eng") {
          $_SESSION['lang'] = "eng";
        }
        else $_SESSION['lang'] = "ro";
        header("location:blog");
        exit;
    }

?>

<html>

<head>

<title>schimbare limba</title>

</head>

<body>

</body>

</html>