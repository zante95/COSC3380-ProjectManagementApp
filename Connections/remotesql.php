<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_remotesql = "198.71.240.28";
$database_remotesql = "projectmanagementapp";
$username_remotesql = "junren";
$password_remotesql = "1441891";
$remotesql = mysql_pconnect($hostname_remotesql, $username_remotesql, $password_remotesql) or trigger_error(mysql_error(),E_USER_ERROR); 
?>