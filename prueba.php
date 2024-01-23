<style>
  .form-group select {
    margin-bottom: 10px; /* Puedes ajustar este valor según sea necesario */
  }
</style>

<div class="form-group">
  <select class="form-control" name="status" id="statusSelect" onchange="showAdditionalFields()">
    <option value="" selected disabled>Seleccionar</option>
    <optgroup label="Problemas Tecnicos">
      <option value="in">Entrada - Salida</option>
      <option value="break-start">Refrigerio</option>
      <option value="topic-start">Topico</option>
      <option value="disconnect">Desconexion Temprana</option>
      <option value="problem-start">Problemas Tecnicos</option>
    </optgroup>
  </select>
</div>

<div id="entradaSalidaFields" style="display: none;">
  <select class="form-control" name="status" id="entradaSalidaCombo" onchange="showAdditionalFields()">
    <option value="in">Hora de Entrada</option>
    <option value="out">Hora de Salida</option>
  </select>
</div>

<div id="refrigerioFields" style="display: none;">
  <select class="form-control" id="refrigerioCombo">
    <option value="break-start">Inicio de Refrigerio</option>
    <option value="break-end">Fin de Refrigerio</option>
  </select>
</div>

<div id="topicoFields" style="display: none;">
  <select class="form-control" id="topicoCombo">
    <option value="topic-start">Inicio de Topico</option>
    <option value="topic-end">Fin de Topico</option>
  </select>
</div>

<div id="desconexionFields" style="display: none;">
  <select class="form-control" id="desconexionCombo">
    <option value="disconnect">Desconexion</option>
  </select>
</div>

<div id="problemasTecnicosFields" style="display: none;">
  <select class="form-control" id="problemasTecnicosCombo">
    <option value="problem-start">Inicio Problema</option>
    <option value="problem-end">Fin Problema</option>
  </select>
</div>

<div class="form-group has-feedback">
  <input type="text" class="form-control input-lg" id="employee" name="employee" required>
  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
</div>

<script>
  function showAdditionalFields() {
    var selectedOption = document.getElementById("statusSelect").value;

    hideAllFields();

    switch (selectedOption) {
      case "in":
      case "out":
        showField("entradaSalidaFields", "entradaSalidaCombo");
        break;
      case "break-start":
      case "break-end":
        showField("refrigerioFields", "refrigerioCombo");
        break;
      case "topic-start":
      case "topic-end":
        showField("topicoFields", "topicoCombo");
        break;
      case "disconnect":
        showField("desconexionFields", "desconexionCombo");
        break;
      case "problem-start":
      case "problem-end":
        showField("problemasTecnicosFields", "problemasTecnicosCombo");
        break;
      default:
        break;
    }
  }

  function hideAllFields() {
    var fields = [
      "entradaSalidaFields",
      "refrigerioFields",
      "topicoFields",
      "desconexionFields",
      "problemasTecnicosFields"
    ];

    fields.forEach(function (field) {
      document.getElementById(field).style.display = "none";
    });
  }

  function showField(containerId, comboId) {
    document.getElementById(containerId).style.display = "block";
    showAdditionalInput(); // Mostrar el input adicional cuando se muestra el campo
  }

  function showAdditionalInput() {
    document.getElementById("additionalInput").style.display = "block";
  }

  function hideAdditionalInput() {
    document.getElementById("additionalInput").style.display = "none";
  }

  var topicoCombo = document.getElementById('topicoCombo');

  // Agrega un evento click al elemento select
  topicoCombo.addEventListener('click', function () {
    // Muestra el input al hacer clic en el select
    document.getElementById('employee').style.display = 'block';
  });

</script>




