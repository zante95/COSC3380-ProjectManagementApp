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
            <h2>My Tasks</h2>
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
         <a href="addTask.php"> <input name="button" type="submit" class="leftTiyle" id="button" value="Create New Task"></a>
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