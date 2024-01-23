<?php
	$conn = new mysqli('localhost', 'root', '', 'nomina');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>