let tblCategories;

document.addEventListener("DOMContentLoaded", function () {
  //Load data with datatables plugin
  tblCategories = $("#tblCategories").DataTable({
    ajax: {
      url: base_url + "categories/listInactives",
      dataSrc: "",
    },
    columns: [
      { data: "category" },
      { data: "date" },
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
function reactivateCategory(idCategory) {
  const url = base_url + "categories/reactivate/" + idCategory;
  restoreRecords(url, tblCategories);
}
