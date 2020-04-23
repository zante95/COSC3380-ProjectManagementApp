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

if ((isset($_POST['deletefield'])) && ($_POST['deletefield'] != "")) {
  $deleteSQL = sprintf("DELETE FROM EMPLOYEE WHERE EmployeeName=%s",
                       GetSQLValueString($_POST['deletefield'], "text"));

  mysql_select_db($database_remotesql, $remotesql);
  $Result1 = mysql_query($deleteSQL, $remotesql) or die(mysql_error());

  $deleteGoTo = "employees.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_remotesql, $remotesql);
$query_Recordset1 = "SELECT * FROM EMPLOYEE ORDER BY EmployeeID ASC";
$Recordset1 = mysql_query($query_Recordset1, $remotesql) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
			<div class="leftTiyle" id="flTitle">Function Four</div>
			<div class="thisUser">
				Current User: <?php echo $login_session; ?>
        		<button id="menu-logout" type="button">
				  Log Out
				</button>
			</div>
		</div>
		<div class="content">
        <h2>Employee Information</h2>
		  <form name="form1" method="POST">
		    <table width="997" border="1">
		      <tr>
		        <td width="152">Employee ID</td>
		        <td width="204">Employee Name</td>
		        <td width="124">Cell Phone</td>
		        <td width="129">Home Phone</td>
		        <td width="130">Email</td>
		        <td width="147">Hour Rate</td>
		        <td width="65">Option</td>
	          </tr>
		      <?php do { ?>
	          <tr>
	            <td><?php echo $row_Recordset1['EmployeeID']; ?></td>
	            <td><?php echo $row_Recordset1['EmployeeName']; ?></td>
	            <td><?php echo $row_Recordset1['Phone1']; ?></td>
	            <td><?php echo $row_Recordset1['Phone2']; ?></td>
	            <td><?php echo $row_Recordset1['Email']; ?></td>
	            <td><?php echo $row_Recordset1['HourlyRate']; ?></td>
	            <td><a href="editEmployee.php?id=<?php echo $row_Recordset1['EmployeeID']; ?>">Edit</a></td>
              </tr>
		        <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
	        </table>
		    <p>Delete By Name: 
		      <label for="deletefield"></label>
		      <input type="text" name="deletefield" id="deletefield">
		      <input type="submit" name="button" id="button" value="Delete">
		    </p>
		    <p>&nbsp;</p>
		  </form>
         <a href="addEmployee.php"> <input name="" type="button" class="leftTiyle" value="Create New Employee.."></a>
		</div>
		
	</body>

</html>
<?php
mysql_free_result($Recordset1);
?>
