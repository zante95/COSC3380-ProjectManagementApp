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
  $deleteSQL = sprintf("DELETE FROM BUDGET WHERE BudgetID=%s",
                       GetSQLValueString($_POST['deletefield'], "int"));

  mysql_select_db($database_remotesql, $remotesql);
  $Result1 = mysql_query($deleteSQL, $remotesql) or die(mysql_error());

  $deleteGoTo = "budget.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_Recordset1 = 8;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_remotesql, $remotesql);
$query_Recordset1 = "SELECT * FROM BUDGET WHERE ItemName LIKE '%Salary%' ORDER BY BudgetID ASC ";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $remotesql) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$maxRows_Recordset_NotSalary = 8;
$pageNum_Recordset_NotSalary = 0;
if (isset($_GET['pageNum_Recordset_NotSalary'])) {
  $pageNum_Recordset_NotSalary = $_GET['pageNum_Recordset_NotSalary'];
}
$startRow_Recordset_NotSalary = $pageNum_Recordset_NotSalary * $maxRows_Recordset_NotSalary;

mysql_select_db($database_remotesql, $remotesql);
$query_Recordset_NotSalary = "SELECT * FROM BUDGET WHERE ItemName NOT LIKE '%Salary%' ORDER BY BudgetID ASC ";
$query_limit_Recordset_NotSalary = sprintf("%s LIMIT %d, %d", $query_Recordset_NotSalary, $startRow_Recordset_NotSalary, $maxRows_Recordset_NotSalary);
$Recordset_NotSalary = mysql_query($query_limit_Recordset_NotSalary, $remotesql) or die(mysql_error());
$row_Recordset_NotSalary = mysql_fetch_assoc($Recordset_NotSalary);

if (isset($_GET['totalRows_Recordset_NotSalary'])) {
  $totalRows_Recordset_NotSalary = $_GET['totalRows_Recordset_NotSalary'];
} else {
  $all_Recordset_NotSalary = mysql_query($query_Recordset_NotSalary);
  $totalRows_Recordset_NotSalary = mysql_num_rows($all_Recordset_NotSalary);
}
$totalPages_Recordset_NotSalary = ceil($totalRows_Recordset_NotSalary/$maxRows_Recordset_NotSalary)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);

$queryString_Recordset_NotSalary = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset_NotSalary") == false && 
        stristr($param, "totalRows_Recordset_NotSalary") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset_NotSalary = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset_NotSalary = sprintf("&totalRows_Recordset_NotSalary=%d%s", $totalRows_Recordset_NotSalary, $queryString_Recordset_NotSalary);
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
		   
	        <p>Employee Salary Budget:</p>
	        <table width="811" border="1">
		      <tr>
		        <td width="137">Project ID</td>
		        <td width="173">Item Name</td>
		        <td width="164">Allocation Cost</td>
		        <td width="123">Employee ID</td>
		        <td width="136">Budget ID</td>
		        <td width="38">Option</td>
	          </tr>
              <?php do { ?>
              <tr>
                <td><?php echo $row_Recordset1['ProjectID']; ?></td>
                <td><?php echo $row_Recordset1['ItemName']; ?></td>
                <td><?php echo $row_Recordset1['AllocationCost']; ?></td>
                <td><?php echo $row_Recordset1['EmpID']; ?></td>
                <td><?php echo $row_Recordset1['BudgetID']; ?></td>
                <td><a href="EditBudget2.php?id=<?php echo $row_Recordset1['BudgetID']; ?>">Edit</a></td>
              </tr>
                <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
            </table>
	        <table border="0">
              <tr>
                <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="First.gif"></a>
                <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="Previous.gif"></a>
                <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="Next.gif"></a>
                <?php } // Show if not last page ?></td>
                <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="Last.gif"></a>
                <?php } // Show if not last page ?></td>
              </tr>
            </table>
	        <p>Other Budget:</p>
		    <table width="975" border="1">
		      <tr>
		        <td width="175">Project ID</td>
		        <td width="189">Item Name</td>
		        <td width="202">Allocation Cost</td>
		        <td width="161">Employee ID</td>
		        <td width="174">Budget ID</td>
		        <td width="34">Option</td>
	          </tr>
              <?php do { ?>
                <tr>
                  <td><?php echo $row_Recordset_NotSalary['ProjectID']; ?></td>
                  <td><?php echo $row_Recordset_NotSalary['ItemName']; ?></td>
                  <td><?php echo $row_Recordset_NotSalary['AllocationCost']; ?></td>
                  <td><?php echo $row_Recordset_NotSalary['EmpID']; ?></td>
                  <td><?php echo $row_Recordset_NotSalary['BudgetID']; ?></td>
                  <td><a href="EditBudget.php?id=<?php echo $row_Recordset_NotSalary['BudgetID']; ?>">Edit</a></td>
                </tr>
                <?php } while ($row_Recordset_NotSalary = mysql_fetch_assoc($Recordset_NotSalary)); ?>
            </table><table border="0">
              <tr>
                <td><?php if ($pageNum_Recordset_NotSalary > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Recordset_NotSalary=%d%s", $currentPage, 0, $queryString_Recordset_NotSalary); ?>"><img src="First.gif"></a>
                <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_Recordset_NotSalary > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Recordset_NotSalary=%d%s", $currentPage, max(0, $pageNum_Recordset_NotSalary - 1), $queryString_Recordset_NotSalary); ?>"><img src="Previous.gif"></a>
                <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_Recordset_NotSalary < $totalPages_Recordset_NotSalary) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Recordset_NotSalary=%d%s", $currentPage, min($totalPages_Recordset_NotSalary, $pageNum_Recordset_NotSalary + 1), $queryString_Recordset_NotSalary); ?>"><img src="Next.gif"></a>
                <?php } // Show if not last page ?></td>
                <td><?php if ($pageNum_Recordset_NotSalary < $totalPages_Recordset_NotSalary) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Recordset_NotSalary=%d%s", $currentPage, $totalPages_Recordset_NotSalary, $queryString_Recordset_NotSalary); ?>"><img src="Last.gif"></a>
                <?php } // Show if not last page ?></td>
              </tr>
            </table>
            <p>Type Delete Budget ID: 
		      <label for="deletefield"></label>
		      <input type="text" name="deletefield" id="deletefield">
		      <input type="submit" name="button2" id="button2" value="Delete">
		    </p>
		  </form>
        <p>
         <a href="AddBudget.php"> <input name="button" type="submit" class="leftTiyle" id="button" value="Create New Project"></a>
        </p>
        
        </div>
        
	</body>

</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset_NotSalary);
?>
