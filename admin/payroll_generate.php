<?php
	include 'includes/session.php';

	function generateRow($from, $to, $conn, $deduction){
		$contents = '';
	 	
		$sql = "SELECT *, sum(numero_horas) AS total_hr, a.empleado_id AS empid FROM asistencia as a LEFT JOIN empleado as e ON e.id=a.empleado_id LEFT JOIN posicion as p ON p.id=e.posicion_id WHERE date BETWEEN '$from' AND '$to' GROUP BY a.empleado_id ORDER BY e.nombre ASC, e.apellido ASC";

		$query = $conn->query($sql);
		$total = 0;
		while($row = $query->fetch_assoc()){
			$empid = $row['empid'];
                      
	      	$casql = "SELECT *, SUM(cantidad) AS cashamount FROM adelanto_efecivo WHERE empleado_id='$empid' AND fecha_advance BETWEEN '$from' AND '$to'";
	      
	      	$caquery = $conn->query($casql);
	      	$carow = $caquery->fetch_assoc();
	      	$cashadvance = $carow['cashamount'];

			$gross = $row['tasa'] * $row['total_hr'];
			$total_deduction = $deduction + $cashadvance;
      		$net = $gross - $total_deduction;

			$total += $net;
			$contents .= '
			<tr>
				<td>'.$row['apellido'].', '.$row['nombre'].'</td>
				<td>'.$row['empleado_id'].'</td>
				<td align="right">'.number_format($net, 2).'</td>
			</tr>
			';
		}

		$contents .= '
			<tr>
				<td colspan="2" align="right"><b>Total</b></td>
				<td align="right"><b>'.number_format($total, 2).'</b></td>
			</tr>
		';
		return $contents;
	}
		
	$range = $_POST['date_range'];
	$ex = explode(' - ', $range);
	$from = date('Y-m-d', strtotime($ex[0]));
	$to = date('Y-m-d', strtotime($ex[1]));

	$sql = "SELECT *, SUM(cantidad) as total_amount FROM deducciones";
    $query = $conn->query($sql);
   	$drow = $query->fetch_assoc();
    $deduction = $drow['total_amount'];

	$from_title = date('M d, Y', strtotime($ex[0]));
	$to_title = date('M d, Y', strtotime($ex[1]));

	require_once('../tcpdf/tcpdf.php');  
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('Nomina: '.$from_title.' - '.$to_title);  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 11);  
    $pdf->AddPage();  
    $content = '';  
    $content .= '
      	<h2 align="center">ConfiguroWeb</h2>
      	<h4 align="center">'.$from_title." - ".$to_title.'</h4>
      	<table border="1" cellspacing="0" cellpadding="3">  
           <tr>  
           		<th width="40%" align="center"><b>Nombre Empleado</b></th>
                <th width="30%" align="center"><b>ID Empleado</b></th>
				<th width="30%" align="center"><b>Salario Neto</b></th> 
           </tr>  
      ';  
    $content .= generateRow($from, $to, $conn, $deduction);  
    $content .= '</table>';  
    $pdf->writeHTML($content);  
    $pdf->Output('payroll.pdf', 'I');

?>