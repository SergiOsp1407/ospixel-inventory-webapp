let tblCredits, tblPartialPayments;
const idCredit = document.querySelector("#idCredit");
const searchClient = document.querySelector("#searchClient");
const phone = document.querySelector("#phone");
const address = document.querySelector("#address");
const partialpayment = document.querySelector("#partialpayment");
const remainingbalance = document.querySelector("#remainingbalance");
const date = document.querySelector("#date");
const value_credit = document.querySelector("#value_credit");
const paid_value = document.querySelector("#paid_value");
const btnAction = document.querySelector("#btnAction");

const newPartialPayment = document.querySelector("#newPartialPayment");
const modalPartialpayment = new bootstrap.Modal("#modalPartialpayment");

//Variables used in date filter
const from = document.querySelector("#from");
const until = document.querySelector("#until");

document.addEventListener("DOMContentLoaded", function () {
  //Load data with datatables plugin
  tblCredits = $("#tblCredits").DataTable({
    ajax: {
      url: base_url + "credits/list",
      dataSrc: "",
    },
    columns: [
      { data: "date" },
      { data: "value_credit" },
      { data: "name" },
      { data: "remainingbalance" },
      { data: "partialpayment" },
      { data: "sale" },
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

  //Autocomplete clients
  $("#searchClient").autocomplete({
    source: function (request, response) {
      $.ajax({
        url: base_url + "credits/search",
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
      phone.value = ui.item.phone;
      address.innerHTML = ui.item.address;
      idCredit.value = ui.item.id;

      partialpayment.value = ui.item.partialpayment;
      remainingbalance.value = ui.item.remainingbalance;
      value_credit.value = ui.item.value_credit;
      date.value = ui.item.date;

      paid_value.focus();
    },
  });

  //Open modal to add payment
  newPartialPayment.addEventListener("click", function () {
    idCredit.value = "";
    phone.value = "";
    searchClient.value = "";
    address.innerHTML = "";
    partialpayment.value = "";
    remainingbalance.value = "";
    value_credit.value = "";
    date.value = "";
    paid_value.value = "";
    modalPartialpayment.show();
  });

  btnAction.addEventListener("click", function () {
    if (paid_value.value == "") {
      customAlert("warning", "Ingresa el monto a abonar");
    } else if (
      idCredit.value == "" &&
      searchClient.value == "" &&
      phone.value == ""
    ) {
      customAlert("warning", "Busca y selecciona el cliente");
    } else if (parseFloat(remainingbalance.value) < parseFloat(paid_value.value)) {
      customAlert("warning", "El abono es mayor al saldo restante del crédito");
    } else {
      const url = base_url + "credits/registerPartialPayment";
      //Create an instance of XMLHttpRequest
      const http = new XMLHttpRequest();
      //Open connection - POST - GET
      http.open("POST", url, true);
      //Sen data
      http.send(
        JSON.stringify({
          idCredit: idCredit.value,
          paid_value: paid_value.value,
        })
      );
      //Check status
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const response = JSON.parse(this.responseText);
          customAlert(response.type, response.msg);
          if (response.type == "success") {
            modalPartialpayment.hide();
            tblCredits.ajax.reload();
            setTimeout(() => {
              const route = base_url + 'credits/report/' + idCredit.value;
              window.open(route, '_blank');
            }, 2000);
          }
        }
      };
    }
  });

  //Load data with datatables plugin
  tblPartialPayments = $("#tblPartialPayments").DataTable({
    ajax: {
      url: base_url + "credits/listPartialPayments",
      dataSrc: "",
    },
    columns: [
      { data: "date" },
      { data: "partial_payment" },
      { data: "credit" }
    ],
    language: {
      url: base_url + "assets/js/spanish.json",
    },
    dom,
    buttons,
    responsive: true,
    order: [[0, "asc"]],
  });

  //Filter by date ranges
  from.addEventListener("change", function () {
    tblCredits.draw();
  });
  until.addEventListener("change", function () {
    tblCredits.draw();
  });

  //Function to create filters in date , in order to show purchases history
  $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var FilterStart = from.value;
    var FilterEnd = until.value;
    var DataTableStart = data[0].trim();
    var DataTableEnd = data[0].trim();
    if (FilterStart == "" || FilterEnd == "") {
      return true;
    }
    if (DataTableStart >= FilterStart && DataTableEnd <= FilterEnd) {
      return true;
    }
  });
});
