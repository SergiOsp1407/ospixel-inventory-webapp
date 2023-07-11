let tblProducts;

document.addEventListener("DOMContentLoaded", function () {
  //Load data with datatables plugin
  //Load data with datatables plugin
  tblProducts = $("#tblProducts").DataTable({
    ajax: {
      url: base_url + "products/listInactives",
      dataSrc: "",
    },
    columns: [
      { data: "code" },
      { data: "description" },
      { data: "purchase_price" },
      { data: "sale_price" },
      { data: "quantity" },
      { data: "measure" },
      { data: "category" },
      { data: "image" },
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
function reactivateProduct(idProduct) {
  const url = base_url + "products/reactivate/" + idProduct;
  restoreRecords(url, tblProducts);
}
