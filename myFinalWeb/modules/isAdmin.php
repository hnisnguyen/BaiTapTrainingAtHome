<?php

if(isset($_SESSION["role"]) && ($_SESSION["role"] == 1 || $_SESSION["role"] == 2)){
    header("location: admin/dashboard/index.php");
    exit;
} else {
    header("location: user/index.php");
    exit;
}
?>