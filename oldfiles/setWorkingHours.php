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
	
		$updateGoTo = "home.php";
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

<html>
<head>
	<title>Edit Task</title>
	<!-- Bootstrap Core CSS -->
  <link href="css/css/bootstrap.css" rel="stylesheet"/>
	<link href="css/css/bootstrap-select.css" rel="stylesheet"/>
	<link href="css/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
	<link href="css/css/bootstrap-table.css" rel="stylesheet"/>

  <!-- Custom CSS -->
  <link href="css/css/simple-sidebar.css" rel="stylesheet"/>
  <link href="css/css/style.css" rel="stylesheet"/>
  <link href="css/css/klinikcss.css" rel="stylesheet"/>

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
</head>

<body>
	<div class="wrapper">
		<div class="content">
			<h2>Edit Task</h2>
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