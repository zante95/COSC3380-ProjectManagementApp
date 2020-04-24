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
  $updateSQL = sprintf("UPDATE CLIENT SET ProjectID=%s, ClientName=%s, Email=%s, Phone1=%s, Phone2=%s WHERE ClientID=%s",
                       GetSQLValueString($_POST['select'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['cell'], "int"),
                       GetSQLValueString($_POST['phone'], "int"),
                       GetSQLValueString($_POST['textfield'], "int"));

  mysql_select_db($database_remotesql, $remotesql);
  $Result1 = mysql_query($updateSQL, $remotesql) or die(mysql_error());

  $updateGoTo = "client.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset_edit = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset_edit = $_GET['id'];
}
mysql_select_db($database_remotesql, $remotesql);
$query_Recordset_edit = sprintf("SELECT * FROM CLIENT WHERE ClientID = %s", GetSQLValueString($colname_Recordset_edit, "int"));
$Recordset_edit = mysql_query($query_Recordset_edit, $remotesql) or die(mysql_error());
$row_Recordset_edit = mysql_fetch_assoc($Recordset_edit);
$totalRows_Recordset_edit = mysql_num_rows($Recordset_edit);

mysql_select_db($database_remotesql, $remotesql);
$query_Recordset1 = "SELECT ProjectID FROM PROJECT";
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
        <h2>Edit Client</h2>
		  <form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
		    <p>Client ID: 
		      <label for="textfield"></label>
		      <input name="textfield" type="text" id="textfield" value="<?php echo $row_Recordset_edit['ClientID']; ?>" readonly>
		    </p>
		    <p>Name:
		      <label for="name"></label>
		      <input name="name" type="text" id="name" value="<?php echo $row_Recordset_edit['ClientName']; ?>">
		    </p>
        <p>Project ID:
          <select name="select" id="select">
            <?php
do {  
?>
            <option value="<?php echo $row_Recordset1['ProjectID']?>"><?php echo $row_Recordset1['ProjectID']?></option>
            <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
          </select>
        </p>
            <p>Email:
              <label for="email"></label>
              <input name="email" type="text" id="email" value="<?php echo $row_Recordset_edit['Email']; ?>">
            </p>
            <p>Cell Phone:
              <label for="cell"></label>
              <input name="cell" type="text" id="cell" value="<?php echo $row_Recordset_edit['Phone1']; ?>">
            </p>
            <p>Home Phone: 
              <label for="phone"></label>
              <input name="phone" type="text" id="phone" value="<?php echo $row_Recordset_edit['Phone2']; ?>">
            </p>
            <p>
              <input type="submit" name="button" id="button" value="Submit">
            </p>
            <input type="hidden" name="MM_update" value="form1">
		  </form>
		  <p>&nbsp;</p>
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
mysql_free_result($Recordset_edit);

mysql_free_result($Recordset1);
?>
