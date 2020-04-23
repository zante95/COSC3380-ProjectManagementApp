<?php
include 'Source/connect.php';
include('Module/Login/session.php');

$start_date = $_POST['StartDate'];
$end_date = $_POST['EndDate'];
?>
<html>
    <head>
        <title>ManPro App</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/css/bootstrap.css" rel="stylesheet"/>
        <link href="css/css/bootstrap-select.css" rel="stylesheet"/>
        <link href="css/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
        <link href="css/css/bootstrap-table.css" rel="stylesheet"/>

        <!-- Custom CSS -->
        <link href="css/css/simple-sidebar.css" rel="stylesheet"/>
        <link href="css/css/style.css" rel="stylesheet"/>
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

            window.print(); 
            
        });
        
        $(document).keyup(function(event){
            if(event.keyCode == 13){
                $("#buttonsubmit").click();
            }
        });	  
        </script>
        
    </head>
    <body>
<? // SQL query to fetch project name.
$sql_project_name = "SELECT PROJECT.ProjectName FROM PROJECT, CLIENT, USER_LOGIN
WHERE PROJECT.ProjectID = CLIENT.ProjectID
AND PROJECT.ProjectID = USER_LOGIN.ClientID
AND USER_LOGIN.Username = '$login_session'";

$result_project = $conn->query($sql_project_name);

while($row_project = $result_project->fetch_array()){
?>
        <h1 class="text-center">Project &nbsp <? echo $row_project[0]; ?></h1>
        <h2 class="text-center">For Date Range between  <? echo $start_date; ?> and <? echo $end_date; ?></h2>
<?
}
?>
        <h2 class="text-center">Task Progress Breakdown</h2>
        <table id="table1" class="table table-striped" data-search="true" data-pagination="true">
            <thead id="headtable">
                <th width="10%" class="text-center">Task</th>
                <th width="10%" class="text-center">Start</th>
                <th width="10%" class="text-center">Due</th>
                <th width="10%" class="text-center">Status</th>
                <th width="5%" class="text-center">Finished On</th>
            </thead>
            <tbody>
<? // SQL query to fetch information of registerd users and finds user match.
$sql_init = "SELECT PROJECT.ProjectID FROM PROJECT, CLIENT, USER_LOGIN
WHERE PROJECT.ProjectID = CLIENT.ProjectID
AND PROJECT.ProjectID = USER_LOGIN.ClientID
AND USER_LOGIN.Username = '$login_session'";

$result_init = $conn->query($sql_init);
$row_init = $result_init->fetch_array();

$sql = "SELECT DISTINCT TASK.Description AS 'Task', TASK.StartDate AS 'Start', TASK.DueDate AS 'Due', IF(
    TASK.FlagStatus='C','Completed', IF(
        TASK.FlagStatus='L','Late',IF(
            TASK.FlagStatus='O','Ongoing', IF(
                TASK.FlagStatus='U','Upcoming','N/A'))))
    AS 'Task Status', IF(
        TASK.FinishDate IS NULL,'N/A',TASK.FinishDate)
    AS 'Finished on'
FROM TASK, WORKS_ON
WHERE TASK.TaskID = WORKS_ON.TaskID
AND WORKS_ON.ProjectID = $row_init[0]
AND TASK.StartDate BETWEEN '$start_date' AND '$end_date'";

$result = $conn->query($sql);

    while($row = $result->fetch_array()){
?>
                <tr>
                    <td class="text-center"><?php echo $row[0];?></td>
                    <td class="text-center"><?php echo $row[1];?></td>
                    <td class="text-center"><?php echo $row[2];?></td>
                    <td class="text-center"><?php echo $row[3];?></td>
                    <td class="text-center"><?php echo $row[4];?></td>                    
                </tr>
							
<?php
    }
?>
            </tbody>
        </table>
    </body>
</html>