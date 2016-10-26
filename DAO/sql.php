<?php

$host = "localhost";

$user = "root";

$pass = "";

$db = "cei-top-kids-bd";

$conn = mysql_connect($host, $user, $pass) or die (mysql_error());

@mysql_select_db($db);

?>