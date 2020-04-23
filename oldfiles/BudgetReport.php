<?php require_once('Connections/remotesql.php'); ?>
<?php include 'Source/connect.php';?>
<?php include('Module/Login/session.php'); ?>
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
$PDFFormAction = "generate_budget_pdf.php";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

mysql_select_db($database_remotesql, $remotesql);
$query_Recordset1 = "SELECT * FROM PROJECT";
$Recordset1 = mysql_query($query_Recordset1, $remotesql) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>Index</title>
		<!-- Bootstrap Core CSS -->
		<link href="css/css/bootstrap.css" rel="stylesheet"/>
		<link href="css/css/bootstrap-select.css" rel="stylesheet"/>
		<link href="css/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
		<link href="css/css/bootstrap-table.css" rel="stylesheet"/>

		<!-- Custom CSS -->
		<link href="css/css/style.css" rel="stylesheet"/>

		<!-- Bootstrap Core JavaScript -->
		<script type="text/javascript" src="js/jquery.min.js" ></script>
		<script type="text/javascript" src="js/index.js" ></script>
		<script src="Script/bootstrap.min.js"></script>
		<script src="Script/bootstrap-select.js"></script>
		<script src="Script/moment.min.js"></script>
		<script src="Script/moment-with-locales.js"></script>
		<script src="Script/bootstrap-datetimepicker.js"></script>
		<script src="Script/bootstrap-table.js"></script>
		<link rel="stylesheet" href="css/page.css" />

		<script type="text/javascript">
			$(function(){
				$('#menu-logout').click(function(){
				
				window.location.href = "Module/Login/close.php";
				
				});

				$('#submit').click(function() {
					$("#formGenerate").submit();
				});
				
			});
		</script>
	</head>

	<body>
		<div class="left">
			<div class="bigTitle">Project Management System</div>
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
			<div class="leftTiyle" id="flTitle">Budget Reporting</div>
			<div class="thisUser">
				Current User: <?php echo $login_session; ?>
        
        		<button id="menu-logout" type="button">
				  Log Out
				</button>
			</div>
		</div>
		<div class="content col-lg-6">
		  <form id="formGenerate" action="<?php echo $PDFFormAction; ?>" name="form1" method="POST" target="_blank">

		  	<select class="form-control selectpicker customSelectRS col-lg-3" id="Project" name="Project" data-live-search="true" style="margin-top:-5%;width:50%">
			  <option value="" selected>Select Project</option>

<? $sql = "SELECT PROJECT.ProjectID, PROJECT.ProjectName FROM PROJECT";
$result = $conn->query($sql);
while($row = $result->fetch_array()){
?>
				<option value="<? echo $row[0];?>"><? echo $row[1];?></option>
<?
}
?>

			</select>

		  	<button type="submit" id="pdf" name="generate_pdf" class="btn btn-primary"><i class="fa fa-pdf"" aria-hidden="true"></i>
		  		Generate PDF
			</button>
		    <input type="hidden" name="MM_insert" value="form1">
		  </form>
		</div>
		
	</body>

</html>
<?php
mysql_free_result($Recordset1);
?>
