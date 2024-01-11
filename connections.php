<?php
$localhost = "localhost";
$dbname = "ite152";
$username = "postgres";
$password = "paraiso";

$con = pg_connect("host=$localhost dbname=$dbname user=$username password=$password");
if(!$con){
    die("failed to connect");
}
?>
