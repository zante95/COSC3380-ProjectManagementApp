<?php require_once('Connections/remotesql.php'); ?>
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
  $updateSQL = sprintf("UPDATE PROJECT SET ProjectName=%s, ProjectLeaderID=%s, FlagStatus=%s, Revenue=%s, Start_Date=%s, End_Date=%s WHERE ProjectID=%s",
                       GetSQLValueString($_POST['projectname'], "text"),
                       GetSQLValueString($_POST['projectid'], "int"),
                       GetSQLValueString($_POST['select'], "text"),
                       GetSQLValueString($_POST['revenue'], "double"),
                       GetSQLValueString($_POST['sdate'], "date"),
                       GetSQLValueString($_POST['edate'], "date"),
                       GetSQLValueString($_POST['projectid'], "int"));

  mysql_select_db($database_remotesql, $remotesql);
  $Result1 = mysql_query($updateSQL, $remotesql) or die(mysql_error());

  $updateGoTo = "index1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['name'])) {
  $colname_Recordset1 = $_GET['name'];
}
mysql_select_db($database_remotesql, $remotesql);
$query_Recordset1 = sprintf("SELECT ProjectID, ProjectName, ProjectLeaderID, FlagStatus, Revenue, Start_Date, End_Date FROM PROJECT WHERE ProjectName = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $remotesql) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset_Edit = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset_Edit = $_GET['id'];
}
mysql_select_db($database_remotesql, $remotesql);
$query_Recordset_Edit = sprintf("SELECT * FROM PROJECT WHERE ProjectID = %s", GetSQLValueString($colname_Recordset_Edit, "int"));
$Recordset_Edit = mysql_query($query_Recordset_Edit, $remotesql) or die(mysql_error());
$row_Recordset_Edit = mysql_fetch_assoc($Recordset_Edit);
?>
<?php include 'Source/connect.php';?>
<?php include('Module/Login/session.php'); ?>
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
			<div class="leftTiyle" id="flTitle">Edit Project</div>
			<div class="thisUser">
				Current User: <?php echo $login_session; ?>
        
        		<button id="menu-logout" type="button">
				  Log Out
				</button>
			</div>
		</div>
		<div class="content">
		  <form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
		    <p>Edit Project: 
		      <label for="projectid"></label>
		      <input name="projectid" type="text" id="projectid" value="<?php echo $row_Recordset1['ProjectID']; ?>" readonly>
            </p>
		    <p>
		      <label for="projectname">Project Name:</label>
		      <input name="projectname" type="text" id="projectname" value="<?php echo $row_Recordset1['ProjectName']; ?>">
	        </p>
		    <p>
		      <label for="leaderid">Leader ID: </label>
		      <input name="leaderid" type="text" id="leaderid" value="<?php echo $row_Recordset1['ProjectLeaderID']; ?>">
		      <label for="revenue"></label>
	        </p>
		    <p>
		      <label for="select">Flag Status: </label>
		      <select name="select" id="select">
              <option value="A">A</option>
 			 <option value="I">I</option>
	          </select>
		      <br>
		      <label for="checkbox"></label>
		    </p>
		    <p>Revenue: 
		      <input name="revenue" type="text" id="revenue" value="<?php echo $row_Recordset1['Revenue']; ?>">
	        </p>
		    <!--
			<p>
		      <label for="netgain">NetGain: </label>
		      <input type="text" name="netgain" id="netgain">
		    </p>
			-->
		    <p>
		      <label for="sdate">Start Date: (YYYY-MM-DD)</label>
		      <input name="sdate" type="text" id="sdate" value="<?php echo $row_Recordset1['Start_Date']; ?>">
		    </p>
		    <p>
		      <label for="edate">End Date: (YYYY-MM-DD)</label>
		      <input name="edate" type="text" id="edate" value="<?php echo $row_Recordset1['End_Date']; ?>">
		    </p>
		    <p>
		      <input type="submit" name="button" id="button" value="Submit">
            </p>
		    <input type="hidden" name="MM_update" value="form1">
		  </form>
		</div>
		
	</body>

</html>
<?php
mysql_free_result($Recordset1);
?>
