<?php include '../../Source/connect.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login to Manpro</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="util.css">
	<link rel="stylesheet" type="text/css" href="main.css">
<!--===============================================================================================-->

<!-- Custom CSS -->
    <link href="../../css/css/simple-sidebar.css" rel="stylesheet"/>
	<link href="../../css/css/style.css" rel="stylesheet"/>
	<link href="../../css/css/loginstyle.css" rel="stylesheet"/>
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
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form id="formlogin" class="login100-form validate-form p-l-55 p-r-55 p-t-178" action="login.php" method="POST">
					<span class="login100-form-title">
						Sign In
					</span>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
						<input id="inputUserID" name="userID" type="text" value=""class="input100 form-control" placeholder="Username" />
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Please enter password">
						<input class="input100 form-control"id="inputPwd" name="pwd" type="password" value="" placeholder="Password" />
						<span class="focus-input100"></span>
					</div>

					<div class="text-right p-t-13 p-b-23">
						<span class="txt1">
							
						</span>

						<a href="#" class="txt2">
							
						</a>
					</div>

					<div class="container-login100-form-btn">
						<button id="buttonsubmit" class="login100-form-btn" type="button" >
							Sign in
						</button>
					</div>

					<div class="flex-col-c p-t-170 p-b-40">
						<span class="txt1 p-b-9">
							
						</span>

						<a href="#" class="txt3">
							
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	


</body>
</html>