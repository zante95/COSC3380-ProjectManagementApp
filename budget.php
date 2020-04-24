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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Dashboard</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style2.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery.min.js" ></script>
		<script type="text/javascript" src="js/index.js" ></script>
    <script type="text/javascript">
      $(function(){
        $('#menu-logout').click(function(){
        
          window.location.href = "Module/Login/close.php";
        
        });
        
      });
    </script>
    <style>
        img {
            max-height: 66%;
            max-width: 66%;
            margin-left: auto;
            margin-right: auto;
            
        }
</style>
</head>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3 >Dashboard</h3>
            </div>

            <ul class="list-unstyled components">
                <div class="nav-image">
                <img src="https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/default-avatar.png" alt="Italian Trulli">
                <h2><? echo $login_session?></h2>
                </div>
                <? $sql_menu = "SELECT MENU.MenuName, MENU.url FROM MENU, ASSIGNED_MENU WHERE MENU.MenuID = ASSIGNED_MENU.MenuID AND ASSIGNED_MENU.Username = '$login_session'";

                $result_menu = $conn->query($sql_menu);

                while($row_menu = $result_menu->fetch_array()){
                ?>
                <li>
                <a href="<? echo $row_menu[1]; ?>"><div onclick="pageClick(this)"> <? echo $row_menu[0]; ?> </div></a>
                </li>
                <?
                }
                ?>
                <li>
                    <a href="#" id="menu-logout">Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

    

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <? $sql_menu = "SELECT MENU.MenuName, MENU.url FROM MENU, ASSIGNED_MENU WHERE MENU.MenuID = ASSIGNED_MENU.MenuID AND ASSIGNED_MENU.Username = '$login_session'";

                                $result_menu = $conn->query($sql_menu);

                                while($row_menu = $result_menu->fetch_array()){
?>
                <li class="nav-item">
                <a class="nav-link" href="<? echo $row_menu[1]; ?>" ><div onclick="pageClick(this)"> <? echo $row_menu[0]; ?> </div></a>
                </li>
                  <?
                    }
                    ?>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="content" margin-top: 50px>
		  <form name="form1" method="post" action="">
		   
	        <h2>Employee Salary Budget:</h2>
	        <table width="811" border="1">
		      <tr>
		        <td width="137">Project ID</td>
		        <td width="173">Item Name</td>
		        <td width="164">Allocation Cost</td>
		        <td width="123">Employee ID</td>
		        <td width="136">Budget ID</td>
	          </tr>
              <?php do { ?>
              <tr>
                <td><?php echo $row_Recordset1['ProjectID']; ?></td>
                <td><?php echo $row_Recordset1['ItemName']; ?></td>
                <td><?php echo $row_Recordset1['AllocationCost']; ?></td>
                <td><?php echo $row_Recordset1['EmpID']; ?></td>
                <td><?php echo $row_Recordset1['BudgetID']; ?></td>
                
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
	        <h2>Other Budget:</h2>
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
         <a href="AddBudget.php"> <input name="button" type="submit" class="leftTiyle" id="button" value="Add Other Budget"></a>
        </p>
        
        </div>

           
        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>
</body>

</html>