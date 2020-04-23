<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_newConn12 = "localhost";
$database_newConn12 = "projectmanagementapp";
$username_newConn12 = "junren";
$password_newConn12 = "1441891";
$newConn12 = mysql_pconnect($hostname_newConn12, $username_newConn12, $password_newConn12) or trigger_error(mysql_error(),E_USER_ERROR); 
?>