<?php

    if($_SESSION['userLevel'] != 3) {
        header("location:home");
        exit;
    }

?>