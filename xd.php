<div class="form-group">
  <select class="form-control" name="status" id="statusSelect" onchange="showAdditionalFields()">
    <option value="" selected disabled>Seleccionar</option>
    <optgroup label="Problemas Tecnicos">
      <option value="horario">Entrada - Salida</option>
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

<div id="refrigerioFields" style="display: none;" class="form-group" onchange="showAdditionalFields()"> 
  <select class="form-control" name="status" id="refrigerioCombo">
   <option value="breakstart">Inicio de Refrigerio</option>
    <option value="breakend">Fin de Refrigerio</option>
  </select>
</div>

<div id="topicoFields" style="display: none;" class="form-group" onchange="showAdditionalFields()">
  <select class="form-control" name="status" id="topicoCombo">
    <option value="topist">Inicio de Topico</option>
    <option value="topice">Fin de Topico</option>
  </select>
</div>

<div id="desconexiontFields" style="display: none;" class="form-group" onchange="showAdditionalFields()">
  <select class="form-control" name="status" id="desconexionCombo">
    <option value="disconnect">Desconexion</option>
  </select>
</div>

<div id="problemasTecnicosFields" style="display: none;" class="form-group" onchange="showAdditionalFields()">
  <select class="form-control" name="status" id="problemasTecnicosCombo">
    <option value="problemstart">Inicio Problema</option>
    <option value="problemend">Fin Problema</option>
  </select>
</div>


<div id="horaEntradaFields" class="form-group has-feedback" style="display: none;">
  <input type="text" class="form-control input-lg" id="employee1" name="employee1" required>
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
  if (statusSelect.value === "horario") {
    document.getElementById("entradaSalidaFields").style.display = "block";
    if (document.getElementById("entradaSalidaCombo").value === "in") {
      document.getElementById("horaEntradaFields").style.display = "block";
    } else if (document.getElementById("entradaSalidaCombo").value === "out") {
      document.getElementById("horaSalidaFields").style.display = "block";
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



