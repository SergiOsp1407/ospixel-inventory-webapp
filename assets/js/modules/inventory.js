let tblInventory;
const btnSearch = document.querySelector("#btnSearch");
const btnReport = document.querySelector("#btnReport");
const btnAdjustment = document.querySelector("#btnAdjustment");
const month = document.querySelector("#month");

const modalAdjustment = new bootstrap.Modal("#modalAdjustment");
const searchCodeAdjustment = document.querySelector("#searchCodeAdjustment");
const searchNameAdjustment = document.querySelector("#searchNameAdjustment");
const barCodeAdjustment = document.querySelector("#barCodeAdjustment");
const descriptionAdjustment = document.querySelector("#descriptionAdjustment");

const quantityAdjustment = document.querySelector("#quantityAdjustment");
const idProductAdjustment = document.querySelector("#idProductAdjustment");

const containerCodeAdjustment = document.querySelector(
  "#containerCodeAdjustment"
);
const containerNameAdjustment = document.querySelector(
  "#containerNameAdjustment"
);

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
      window.open(base_url + "inventory/report", "_blank");
    } else {
      const url = base_url + "inventory/report/" + month.value;
      window.open(url, "_blank");
    }
  });

  //Adjusting inventory
  btnAdjustment.addEventListener("click", function () {
    modalAdjustment.show();
  });

  //Show input for search by description
  descriptionAdjustment.addEventListener("click", function () {
    containerCodeAdjustment.classList.add("d-none");
    containerNameAdjustment.classList.remove("d-none");
    searchNameAdjustment.value = "";
    idProductAdjustment.value = "";
    searchNameAdjustment.focus();
  });

  //Show input for search by code
  barCodeAdjustment.addEventListener("click", function () {
    containerNameAdjustment.classList.add("d-none");
    containerCodeAdjustment.classList.remove("d-none");
    searchCodeAdjustment.value = "";
    idProductAdjustment.value = "";
    searchCodeAdjustment.focus();
  });

  searchCodeAdjustment.addEventListener("keyup", function (e) {
    if (e.keyCode === 13) {
      productByCode(e.target.value);
    }
    return;
  });

  //Autocomplete products
  $("#searchNameAdjustment").autocomplete({
    source: function (request, response) {
      $.ajax({
        url: base_url + "products/searchByName",
        dataType: "json",
        data: {
          term: request.term,
        },
        success: function (data) {
          response(data);
        },
      });
    },
    minLength: 2,
    select: function (event, ui) {
      idProductAdjustment.value = ui.item.id;
      quantityAdjustment.focus();
    },
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

function productByCode(value) {
  const url = base_url + "products/searchByCode/" + value;
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
      if (response.status) {
        idProductAdjustment.value = response.dataSet.id;
        searchCodeAdjustment.value = response.dataSet.description;
        quantityAdjustment.focus();
      } else {
        customAlert("warning", "Código no encontrado");
      }
    }
  };
}
