<?php

    class Functions {

        public static function getBlogPosts($conn) {
            $check = $conn->prepare("SELECT * FROM blog ORDER BY bID DESC");
            $check->execute();
            $countlog = $check->rowCount();
            if($countlog >= 1) {
                $row = $check->fetch();
                while($row != null) {
                    $array[] = $row;
                    $row = $check->fetch();
                }
                return $array;
            }
            else return null;
        }

        public static function trimitemesaj($msg1, $msg2) {
            if($_SESSION['lang'] == "eng") {
                return $msg2;
            }
            else return $msg1;
        }

    }


?>