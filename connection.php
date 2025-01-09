<?php

$dbhost = "sql213.infinityfree.com";
$dbuser = "if0_37727561";
$dbpass = "dRBfkWNzEQj";
$dbname = "if0_37727561_logindata";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}
