<?php include 'Source/connect.php';?>
<?php

	if(isset($_POST['selected_employee_id']) && isset($_POST['selected_project_id'])) {

		$projectID = $_POST['selected_project_id'];
		$employeeID = $_POST['selected_employee_id'];

		$tasks_query = "SELECT WORKS_ON.`WorksID`, TASK.`Description`, TASK.`StartDate`, TASK.`DueDate`, WORKS_ON.`WorkingHours` 
										FROM WORKS_ON, TASK
										WHERE TASK.`TaskID` = WORKS_ON.`TaskID`
										AND WORKS_ON.`EmployeeID` = $employeeID
										AND WORKS_ON.`ProjectID` = $projectID";

		$result = $conn->query($tasks_query);
	}

?>

<form id="task" name="task">
<table width="950" border="1">
	<tr>
		<td width="400">Task Description</td>
		<td width="150">Start Date</td>
		<td width="150">Due Date</td>
		<td width="150">Working Hours</td>
		<td width="100">Option</td>
	</tr>
		<?php 
			while($row = $result->fetch_array()){
				$edit = "setWorkingHours.php?id=";
				$id = $row['WorksID'];
				$editWorkingHours = $edit.$id;
				?>
				<tr>
					<td><?php echo $row['Description']; ?></td>
					<td><?php echo $row['StartDate']; ?></td>
					<td><?php echo $row['DueDate']; ?></td>
					<td><?php echo $row['WorkingHours']; ?></td>
					<td><a href="<?php echo $editWorkingHours; ?>">Edit</a></td>
				</tr>
		<?php
		}
		?>
</table>
</form>
