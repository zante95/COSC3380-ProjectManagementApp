<?php require_once('Connections/remotesql.php'); ?>
<?php include 'Source/connect.php';?>
<?php include('Module/Login/session.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO EMPLOYEE (EmployeeName, Phone1, Phone2, Email, HourlyRate) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['phone1'], "int"),
                       GetSQLValueString($_POST['phone2'], "int"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['rate'], "double"));

  mysql_select_db($database_remotesql, $remotesql);
  $Result1 = mysql_query($insertSQL, $remotesql) or die(mysql_error());

  $insertGoTo = "employees.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>Index</title>
		<link rel="stylesheet" href="css/page.css" />
		<script type="text/javascript" src="js/jquery.min.js" ></script>
		<script type="text/javascript" src="js/index.js" ></script>
    <script type="text/javascript">
      $(function(){
        $('#menu-logout').click(function(){
        
          window.location.href = "Module/Login/close.php";
        
        });
        
      });
    </script>
	</head>

	<body>
		<div class="left">
			<div class="bigTitle">Project Management System</div>
			<div class="lines">
      <? $sql_menu = "SELECT MENU.MenuName, MENU.url FROM MENU, ASSIGNED_MENU WHERE MENU.MenuID = ASSIGNED_MENU.MenuID AND ASSIGNED_MENU.Username = '$login_session'";

$result_menu = $conn->query($sql_menu);

while($row_menu = $result_menu->fetch_array()){
?>
				<a href="<? echo $row_menu[1]; ?>"><div onclick="pageClick(this)"> <? echo $row_menu[0]; ?> </div></a>
<?
}
?>
			</div>
		</div>
		<div class="top">
			<div class="leftTiyle" id="flTitle">Function Two</div>
			<div class="thisUser">
      Current User: <?php echo $login_session; ?>
        
        <button id="menu-logout" type="button">
				  Log Out
				</button>
      </div>
		</div>
		<div class="content">
        <h2>Add New Employee</h2>
        <form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
          <p>&nbsp;</p>
          <p>Employee Name:
            <label for="name"></label>
            <input type="text" name="name" id="name">
          </p>
          <p>Cell Phone:
            <label for="phone1"></label>
            <input type="text" name="phone1" id="phone1">
          </p>
          <p>Home Phone:
            <label for="phone2"></label>
            <input type="text" name="phone2" id="phone2">
          </p>
          <p>Email:
            <label for="email"></label>
            <input type="text" name="email" id="email">
          </p>
          <p>Hourly Rate:
            <label for="rate"></label>
            <input type="text" name="rate" id="rate">
          </p>
          <p>
            <input name="button" type="submit" class="leftTiyle" id="button" value="Submit">
          </p>
          <input type="hidden" name="MM_insert" value="form1">
        </form>
        <p>&nbsp;</p>
        
        </div>
		
	</body>

</html>