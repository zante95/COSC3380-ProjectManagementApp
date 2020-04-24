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
                       GetSQLValueString($_POST['leaderid0'], "int"),
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

mysql_select_db($database_remotesql, $remotesql);
$query_Recordset2 = "SELECT EmployeeID FROM EMPLOYEE";
$Recordset2 = mysql_query($query_Recordset2, $remotesql) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

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

            <div class="content">
            <h2>Edit Project</h2>
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
		      <label for="leaderid">Leader ID: 
               <select name="leaderid0" id="leaderid0">
		        <?php
do {  
?>
		        <option value="<?php echo $row_Recordset2['EmployeeID']?>"><?php echo $row_Recordset2['EmployeeID']?></option>
		        <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
              </select></label>
               
		      <label for="revenue"></label>
	          <label for="select2"></label>
		      
		      
		    <p>
		      <label for="select">Flag Status: </label>
		      <select name="select" id="select">
              <option value="A">Active</option>
 			        <option value="I">Inactive</option>
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
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
