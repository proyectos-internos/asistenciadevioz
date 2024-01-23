<?php
	session_start();

	if(isset($_POST['employee'])){
		$output = array('error' => false);

		include 'conn.php';
		include 'timezone.php';

		$employeeDNI = $_POST['employee'];
		$status = $_POST['status'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$captcha = $_POST['g-recaptcha-response'];
		$secretkey = "6Lc8b0gpAAAAAOo1B1NIeuBId2vaC_K9fLb4DeKN";
		
		// Validación y saneamiento de la entrada del usuario
		$employeeDNI = $conn->real_escape_string($employeeDNI);

		// Verificar el captcha utilizando cURL
		$ch = curl_init("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$respuesta = curl_exec($ch);
		curl_close($ch);

		$atributos = json_decode($respuesta, true);

		if(!$atributos['success']){
			$output['error'] = true;
			$output['message'] = 'Verificar Captcha';
			echo json_encode($output);
			exit;
		}

		$sql = "SELECT * FROM employees WHERE dni = '$employeeDNI'";
		$query = $conn->query($sql);

		if($query->num_rows > 0){
			$row = $query->fetch_assoc();
			$id = $row['id'];

			$date_now = date('Y-m-d');

			if($status == 'in'){
				$sql = "SELECT * FROM asistencia WHERE empleado_id = '$id' AND fecha = '$date_now' AND tiempo_entrada IS NOT NULL";
				$query = $conn->query($sql);
			
				if($query->num_rows > 0){
					$output['error'] = true;
					$output['message'] = 'Tu hora de llegada ya ha sido registrada anteriormente.';
				} else {
					// No existe registro previo para la fecha actual, proceder con el registro
					$sched = $row['schedule_id'];
					$lognow = date('H:i:s');
					$sql = "SELECT * FROM schedules WHERE id = '$sched'";
					$squery = $conn->query($sql);
					$srow = $squery->fetch_assoc();
					$logstatus = ($lognow > $srow['time_in']) ? 0 : 1;
				
					// Restar 5 horas a la fecha y hora actual para obtener el time_in ajustado
					$date_now = date('Y-m-d H:i:s');  
					$date_now_adjusted = date('Y-m-d H:i:s', strtotime('+0 hours', strtotime($date_now)));
				
					// Insertar en la tabla attendance con la fecha y hora ajustada
					$sql = "INSERT INTO asistencia (empleado_id, fecha, tiempo_entrada, estado) VALUES ('$id', '$date_now', '$date_now_adjusted', '$logstatus')";
					
					if($conn->query($sql)){
						$output['message'] = 'Tu hora de llegada ha sido marcada exitosamente. Bienvenido, '.$row['firstname'].' '.$row['lastname'].'.';
					} else {
						$output['error'] = true;
						$output['message'] = 'Error al marcar la hora de llegada: '.$conn->error;
					}
				}
				
						
			} else {
				$sql = "SELECT *, a.id AS uid FROM asistencia AS a LEFT JOIN empleado AS e ON e.id=a.empleado_id WHERE a.empleado_id = '$id' AND fecha = '$date_now'";
				$query = $conn->query($sql);
			
				if($query->num_rows < 1){
					$output['error'] = true;
					$output['message'] = 'No se puede registrar tu salida sin previamente registrar tu entrada.';
				} else {
					$row = $query->fetch_assoc();
			
					if($row['time_out'] != '00:00:00'){
						$output['error'] = true;
						$output['message'] = 'Tu salida ya ha sido registrada satisfactoriamente para el día de hoy.';
					} else {
						// Obtener información del horario y calcular el estado de la jornada
						$sched = $row['horario_id'];
						$lognow = date('H:i:s');
						$sql = "SELECT * FROM horario WHERE id = '$sched'";
						$squery = $conn->query($sql);
						$srow = $squery->fetch_assoc();
						$logstatus = ($lognow > $srow['tiempo_entrada']) ? 0 : 1;
			
						// Marcar la salida
						$sql = "UPDATE asistencia SET tiempo_entrada = NOW(), estado = '$logstatus' WHERE id = '".$row['uid']."'";
						
						if($conn->query($sql)){
							$output['message'] = 'Salida: '.$row['nombre'].' '.$row['apellido'].'. Gracias por tu jornada de trabajo.';
			
							// Resto del código para actualizar información adicional si es necesario
						} else {
							$output['error'] = true;
							$output['message'] = 'Error al marcar la salida: '.$conn->error;
						}
					}
				
				}
			}
		}
	}
	echo json_encode($output);
?>