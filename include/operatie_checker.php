<?php

    if($_SESSION['userLevel'] != 5) {
        header("location:home");
        exit;
    }

?>