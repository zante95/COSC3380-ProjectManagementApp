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
		$updateSQL = sprintf("UPDATE WORKS_ON SET WorkingHours=%s WHERE WorksID=%s",
												 GetSQLValueString($_POST['workingHours'], "int"),
                         GetSQLValueString($_POST['textfield'], "int"));
		
		mysql_select_db($database_remotesql, $remotesql);
		$Result1 = mysql_query($updateSQL, $remotesql) or die(mysql_error());
	
		$updateGoTo = "works_on_update.php";
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
	$query_Recordset_edit = sprintf("SELECT WORKS_ON.`WorksID`, WORKS_ON.`WorkingHours`, TASK.`Description` FROM WORKS_ON, TASK WHERE WorksID = %s AND TASK.`TaskID`= WORKS_ON.`TaskID`", GetSQLValueString($colname_Recordset_edit, "int"));
	$Recordset_edit = mysql_query($query_Recordset_edit, $remotesql) or die(mysql_error());
	$row_Recordset_edit = mysql_fetch_assoc($Recordset_edit);
	$totalRows_Recordset_edit = mysql_num_rows($Recordset_edit);
?>

<?php include 'Source/connect.php';?>
<?php include('Module/Login/session.php'); ?>

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

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
  <!-- Bootstrap Core JavaScript -->
  <script src="Script/bootstrap.min.js"></script>
  <script src="Script/bootstrap-select.js"></script>
  <script src="Script/moment.min.js"></script>
  <script src="Script/moment-with-locales.js"></script>
  <script src="Script/bootstrap-datetimepicker.js"></script>
  <script src="Script/bootstrap-table.js"></script>
</head>

<body>
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

	<div class="wrapper">
		<div class="content">
			<h2>Edit Hours</h2>
				<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
					<p> Set worked hours for: 
            <?php echo $row_Recordset_edit['Description']; ?>
					</p>
          <p>ID: 
		      <label for="textfield"></label>
		      <input name="textfield" type="text" id="textfield" value="<?php echo $row_Recordset_edit['WorksID']; ?>" readonly>
		    </p>
					<p>Worked Hours:
						<label for="workingHours"></label>
						<input name="workingHours" type="text" id="workingHours" value="<?php echo $row_Recordset_edit['WorkingHours']; ?>">
					</p>
					<p>
						<input type="submit" name="button" id="button" value="Submit">
					</p>
					<input type="hidden" name="MM_update" value="form1">
				</form>
			<p>&nbsp;</p>
		</div>
	</div>
</body>
</html>