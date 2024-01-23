<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$date = $_POST['edit_date'];
		$time_in = $_POST['edit_time_in'];
		$time_in = date('H:i:s', strtotime($time_in));
		$time_out = $_POST['edit_time_out'];
		$time_out = date('H:i:s', strtotime($time_out));

		$sql = "UPDATE asistencia SET fecha = '$date', tiempo_entrada = '$time_in', tiempo_salida = '$time_out' WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Attendance updated successfully';

			$sql = "SELECT * FROM asistencia WHERE id = '$id'";
			$query = $conn->query($sql);
			$row = $query->fetch_assoc();
			$emp = $row['empleado_id'];

			$sql = "SELECT * FROM empleado as e LEFT JOIN horario as h ON h.id=e.horario_id WHERE e.id = '$emp'";
			$query = $conn->query($sql);
			$srow = $query->fetch_assoc();

			//updates
			$logstatus = ($time_in > $srow['tiempo_entrada']) ? 0 : 1;
			//

			if($srow['tiempo_entrada'] > $time_in){
				$time_in = $srow['tiempo_entrada'];
			}

			if($srow['tiempo_salida'] < $time_out){
				$time_out = $srow['tiempo_salida'];
			}

			$time_in = new DateTime($time_in);
			$time_out = new DateTime($time_out);
			$interval = $time_in->diff($time_out);
			$hrs = $interval->format('%h');
			$mins = $interval->format('%i');
			$mins = $mins/60;
			$int = $hrs + $mins;
			if($int > 4){
				$int = $int - 1;
			}

			$sql = "UPDATE asistencia SET numero_horas = '$int', estado = '$logstatus' WHERE id = '$id'";
			$conn->query($sql);
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

	header('location:attendance.php');

?>