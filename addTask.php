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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO TASK (`Description`, StartDate, DueDate, FinishDate, FlagStatus, FlagActive) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['des'], "text"),
                       GetSQLValueString($_POST['sdate'], "date"),
                       GetSQLValueString($_POST['edate'], "date"),
                       GetSQLValueString($_POST['fdate'], "date"),
                       GetSQLValueString($_POST['select'], "text"),
                       GetSQLValueString($_POST['select2'], "text"));

  mysql_select_db($database_remotesql, $remotesql);
  $Result1 = mysql_query($insertSQL, $remotesql) or die(mysql_error());

  $insertGoTo = "task.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_remotesql, $remotesql);
$query_Recordset1 = "SELECT * FROM TASK";
$Recordset1 = mysql_query($query_Recordset1, $remotesql) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
    <link href="css/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <link href="css/css/bootstrap-table.css" rel="stylesheet"/>

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style2.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript" src="js/jquery.min.js" ></script>
    <script src="Script/moment.min.js"></script>
    <script src="Script/moment-with-locales.js"></script>
	  <script src="Script/bootstrap-datetimepicker.js"></script>
    <script src="Script/bootstrap-table.js"></script>
    
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
          $('#menu-logout').click(function(){
              window.location.href = "Module/Login/close.php";
          });

          $('#sdate').datetimepicker({
            format: 'YYYY-MM-DD'
          });

          $('#edate').datetimepicker({
            format: 'YYYY-MM-DD'
          });

          $('#buttonSubmit').click(function(){
            var starting = $("#form1").find('input[name="sdate"]').val().trim();
            var due = $("#form1").find('input[name="edate"]').val().trim();
            if(due < starting) {
              $("#form1").submit(function(event) {
                alert("Please select the correct due date");
                event.preventDefault();
              });
              //window.location.href = "addTask.php";
            }
            else if(due >= starting) {
              $('#form1').submit();
            }
          });

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
        <h2>Add New Task</h2>
		  <form id="form1" action="<?php echo $editFormAction; ?>" name="form1" method="POST">
		    <p>Description:
		      <label for="des"></label>
		      <input type="text" name="des" id="des">
		    </p>
        
          <div class="row">
            <div class="radio">
            
            <div class="col-lg-12 col-md-12">
              <label for="sdate" class="control-label">Start Date</label>
            </div>
            
            <div class="col-lg-12 col-md-12">
              <input type="text" class="form-control" id="sdate" name="sdate" style="height:40px;margin-top:-2.5%;margin-bottom:5%;"/>
            </div>

            </div>
          </div>

          <div class="row">
            <div class="radio">
            
            <div class="col-lg-12 col-md-12">
              <label for="edate" class="control-label">Due Date</label>
            </div>
            
            <div class="col-lg-12 col-md-12">
              <input type="text" class="form-control" id="edate" name="edate" style="height:40px;margin-top:-2.5%;margin-bottom:5%;"/>
            </div>
            
            </div>
          </div>

            <p>
              <label for="select"></label>
            Flag Status: 
            <label for="select"></label>
            
            <select name="select" id="select">
              <option value="C">Completed</option>
 			        <option value="L">Late</option>
              <option value="O">Ongoing</option>
 			        <option value="U">Upcoming</option>
            </select>
            </p>
            <p>Flag Active: 
              <label for="select2"></label>
              
              <select name="select2" id="select2">
                <option value="A">Active</option>
 			          <option value="D">Deleted (hidden)</option>
              </select>
            </p>
            <p>
              <input type="submit" name="button" id="buttonSubmit" value="Submit">
            </p>
            <input type="hidden" name="MM_insert" value="form1">
		  </form>
		  <p>&nbsp;</p>
		</div>

           
        </div>
    </div>

</body>

</html>