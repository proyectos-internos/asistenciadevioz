<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql = "SELECT *, a.id AS caid FROM adelanto_efecivo as a LEFT JOIN empleado as e on e.id=a.empleado_id WHERE a.id='$id'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
?>