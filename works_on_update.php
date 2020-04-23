<?php require_once('Connections/remotesql.php'); ?>
<?php include 'Source/connect.php';?>
<?php include('Module/Login/session.php'); ?>
<html>
<head>
	<title>WORKS_ON</title>
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
		<!-- Page Content -->
		<div id="page-content-wrapper">

			<!-- project-list -->
			<div class="modal-body">
				<h2>Manage Works On</h2>

				<h3>Update working hours</h3>
				<form id="project-list">

				<div class="col-lg-3 col-md-3">
					<label class="control-label">Project List: </label>
				</div>

				<select class="selectpicker" id="project" name="project">

					<option value="" selected>-- Select Project --</option>

					<?php
						$projects_query = "SELECT `ProjectID`, `ProjectName` FROM `PROJECT`";
						$result = $conn->query($projects_query);

						while($row = $result->fetch_array()){
							echo '<option value="'.$row['ProjectID'].'">'.$row['ProjectName'].'</option>';
						}
						
					?>

				</select>

				</form>

			</div>
			<!-- /project-list -->

			<!-- employee-list -->
			<div class="modal-body">
				<form id="employee-list">

				<div class="col-lg-3 col-md-3">
					<label class="control-label">Employee List: </label>
				</div>

				<select class="selectpicker" id="employee" name="employee">

					<option value="" selected>-- Select Employee --</option>

				</select>
				</form>
			</div>
			<!-- /employee-list -->

			<!-- tasks-list -->
			<div class="modal-body">
				<form id="task" name="task">

				</form>
			</div>
			<!-- /tasks-list -->
			<div>
				<h3>Assign a new Task to a Project and Employee</h3>
				<p>
         <a href="addWorksOn.php"> <input name="button" type="submit" class="leftTiyle" id="button" value="Assign New"></a>
        </p>
			</div>

		</div>
		<!-- /page-content-wrapper -->

	</div>
</body>

</html>

<script type="text/javascript">
	$(document).ready(function(){
		var projectID;
		$('#project').on('change', function(){
			projectID = $(this).val();
			if(projectID){
				console.log(projectID);
				$.ajax({
					url:'works_on_queries.php',
					type:'POST',
					data:'selected_project_id='+projectID,
					async:true,
					success:function(html){
						$('#employee').html(html);
						$('.selectpicker').selectpicker('refresh');
						$('#task').html('<form id="task" name="task"></form>');
					}
				})
			}
		})
		
		$('#employee').on('change', function(){
			var employeeID = $(this).val();
			if(employeeID){
				console.log(employeeID);
				console.log(projectID);
				$.ajax({
					url:'works_on_queries2.php', 
					type:'POST', 
					data:'selected_employee_id='+employeeID+'&selected_project_id='+projectID, 
					async:true,
					success:function(html){
						$('#task').html(html);
					}
				})
			}
		})
	})
</script>