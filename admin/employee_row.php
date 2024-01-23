<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql = "SELECT *, e.id as empid FROM empleado as e LEFT JOIN posicion as p ON p.id=e.posicion_id LEFT JOIN horario as h ON h.id=e.horario_id WHERE e.id = '$id'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
?>