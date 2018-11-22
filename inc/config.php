<?php

// change the configuration with your own DB config

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "news";

$dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
