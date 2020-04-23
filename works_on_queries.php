<?php include 'Source/connect.php';?>
<?php

  if(isset($_POST['selected_project_id'])) {

    $projectID = $_POST['selected_project_id'];

    $employees_query = "SELECT DISTINCT EMPLOYEE.`EmployeeID`, EMPLOYEE.`EmployeeName`
                        FROM EMPLOYEE
                        INNER JOIN WORKS_ON
                        ON WORKS_ON.`EmployeeID` = EMPLOYEE.`EmployeeID`
                        WHERE WORKS_ON.`ProjectID` = $projectID";

    $result = $conn->query($employees_query);

    echo '<option value="" selected>-- Select Employee --</option>';
    while($row = $result->fetch_array()){
      echo '<option value="'.$row['EmployeeID'].'">'.$row['EmployeeName'].'</option>';
    }
  }

?>