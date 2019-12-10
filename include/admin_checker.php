<?php

    if($_SESSION['userLevel'] != 4) {
        header("location:home");
        exit;
    }

?>