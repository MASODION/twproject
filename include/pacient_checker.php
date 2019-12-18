<?php

    if($_SESSION['userLevel'] != 1) {
        header("location:home");
        exit;
    }

?>