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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE EMPLOYEE SET EmployeeName=%s, Phone1=%s, Phone2=%s, Email=%s, HourlyRate=%s WHERE EmployeeID=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['phone1'], "int"),
                       GetSQLValueString($_POST['phone2'], "int"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['rate'], "double"),
                       GetSQLValueString($_POST['textfield'], "int"));

  mysql_select_db($database_remotesql, $remotesql);
  $Result1 = mysql_query($updateSQL, $remotesql) or die(mysql_error());

  $updateGoTo = "employees.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_remotesql, $remotesql);
$query_Recordset_edit = "SELECT * FROM EMPLOYEE";
$Recordset_edit = mysql_query($query_Recordset_edit, $remotesql) or die(mysql_error());
$row_Recordset_edit = mysql_fetch_assoc($Recordset_edit);
$totalRows_Recordset_edit = mysql_num_rows($Recordset_edit);$colname_Recordset_edit = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset_edit = $_GET['id'];
}
mysql_select_db($database_remotesql, $remotesql);
$query_Recordset_edit = sprintf("SELECT * FROM EMPLOYEE WHERE EmployeeID = %s", GetSQLValueString($colname_Recordset_edit, "int"));
$Recordset_edit = mysql_query($query_Recordset_edit, $remotesql) or die(mysql_error());
$row_Recordset_edit = mysql_fetch_assoc($Recordset_edit);
$totalRows_Recordset_edit = mysql_num_rows($Recordset_edit);
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
			<div class="leftTiyle" id="flTitle">Edit Employee Information</div>
			<div class="thisUser">
      Current User: <?php echo $login_session; ?>
        
        <button id="menu-logout" type="button">
				  Log Out
				</button>
      </div>
		</div>
		<div class="content">
        <h2>Edit Employee</h2>
        <form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
          <p>Employee ID: 
            <label for="textfield"></label>
            <input name="textfield" type="text" id="textfield" value="<?php echo $row_Recordset_edit['EmployeeID']; ?>" readonly>
          </p>
          <p>Employee Name:
            <label for="name"></label>
            <input name="name" type="text" id="name" value="<?php echo $row_Recordset_edit['EmployeeName']; ?>">
          </p>
          <p>Cell Phone:
            <label for="phone1"></label>
            <input name="phone1" type="text" id="phone1" value="<?php echo $row_Recordset_edit['Phone1']; ?>">
          </p>
          <p>Home Phone:
            <label for="phone2"></label>
            <input name="phone2" type="text" id="phone2" value="<?php echo $row_Recordset_edit['Phone2']; ?>">
          </p>
          <p>Email:
            <label for="email"></label>
            <input name="email" type="text" id="email" value="<?php echo $row_Recordset_edit['Email']; ?>">
          </p>
          <p>Hourly Rate:
            <label for="rate"></label>
            <input name="rate" type="text" id="rate" value="<?php echo $row_Recordset_edit['HourlyRate']; ?>">
          </p>
          <p>
            <input name="button" type="submit" class="leftTiyle" id="button" value="Submit">
          </p>
          <input type="hidden" name="MM_update" value="form1">
        </form>
        <p>&nbsp;</p>
        
        </div>
		
	</body>

</html>
<?php
mysql_free_result($Recordset_edit);
?>
