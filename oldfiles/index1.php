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
  $deleteSQL = sprintf("DELETE FROM PROJECT WHERE ProjectName=%s",
                       GetSQLValueString($_POST['deletefield'], "text"));

  mysql_select_db($database_remotesql, $remotesql);
  $Result1 = mysql_query($deleteSQL, $remotesql) or die(mysql_error());

  $deleteGoTo = "index1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_ProjectRecordset = 10;
$pageNum_ProjectRecordset = 0;
if (isset($_GET['pageNum_ProjectRecordset'])) {
  $pageNum_ProjectRecordset = $_GET['pageNum_ProjectRecordset'];
}
$startRow_ProjectRecordset = $pageNum_ProjectRecordset * $maxRows_ProjectRecordset;

mysql_select_db($database_remotesql, $remotesql);
$query_ProjectRecordset = "SELECT * FROM PROJECT";
$query_limit_ProjectRecordset = sprintf("%s LIMIT %d, %d", $query_ProjectRecordset, $startRow_ProjectRecordset, $maxRows_ProjectRecordset);
$ProjectRecordset = mysql_query($query_limit_ProjectRecordset, $remotesql) or die(mysql_error());
$row_ProjectRecordset = mysql_fetch_assoc($ProjectRecordset);

if (isset($_GET['totalRows_ProjectRecordset'])) {
  $totalRows_ProjectRecordset = $_GET['totalRows_ProjectRecordset'];
} else {
  $all_ProjectRecordset = mysql_query($query_ProjectRecordset);
  $totalRows_ProjectRecordset = mysql_num_rows($all_ProjectRecordset);
}
$totalPages_ProjectRecordset = ceil($totalRows_ProjectRecordset/$maxRows_ProjectRecordset)-1;
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
			<div class="bigTitle">Management System</div>
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
			<div class="leftTiyle" id="flTitle">Manage Projects</div>
			<div class="thisUser">
        
        Current User: <?php echo $login_session; ?>
        
        <button id="menu-logout" type="button">
				  Log Out
				</button>
      
      </div>
		</div>
		<div class="content" margin-top: 50px>
		  <form name="form1" method="post" action="">
		   
		    <table width="944" border="1">
		      <tr>
		        <td width="198">Project Name</td>
		        <td width="175">Flag Status</td>
		        <td width="209">Start Date</td>
		        <td width="220">End Date</td>
		        <td width="108">Option</td>
	          </tr>
              <?php do { ?>
              <tr>
                <td><?php echo $row_ProjectRecordset['ProjectName']; ?></td>
                <td><?php echo $row_ProjectRecordset['FlagStatus']; ?></td>
                <td><?php echo $row_ProjectRecordset['Start_Date']; ?></td>
                <td><?php echo $row_ProjectRecordset['End_Date']; ?></td>
                <td><a href="EditProject.php?name=<?php echo $row_ProjectRecordset['ProjectName']; ?>">Edit</a></td>
              </tr>
                <?php } while ($row_ProjectRecordset = mysql_fetch_assoc($ProjectRecordset)); ?>
            </table>
		    <p>Type Delete Project Name: 
		      <label for="deletefield"></label>
		      <input type="text" name="deletefield" id="deletefield">
		      <input type="submit" name="button2" id="button2" value="Delete">
		    </p>
		  </form>
        <p>
         <a href="function2.php"> <input name="button" type="submit" class="leftTiyle" id="button" value="Create New Project"></a>
        </p>
        
        </div>
        
	</body>

</html>
<?php
mysql_free_result($ProjectRecordset);
?>
