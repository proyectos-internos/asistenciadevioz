<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$employee = $_POST['employee'];
		$date = $_POST['date'];
		$time_in = $_POST['time_in'];
		$time_in = date('H:i:s', strtotime($time_in));
		$time_out = $_POST['time_out'];
		$time_out = date('H:i:s', strtotime($time_out));

		$sql = "SELECT * FROM empleado WHERE empleado_id = '$employee'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Employee not found';
		}
		else{
			$row = $query->fetch_assoc();
			$emp = $row['id'];

			$sql = "SELECT * FROM asistencia WHERE empleado_id = '$emp' AND fecha = '$date'";
			$query = $conn->query($sql);

			if($query->num_rows > 0){
				$_SESSION['error'] = 'Employee attendance for the day exist';
			}
			else{
				//updates
				$sched = $row['horario_id'];
				$sql = "SELECT * FROM horario WHERE id = '$sched'";
				$squery = $conn->query($sql);
				$scherow = $squery->fetch_assoc();
				$logstatus = ($time_in > $scherow['tiempo_entrada']) ? 0 : 1;
				//
				$sql = "INSERT INTO asistencia (empleado_id, fecha, tiempo_entrada, tiempo_salida, estado) VALUES ('$emp', '$date', '$time_in', '$time_out', '$logstatus')";
				if($conn->query($sql)){
					$_SESSION['success'] = 'Attendance added successfully';
					$id = $conn->insert_id;

					$sql = "SELECT * FROM empleado as e LEFT JOIN horario as h ON h.id=e.horario_id WHERE e.id = '$emp'";
					$query = $conn->query($sql);
					$srow = $query->fetch_assoc();

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

					$sql = "UPDATE asistencia SET numero_horas = '$int' WHERE id = '$id'";
					$conn->query($sql);

				}
				else{
					$_SESSION['error'] = $conn->error;
				}
			}
		}
	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}
	
	header('location: attendance.php');

?>