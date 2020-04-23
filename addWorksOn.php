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
	
	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "workson")) {
		$insertSQL = sprintf("INSERT INTO WORKS_ON (ProjectID, EmployeeID, TaskID, WorkingHours) VALUES (%s, %s, %s, %s)",
							GetSQLValueString($_POST['project'], "int"),
							GetSQLValueString($_POST['employee'], "int"),
							GetSQLValueString($_POST['task'], "int"),
							GetSQLValueString($_POST['workingHours'], "int"));

		mysql_select_db($database_remotesql, $remotesql);
		$Result1 = mysql_query($insertSQL, $remotesql) or die(mysql_error());

		$insertGoTo = "works_on_update.php";
		if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
		}
		header(sprintf("Location: %s", $insertGoTo));
	}
	
	
	mysql_select_db($database_remotesql, $remotesql);

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
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	
	<!-- Bootstrap Core JavaScript -->
	<script src="Script/bootstrap.min.js"></script>
	<script src="Script/bootstrap-select.js"></script>
	<script src="Script/moment.min.js"></script>
	<script src="Script/moment-with-locales.js"></script>
	<script src="Script/bootstrap-datetimepicker.js"></script>
	<script src="Script/bootstrap-table.js"></script>

	<script type="text/javascript">
		$(function(){
			$('.selectpicker').selectpicker();
			
			$('#menu-logout').click(function(){	
				window.location.href = "../Login/index.php";
			});

			$('#table1').bootstrapTable();
		});
	</script>

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

	<div id="wrapper">
		<div class="content">
			<h2>Assign a new Task to a Project and Employee</h2>

			<form action="<?php echo $editFormAction; ?>" name="workson"  method="POST">
				<p>
					<label for="project">Project: </label>
			
					<select class="selectpicker" id="project" name="project">

						<option value="" selected>-- Select Project --</option>

						<?php
						
						$query_Recordset1 = "SELECT ProjectID, ProjectName FROM PROJECT";
						$Recordset1 = mysql_query($query_Recordset1, $remotesql) or die(mysql_error());
						$totalRows_Recordset1 = mysql_num_rows($Recordset1);

						while($row = mysql_fetch_assoc($Recordset1)){
							echo '<option value="'.$row['ProjectID'].'">'.$row['ProjectName'].'</option>';
						}
						
						?>

					</select>
				</p>

				<p>
					<label for="employee">Employee: </label>
			
					<select class="selectpicker" id="employee" name="employee">

						<option value="" selected>-- Select Employee --</option>

						<?php
						$query_Recordset2 = "SELECT EmployeeID, EmployeeName FROM EMPLOYEE";
						$Recordset2 = mysql_query($query_Recordset2, $remotesql) or die(mysql_error());
						$totalRows_Recordset2 = mysql_num_rows($Recordset2);

						while($row = mysql_fetch_assoc($Recordset2)){
							echo '<option value="'.$row['EmployeeID'].'">'.$row['EmployeeName'].'</option>';
						}

					?>

					</select>
				</p>

				<p>
					<label for="task">Task: </label>
			
					<select class="selectpicker" id="task" name="task">

						<option value="" selected>-- Select Task --</option>

						<?php

						$query_Recordset3 = "SELECT TaskID, `Description`, StartDate, DueDate FROM TASK";
						$Recordset3 = mysql_query($query_Recordset3, $remotesql) or die(mysql_error());
						$totalRows_Recordset3 = mysql_num_rows($Recordset3);

						while($row3 = mysql_fetch_assoc($Recordset3)){
							echo '<option value="'.$row3['TaskID'].'">'.$row3['Description'].'	| Start: '.$row3['StartDate'].' | Due: '.$row3['DueDate'].'</option>';
						}
					?>

					</select>
				</p>

				<p>Working Hours: 
          <label for="workingHours"></label>
          <input type="text" name="workingHours" id="workingHours">
				</p>

				<p>
          <input type="submit" name="button" id="button" value="Submit">
        </p>

        <input type="hidden" name="MM_insert" value="workson">
			</form>
		  <p>&nbsp;</p>

		</div>
		<!-- /project-list -->

	</div>
	
</body>

</html>