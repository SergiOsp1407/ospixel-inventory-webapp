let tblInventory;
const btnSearch = document.querySelector("#btnSearch");
const btnReport = document.querySelector("#btnReport");
const month = document.querySelector("#month");

document.addEventListener("DOMContentLoaded", function () {
  //Load all data
  loadInventory(base_url + "inventory/listTransactions");

  
  //Filter
  btnSearch.addEventListener("click", function () {
    if (month.value == "") {
      customAlert("warning", "Selecciona el mes");
    } else {
      const url = base_url + "inventory/listTransactions/" + month.value;
      loadInventory(url);
    }
  });

  //Report inventory
  btnReport.addEventListener("click", function () {
    if (month.value == "") {
      window.open(base_url + "inventory/report", '_blank');
    } else {
      const url = base_url + "inventory/report/" + month.value;
      window.open(url, '_blank');
    }
  });
});

function loadInventory(route) {
  //Load data with datatables plugin
  tblInventory = $("#tblInventory").DataTable({
    ajax: {
      url: route,
      dataSrc: "",
    },
    columns: [
      { data: "description" },
      { data: "transaction" },
      { data: "date" },
      { data: "quantity" },
    ],
    language: {
      url: base_url + "assets/js/spanish.json",
    },
    dom,
    buttons,
    responsive: true,
    destroy: true,
    order: [[2, "desc"]],
  });
}
