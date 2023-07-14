let tblSuppliers;

document.addEventListener("DOMContentLoaded", function () {
  //Load data with datatables plugin
  tblSuppliers = $("#tblSuppliers").DataTable({
    ajax: {
      url: base_url + "suppliers/listInactives",
      dataSrc: "",
    },
    columns: [
      { data: "nit" },
      { data: "name" },
      { data: "phone" },
      { data: "email" },
      { data: "address" },
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
function reactivateSupplier(idSupplier) {
  const url = base_url + "suppliers/reactivate/" + idSupplier;
  restoreRecords(url, tblSuppliers);
}
