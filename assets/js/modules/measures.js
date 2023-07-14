let tblMeasures;
const form = document.querySelector("#form");
const id = document.querySelector("#id");
const measure = document.querySelector("#measure");
const short_name = document.querySelector("#short_name");
const errorMeasure = document.querySelector("#errorMeasure");
const errorShortname = document.querySelector("#errorShortname");

const btnAction = document.querySelector("#btnAction");
const btnNew = document.querySelector("#btnNew");

document.addEventListener("DOMContentLoaded", function () {
  //Load data with datatables plugin
  tblMeasures = $("#tblMeasures").DataTable({
    ajax: {
      url: base_url + "measures/list",
      dataSrc: "",
    },
    columns: [{ data: "measure" }, { data: "short_name" }, { data: "actions" }],
    language: {
      url: base_url + "assets/js/spanish.json",
    },
    dom,
    buttons,
    responsive: true,
    order: [[0, "asc"]],
  });

  btnNew.addEventListener("click", function () {
    id.value = "";
    errorMeasure.textContent = "";
    errorShortname.textContent = "";
    btnAction.textContent = "Registrar";
    form.reset();
  });

  //Create measure/dimension
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    errorMeasure.textContent = "";
    errorShortname.textContent = "";
    if (measure.value == "") {
      errorMeasure.textContent = "El nombre de la medida es requerido";
    } else if (short_name.value == "") {
      errorShortname.textContent = "La abreviación es requerida";
    } else {
      const url = base_url + "measures/register";
      insertRecords(url, this, tblMeasures, btnAction, false);
    }
  });
});

function deleteMeasure(idMeasure) {
  const url = base_url + "measures/delete/" + idMeasure;
  deleteRecords(url, tblMeasures);
}

function editMeasure(idMeasure) {
  errorMeasure.textContent = "";
  errorShortname.textContent = "";
  const url = base_url + "measures/edit/" + idMeasure;
  //Create an instance of XMLHttpRequest
  const http = new XMLHttpRequest();
  //Open connection - POST - GET
  http.open("GET", url, true);
  //Sen data
  http.send();
  //Check status
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const response = JSON.parse(this.responseText);
      id.value = response.id;
      measure.value = response.measure;
      short_name.value = response.short_name;
      btnAction.textContent = "Actualizar";
      firstTab.show();
    }
  };
}
