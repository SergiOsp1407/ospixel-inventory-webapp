let tblMeasures;

document.addEventListener("DOMContentLoaded", function () {
  //Load data with datatables plugin
  tblMeasures = $("#tblMeasures").DataTable({
    ajax: {
      url: base_url + "measures/listInactives",
      dataSrc: "",
    },
    columns: [
      { data: "measure" },
      { data: "short_name" },
      { data: "actions" },
    ],
    language: {
      url: base_url + "assets/js/spanish.json",
    },
    dom,
    buttons,
    responsive: true,
    order: [[0, "asc"]],
  });
});

//Reactivate Users function
function reactivateMeasure(idMeasure) {
  const url = base_url + "measures/reactivate/" + idMeasure;
  restoreRecords(url, tblMeasures);
}
