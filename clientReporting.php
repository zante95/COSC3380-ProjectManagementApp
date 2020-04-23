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

$PDFFormAction = "generate_pdf.php";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$sql_init = "SELECT PROJECT.Start_Date, PROJECT.End_Date FROM PROJECT, CLIENT, USER_LOGIN
WHERE PROJECT.ProjectID = CLIENT.ProjectID
AND PROJECT.ProjectID = USER_LOGIN.ClientID
AND USER_LOGIN.Username = '$login_session'";

$result_init = $conn->query($sql_init);
$row_init = $result_init->fetch_array();
?>
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
          
          $('#StartDate').datetimepicker({
            format: 'YYYY-MM-DD'
          });

          $('#EndDate').datetimepicker({
            format: 'YYYY-MM-DD'
          });
          
          $('#pdf').click(function(){
            var starting = $("#form1").find('input[name="StartDate"]').val().trim();
            var ending = $("#form1").find('input[name="EndDate"]').val().trim();
            if(starting < '<?php echo $row_init[0];?>' || ending > '<?php echo $row_init[1];?>'){
              alert("Please select the correct date in between the project start date and end date.");
              window.location.href = "clientReporting.php";
            }
            else {
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
            <h2>Budget Report</h2>
            <div class="line"></div>

		  <form id="form1" action="<?php echo $PDFFormAction; ?>" name="form1" method="POST" target="_blank">
		  	
        <div class="row" style="margin-top:5%;">
          <div class="radio">
          
          <div class="col-lg-5 col-md-5">
            <label for="StartDate" class="control-label">Start Date<span style="color:red;">*must be later or equal to <?php echo $row_init[0]?></span></label>
          </div>
          
          <div class="col-lg-5 col-lg-offset-2 col-md-5 col-md-offset-2">
            <input type="text" class="form-control" id="StartDate" name="StartDate" style="height:40px;margin-top:-2.5%;"/>
          </div>
          
          </div>
        </div>

        <div class="row" style="margin-top:5%;">
          <div class="radio">
          
          <div class="col-lg-5 col-md-5">
            <label for="EndDate" class="control-label">End Date<span style="color:red;">*must be later or equal to <?php echo $row_init[1]?></span></label>
          </div>
          
          <div class="col-lg-5 col-lg-offset-2 col-md-5 col-md-offset-2">
            <input type="text" class="form-control" id="EndDate" name="EndDate" style="height:40px;margin-top:-2.5%;"/>
          </div>
          
          </div>
        </div>
        <br/>
        <button type="submit" id="pdf" name="generate_pdf" class="btn btn-primary"><i class="fa fa-pdf"" aria-hidden="true"></i>
		  		Generate PDF
		  	</button>
		    <input type="hidden" name="MM_insert" value="form1">
		  </form>
		</div>

          

           
        </div>
    </div>
</body>

</html>