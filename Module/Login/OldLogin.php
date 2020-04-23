<?php include '../../Source/connect.php';?>
<html>
<head>
	<title>ManPro App</title>
	<!-- Bootstrap Core CSS -->
    <link href="../../css/css/bootstrap.css" rel="stylesheet"/>
	<link href="../../css/css/bootstrap-select.css" rel="stylesheet"/>
	<link href="../../css/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
	<link href="../../css/css/bootstrap-table.css" rel="stylesheet"/>

    <!-- Custom CSS -->
    <link href="../../css/css/simple-sidebar.css" rel="stylesheet"/>
	<link href="../../css/css/style.css" rel="stylesheet"/>
	<link href="../../css/css/loginstyle.css" rel="stylesheet"/>
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- jQuery -->
    <script src="../../Script/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../Script/bootstrap.min.js"></script>
	<script src="../../Script/bootstrap-select.js"></script>
	<script src="../../Script/moment.min.js"></script>
    <script src="../../Script/moment-with-locales.js"></script>
	<script src="../../Script/bootstrap-datetimepicker.js"></script>
	<script src="../../Script/bootstrap-table.js"></script>

	<script >
	$(document).ready(function(){

		$('#buttonsubmit').click(function() {
			$("#formlogin").submit();
		});
		
	});
	
	$(document).keyup(function(event){
		if(event.keyCode == 13){
			$("#buttonsubmit").click();
		}
	});	  
	</script>
	
</head>
<body>

	<div class="container-fluid">
		
		<div class="row" style="margin-top:5%;">
		
			<div class="col-lg-8 col-lg-offset-2">
			
				<center><label id="headline" class="h1">Login to ManPro</label></center>
				
			</div>
			
		</div>
		
		<div class="row">
		
			<div class="col-lg-6 col-lg-offset-3">
			
			<center>
			
				<div id="loginpane">
				<form id="formlogin" action="login.php" method="POST" >
					<center>
						
						<div class="row" style="margin-top:5%;">
						
							<label id="label1" class="h3">User ID</label>
							
						</div>
						
						<div class="row" style="margin-top:2%;">
						
							<div class="col-lg-6 col-lg-offset-3">
								<input id="inputUserID" name="userID" type="text" value="" class="form-control text-center"/>
							</div>
							
						</div>
						
						<div class="row" style="margin-top:5%;">
						
							<label id="label1" class="h3">Password</label>
							
						</div>
						
						<div class="row" style="margin-top:2%;">
						
							<div class="col-lg-6 col-lg-offset-3">
								<input id="inputPwd" name="pwd" type="password" value="" class="form-control text-center"/>
							</div>
							
						</div>
						
						<div class="row" style="margin-top:10%;">
						
							<div id="tombol" class="col-lg-6 col-lg-offset-3">
							
								<button id="buttonsubmit" type="button" class="btn btn-info btn-block buttonsubmit" aria-label="Right Align">
									<span id="label1" class="h4">Log In</span>
								</button>
								
							</div>
							
						</div>
						
						<div class="row">
							</br>
						</div>
						
					</center>
					</form>
				</div>
				
			</center>
				
			</div>
			
		</div>
	</div>
	
</body>
</html>