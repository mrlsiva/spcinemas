<?php
// Local (XAMPP)
$connect = new PDO('mysql:host=127.0.0.1:3307;dbname=spcinemas;charset=utf8mb4', 'root', '');

// Live server — comment out the local line above and uncomment this one when deploying:
// $connect = new PDO('mysql:host=localhost;dbname=spcinemas;charset=utf8mb4', 'siva', 'spcinemas@123');

$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);