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
			<div class="leftTiyle" id="flTitle">Function Two</div>
			<div class="thisUser">
      Current User: <?php echo $login_session; ?>
        <button id="menu-logout" type="button">
				  Log Out
				</button>
      </div>
		</div>
		<div class="content">
        <h2>Add New Task</h2>
		  <form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
		    <p>Description:
		      <label for="des"></label>
		      <input type="text" name="des" id="des">
		    </p>
            <p>Start Date:
              <label for="sdate"></label>
              <input type="text" name="sdate" id="sdate">
            </p>
            <p>Due Date:
              <label for="edate"></label>
              <input type="text" name="edate" id="edate">
            </p>
            <p>Finish Date: 
              <label for="fdate"></label>
              <input type="text" name="fdate" id="fdate">
            </p>
            <p>
              <label for="select"></label>
            Flag Status: 
            <label for="select"></label>
            <select name="select" id="select">
            <option value="C">C</option>
 			 <option value="L">L</option>
             <option value="O">O</option>
 			 <option value="U">U</option>
            </select>
            </p>
            <p>Flag Active: 
              <label for="select2"></label>
              <select name="select2" id="select2">
              <option value="A">A</option>
 			 <option value="D">D</option>
              </select>
            </p>
            <p>
              <input type="submit" name="button" id="button" value="Submit">
            </p>
            <input type="hidden" name="MM_insert" value="form1">
		  </form>
		  <p>&nbsp;</p>
		</div>
		
	</body>

</html>
<?php
mysql_free_result($Recordset1);
?>
