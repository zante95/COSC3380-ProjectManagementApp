<?php include 'Source/connect.php';?>

<html>
<head>
	<title>WORKS_ON UPDATE</title>
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

  <div id="wrapper">
    <!-- Page Content -->
    <div id="page-content-wrapper">

      <!-- project-list -->
      <div class="modal-body">

        <form id="project-list">

        <div class="col-lg-3 col-md-3">
					<label class="control-label">Project List: </label>
				</div>

        <select class="selectpicker" id="project" name="project">

          <option value="" selected disabled>-- Select Project --</option>

          <?php
            $projects_query = "SELECT `ProjectID`, `ProjectName` FROM `PROJECT`";
            $result = $conn->query($projects_query);

            while($row = $result->fetch_array()){
              echo '<option value="'.$row['ProjectID'].'">'.$row['ProjectName'].'</option>';
            }
            
            echo '<script type="text/javascript">console.log("trying script")</script>';
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

    </div>
    <!-- /page-content-wrapper -->

  </div>
</body>

</html>


<?php
  /*
  'UPDATE WORKS_ON
  SET WorkingHours = value_from_input
  WHERE WorksID = selected_works_id'
  */

?>


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
          }
        })
      }
      else {
        $('#employee').html('<option value="" selected>-- Select Employee --</option>');
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
            //$('.selectpicker').selectpicker('refresh');
          }
        })
      }
    })
  })
</script>