<?php

    if($_SESSION['userLevel'] != 2) {
        header("location:home");
        exit;
    }

?>