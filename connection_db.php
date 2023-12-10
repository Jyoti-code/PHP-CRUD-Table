<?php

$username = "root";
$passwoed = "";
$server = 'localhost';
$db = 'webgradetech';

$con = mysqli_connect($server,$username,$passwoed,$db);

if(!$con){
    // echo 'connection successful';
    ?>
    <script>
        alert('connection unsuccessfull');
    </script>
    <?php
}

?>