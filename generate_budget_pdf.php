<?php
include 'Source/connect.php';
include('Module/Login/session.php');

$project=$_POST['Project'];
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
$sql_project_name = "SELECT PROJECT.ProjectName FROM PROJECT
WHERE PROJECT.ProjectID = $project";

$result_project = $conn->query($sql_project_name);

while($row_project = $result_project->fetch_array()){
?>
        <h2 class="text-center">Expense Breakdown for Project &nbsp <? echo $row_project[0]; ?></h2>
<?
}
?>
        <table id="table1" class="table table-bordered" data-search="true" data-pagination="true">
            <thead id="headtable" class="thead-dark" style="background-color: #000000;color: #ffffff;">
                <th width="10%"><b>No.</b></th>
                <th width="10%" class="text-center"><b>Description</b></th>
                <th width="10%" class="text-center"><b>Amount(in US Dollar)</b></th>
            </thead>
            <tbody>
<?
$sql = "SELECT BUDGET.ItemName, SUM(BUDGET.AllocationCost) as amount
FROM BUDGET
WHERE BUDGET.ProjectID = '$project'
GROUP BY BUDGET.ItemName  
ORDER BY amount DESC";

$result = $conn->query($sql);
$indexCount = 1;

while($row = $result->fetch_array()){
?>
                <tr>
                    <td><?php echo $indexCount; ?></td>
                    <td class="text-center"><?php echo $row[0];?></td>
                    <td class="text-center"><?php echo $row[1];?></td>                  
                </tr>
							
<?php
        $indexCount = $indexCount + 1;
    }

$sql1 = "SELECT SUM(BUDGET.AllocationCost) FROM `BUDGET` WHERE BUDGET.ProjectID = '$project'";
$sql2 = "SELECT PROJECT.Revenue FROM PROJECT WHERE PROJECT.ProjectID = '$project'";
$sql3 = "SELECT PROJECT.NetGainOrLoss FROM PROJECT WHERE PROJECT.ProjectID = '$project'";

$result1 = $conn->query($sql1);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);

$row1 = $result1->fetch_array();
$row2 = $result2->fetch_array();
$row3 = $result3->fetch_array();
?>
                <tr height="200%">
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center">Total Expense</td>
                    <td class="text-center"><?php echo $row1[0];?></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center">Revenue</td>
                    <td class="text-center"><?php echo $row2[0];?></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center">Net Gain/Loss</td>
                    <td class="text-center"><?php echo $row3[0];?></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>