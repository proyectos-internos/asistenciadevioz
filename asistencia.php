<style>
  .form-group select {
    margin-bottom: 10px; /* Puedes ajustar este valor según sea necesario */
  }
  .form-control input-lg 1{
    margin-top: 10px;
  }
</style>

<?php session_start(); ?>
<?php include 'header.php'; ?>
<body class="hold-transition login-page">
<div class="login-box">
  	<div class="login-logo">
  		<p id="date"></p>
      <p id="time" class="bold"></p>
  	</div>
  
  	<div class="login-box-body">
    	<h4 class="login-box-msg">Ingrese su ID de Empleado</h4>

    	<form id="attendance">
      <div class="form-group">
  <select class="form-control" name="status" id="statusSelect" onchange="showAdditionalFields()">
    <option value="" selected disabled>Seleccionar</option>
    <optgroup label="Problemas Tecnicos">
      <option value="in">Entrada - Salida</option>
      <option value="break">Refrigerio</option>
      <option value="topic">Topico</option>
      <option value="descon">Desconexion Temprana</option>
      <option value="problem">Problemas Tecnicos</option>
    </optgroup>
  </select>
</div>

<div id="entradaSalidaFields" style="display: none;" class="form-group">
  <select class="form-control" name="status" id="entradaSalidaCombo" onchange="showAdditionalFields()">
    <option value="in">Hora de Entrada</option>
    <option value="out">Hora de Salida</option>
  </select>
</div>

<div id="refrigerioFields" style="display: none;" class="form-group" > 
  <select class="form-control" name="status" id="refrigerioCombo">
   <option value="breakstart">Inicio de Refrigerio</option>
    <option value="breakend">Fin de Refrigerio</option>
  </select>
</div>

<div id="topicoFields" style="display: none;" class="form-group">
  <select class="form-control" name="status" id="topicoCombo">
    <option value="topist">Inicio de Topico</option>
    <option value="topice">Fin de Topico</option>
  </select>
</div>

<div id="desconexiontFields" style="display: none;" class="form-group" >
  <select class="form-control" name="status" id="desconexionCombo">
    <option value="disconnect">Desconexion</option>
  </select>
</div>

<div id="problemasTecnicosFields" style="display: none;" class="form-group" >
  <select class="form-control" name="status" id="problemasTecnicosCombo">
    <option value="problemstart">Inicio Problema</option>
    <option value="problemend">Fin Problema</option>
  </select>
</div>


<div id="horaEntradaFields" class="form-group has-feedback" style="display: none;">
  <input type="text" class="form-control input-lg" id="employee" name="employee" required>
  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
</div>
<div id="detalleFields" class="form-group has-feedback" style="display: none;">
  <input type="text" class="form-control input-lg" id="detalle" name="detalle" required>
  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
</div>
<div id="horaSalidaFields" class="form-group has-feedback" style="display: none;">
  <input type="text" class="form-control input-lg" id="employee2" name="employee2" required>
  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
</div>
<div id="InicioRefrigerioFields" class="form-group has-feedback 2" style="display: none;">
  <input type="text" class="form-control input-lg" id="employee3" name="employee3" required>
  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
</div>
<div id="FinRefrigerioFields" class="form-group has-feedback 2" style="display: none;">
  <input type="text" class="form-control input-lg" id="employee4" name="employee4" required>
  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
</div>
<div id="InicioTopicoFields" class="form-group has-feedback 3" style="display: none;">
  <input type="text" class="form-control input-lg" id="employee5" name="employee5" required>
  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
</div>
<div id="FinTopicoFields" class="form-group has-feedback 3" style="display: none;">
  <input type="text" class="form-control input-lg" id="employee6" name="employee6" required>
  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
</div>
<div id="DesconexionFields" class="form-group has-feedback 4" style="display: none;">
  <input type="text" class="form-control input-lg" id="employee7" name="employee7" required>
  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
</div>
<div id="InicioProblemaFields" class="form-group has-feedback 5" style="display: none;">
  <input type="text" class="form-control input-lg" id="employee8" name="employee8" required>
  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
</div>
<div id="FinProblemaFields" class="form-group has-feedback 5" style="display: none;">
  <input type="text" class="form-control input-lg" id="employee9" name="employee9" required>
  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
</div>

<script>
  function showAdditionalFields() {
  // Obtener todos los elementos de campo
  var allFields = document.querySelectorAll('.form-group[id$="Fields"]');
  
  // Ocultar todos los campos al principio
  allFields.forEach(function(field) {
    field.style.display = "none";
  });

  var statusSelect = document.getElementById("statusSelect");

  // Mostrar campos adicionales según la selección
  if (statusSelect.value === "in") {
    document.getElementById("entradaSalidaFields").style.display = "block";
    if (document.getElementById("entradaSalidaCombo").value === "in") {
      document.getElementById("horaEntradaFields").style.display = "block";
      document.getElementById("detalleFields").style.display = "block";
    } else if (document.getElementById("entradaSalidaCombo").value === "out") {
      document.getElementById("horaSalidaFields").style.display = "block";
      document.getElementById("detalleFields").style.display = "block";
    }
  } if (statusSelect.value === "break") {
  document.getElementById("refrigerioFields").style.display = "block";
  if (document.getElementById("refrigerioCombo").value === "breakstart") {
    document.getElementById("InicioRefrigerioFields").style.display = "block";  // Corregido aquí
  } else if (document.getElementById("refrigerioCombo").value === "breakend") {
    document.getElementById("FinRefrigerioFields").style.display = "block";
  }
  } else if (statusSelect.value === "topic") {
    document.getElementById("topicoFields").style.display = "block";
    if (document.getElementById("topicoCombo").value === "topist") {
      document.getElementById("InicioTopicoFields").style.display = "block";
    } else if (document.getElementById("topicoCombo").value === "topice") {
      document.getElementById("FinTopicoFields").style.display = "block";
    }
  } else if (statusSelect.value === "descon") {
    document.getElementById("desconexiontFields").style.display = "block";
    if (document.getElementById("desconexionCombo").value === "disconnect") {
      document.getElementById("DesconexionFields").style.display = "block";
    }
  } else if (statusSelect.value === "problem") {
    document.getElementById("problemasTecnicosFields").style.display = "block";
    if (document.getElementById("problemasTecnicosCombo").value === "problemstart") {
      document.getElementById("InicioProblemaFields").style.display = "block";
    } else if (document.getElementById("problemasTecnicosCombo").value === "problemend") {
      document.getElementById("FinProblemaFields").style.display = "block";
    }
  }
}
</script>
        
          <div class="form-group has-feedback">
                <!-- Recaptcha v2 - Google -->
                <div class="g-recaptcha" data-sitekey="6Lc8b0gpAAAAACbmtC66PuqGDMi6lybqQfKlT46k "></div>
          </div>
      		<div class="row">
    			<div class="col-xs-4">
          			<button type="submit" class="btn btn-primary btn-block btn-flat" name="signin"><i class="fa fa-sign-in"></i> Login</button>
        		</div>
      		</div>
    	</form>
  	</div>
		<div class="alert alert-success alert-dismissible mt20 text-center" style="display:none;">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <span class="result"><i class="icon fa fa-check"></i> <span class="message"></span></span>
    </div>
		<div class="alert alert-danger alert-dismissible mt20 text-center" style="display:none;">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <span class="result"><i class="icon fa fa-warning"></i> <span class="message"></span></span>
    </div>
  		
</div>
	
<?php include 'scripts.php' ?>
<script type="text/javascript">
$(function() {
  var interval = setInterval(function() {
    var momentNow = moment();
    $('#date').html(momentNow.format('dddd').substring(0,3).toUpperCase() + ' - ' + momentNow.format('MMMM DD, YYYY'));  
    $('#time').html(momentNow.format('hh:mm:ss A'));
  }, 100);

  $('#attendance').submit(function(e){
    e.preventDefault();
    var attendance = $(this).serialize();
    $.ajax({
      type: 'POST',
      url: 'attendance.php',
      data: attendance,
      dataType: 'json',
      success: function(response){
        if(response.error){
          $('.alert').hide();
          $('.alert-danger').show();
          $('.message').html(response.message);
        }
        else{
          $('.alert').hide();
          $('.alert-success').show();
          $('.message').html(response.message);
          $('#employee').val('');
        }
      }
    });
  });
    
});
</script>
</body>
</html>