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
  $deleteSQL = sprintf("DELETE FROM CLIENT WHERE ClientName=%s",
                       GetSQLValueString($_POST['deletefield'], "text"));

  mysql_select_db($database_remotesql, $remotesql);
  $Result1 = mysql_query($deleteSQL, $remotesql) or die(mysql_error());

  $deleteGoTo = "client.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_remotesql, $remotesql);
$query_RecordsetClient = "SELECT * FROM CLIENT ORDER BY ClientID ASC";
$RecordsetClient = mysql_query($query_RecordsetClient, $remotesql) or die(mysql_error());
$row_RecordsetClient = mysql_fetch_assoc($RecordsetClient);
$totalRows_RecordsetClient = mysql_num_rows($RecordsetClient);
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
			<div class="leftTiyle" id="flTitle">Function Three</div>
			<div class="thisUser">
				Current User: <?php echo $login_session; ?>
        		<button id="menu-logout" type="button">
				  Log Out
				</button>
			</div>
		</div>
		<div class="content">
		  <p>Client Information</p>
		  <p>&nbsp;</p>
		  <form name="form1" method="post" action="">
		    <table width="901" border="1">
		      <tr>
		        <td width="79">Client ID</td>
		        <td width="120">Client Name</td>
		        <td width="129">Email</td>
		        <td width="151">Phone</td>
		        <td width="191">Phone</td>
		        <td width="191">Option</td>
	          </tr>
		      <?php do { ?>
	          <tr>
	            <td><?php echo $row_RecordsetClient['ClientID']; ?></td>
	            <td><?php echo $row_RecordsetClient['ClientName']; ?></td>
	            <td><?php echo $row_RecordsetClient['Email']; ?></td>
	            <td><?php echo $row_RecordsetClient['Phone1']; ?></td>
	            <td><?php echo $row_RecordsetClient['Phone2']; ?></td>
	            <td><a href="editClient.php?id=<?php echo $row_RecordsetClient['ClientID']; ?>">Edit</a></td>
              </tr>
		        <?php } while ($row_RecordsetClient = mysql_fetch_assoc($RecordsetClient)); ?>
	        </table>
		    <p>Delete By Name: 
		      <label for="deletefield"></label>
		      <input type="text" name="deletefield" id="deletefield">
		      <input type="submit" name="button" id="button" value="Delete">
		    </p>
		   
		  </form>
           <p>
		      <a href="addClient.php"><input name="button2" type="submit" class="leftTiyle" id="button2" value="Create New Client.."></a>
		    </p>
		</div>
		
		
	</body>

</html>
<?php
mysql_free_result($RecordsetClient);
?>
