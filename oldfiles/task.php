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

$currentPage = $_SERVER["PHP_SELF"];

if ((isset($_POST['deletefield'])) && ($_POST['deletefield'] != "")) {
  $deleteSQL = sprintf("DELETE FROM TASK WHERE TaskID=%s",
                       GetSQLValueString($_POST['deletefield'], "int"));

  mysql_select_db($database_remotesql, $remotesql);
  $Result1 = mysql_query($deleteSQL, $remotesql) or die(mysql_error());

  $deleteGoTo = "task.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_TaskRecordset = 10;
$pageNum_TaskRecordset = 0;
if (isset($_GET['pageNum_TaskRecordset'])) {
  $pageNum_TaskRecordset = $_GET['pageNum_TaskRecordset'];
}
$startRow_TaskRecordset = $pageNum_TaskRecordset * $maxRows_TaskRecordset;

mysql_select_db($database_remotesql, $remotesql);
$query_TaskRecordset = "SELECT * FROM TASK";
$query_limit_TaskRecordset = sprintf("%s LIMIT %d, %d", $query_TaskRecordset, $startRow_TaskRecordset, $maxRows_TaskRecordset);
$TaskRecordset = mysql_query($query_limit_TaskRecordset, $remotesql) or die(mysql_error());
$row_TaskRecordset = mysql_fetch_assoc($TaskRecordset);

if (isset($_GET['totalRows_TaskRecordset'])) {
  $totalRows_TaskRecordset = $_GET['totalRows_TaskRecordset'];
} else {
  $all_TaskRecordset = mysql_query($query_TaskRecordset);
  $totalRows_TaskRecordset = mysql_num_rows($all_TaskRecordset);
}
$totalPages_TaskRecordset = ceil($totalRows_TaskRecordset/$maxRows_TaskRecordset)-1;

$queryString_TaskRecordset = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_TaskRecordset") == false && 
        stristr($param, "totalRows_TaskRecordset") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_TaskRecordset = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_TaskRecordset = sprintf("&totalRows_TaskRecordset=%d%s", $totalRows_TaskRecordset, $queryString_TaskRecordset);
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
		   
		    <table width="1256" border="1">
		      <tr>
		        <td width="146">Task ID</td>
		        <td width="212">Description</td>
		        <td width="159">Start Date</td>
		        <td width="154">Due date</td>
		        <td width="164">Finish Date</td>
		        <td width="162">Flag Status</td>
		        <td width="163">Flag Active</td>
		        <td width="44">Option</td>
	          </tr>
              <?php do { ?>
              <tr>
                <td><?php echo $row_TaskRecordset['TaskID']; ?></td>
                <td><?php echo $row_TaskRecordset['Description']; ?></td>
                <td><?php echo $row_TaskRecordset['StartDate']; ?></td>
                <td><?php echo $row_TaskRecordset['DueDate']; ?></td>
                <td><?php echo $row_TaskRecordset['FinishDate']; ?></td>
                <td><?php echo $row_TaskRecordset['FlagStatus']; ?></td>
                <td><?php echo $row_TaskRecordset['FlagActive']; ?></td>
                <td><a href="editTask.php?id=<?php echo $row_TaskRecordset['TaskID']; ?>">Edit</a></td>
              </tr>
                <?php } while ($row_TaskRecordset = mysql_fetch_assoc($TaskRecordset)); ?>
            </table>
		    <p>&nbsp;
            <table border="0">
              <tr>
                <td><?php if ($pageNum_TaskRecordset > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_TaskRecordset=%d%s", $currentPage, 0, $queryString_TaskRecordset); ?>"><img src="First.gif"></a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_TaskRecordset > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_TaskRecordset=%d%s", $currentPage, max(0, $pageNum_TaskRecordset - 1), $queryString_TaskRecordset); ?>"><img src="Previous.gif"></a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_TaskRecordset < $totalPages_TaskRecordset) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_TaskRecordset=%d%s", $currentPage, min($totalPages_TaskRecordset, $pageNum_TaskRecordset + 1), $queryString_TaskRecordset); ?>"><img src="Next.gif"></a>
                    <?php } // Show if not last page ?></td>
                <td><?php if ($pageNum_TaskRecordset < $totalPages_TaskRecordset) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_TaskRecordset=%d%s", $currentPage, $totalPages_TaskRecordset, $queryString_TaskRecordset); ?>"><img src="Last.gif"></a>
                    <?php } // Show if not last page ?></td>
              </tr>
            </table>
            </p>
		    <p>Type Delete Task ID: 
		      <label for="deletefield"></label>
		      <input type="text" name="deletefield" id="deletefield">
		      <input type="submit" name="button2" id="button2" value="Delete">
		    </p>
		  </form>
        <p>
         <a href="addTask.php"> <input name="button" type="submit" class="leftTiyle" id="button" value="Create New Project"></a>
        </p>
        
        </div>
        
	</body>

</html>
<?php
mysql_free_result($TaskRecordset);
?>
