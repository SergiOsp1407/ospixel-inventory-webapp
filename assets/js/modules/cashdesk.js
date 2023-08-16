const initial_value = document.querySelector("#initial_value");
const btnOpenCashdesh = document.querySelector("#btnOpenCashdesh");

const form = document.querySelector("#form");
const valueExpense = document.querySelector("#value");
const description = document.querySelector("#description");
const btnRegisterExpense = document.querySelector("#btnRegisterExpense");

let tblExpenses, myChart;

document.addEventListener("DOMContentLoaded", function () {
  //Check status
  btnOpenCashdesh.addEventListener("click", function () {
    if (initial_value.value == "") {
      customAlert("warning", "El valor es requerido!");
    } else {
      const url = base_url + "cashdesk/openCashdesk";
      //Create an instance of XMLHttpRequest
      const http = new XMLHttpRequest();
      //Open connection - POST - GET
      http.open("POST", url, true);
      //Sen data
      http.send(
        JSON.stringify({
          amount: initial_value.value,
        })
      );
      //Check status
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const response = JSON.parse(this.responseText);
          customAlert(response.type, response.msg);
          window.location.reload();
        }
      };
    }
  });

  if (form && document.querySelector("#transactionReport")) {
    //Load data with datatables plugin
    $("#tblOpenCloseCash").DataTable({
      ajax: {
        url: base_url + "cashdesk/list",
        dataSrc: "",
      },
      columns: [
        { data: "initial_value" },
        { data: "opening_date" },
        { data: "closing_date" },
        { data: "final_value" },
        { data: "total_sales_quantity" },
        { data: "name" },
        { data: "action" }
      ],
      language: {
        url: base_url + "assets/js/spanish.json",
      },
      dom,
      buttons,
      responsive: true,
      order: [[2, "asc"]],
    });

    //Usage of ckeditor
    ClassicEditor.create(document.querySelector("#description"), {
      toolbar: {
        items: [
          "selectAll",
          "|",
          "heading",
          "|",
          "bold",
          "italic",
          "|",
          "outdent",
          "indent",
          "|",
          "undo",
          "redo",
          "alignment",
          "|",
          "link",
          "blockQuote",
          "insertTable",
          "mediaEmbed",
        ],
        shouldNotGroupWhenFull: true,
      },
    }).catch((error) => {
      console.error(error);
    });

    //Register expense
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      if (valueExpense.value == "") {
        customAlert("warning", "El valor es requerido!");
      } else if (description.value == "") {
        customAlert("warning", "La descripción es requerida");
      } else {
        const url = base_url + "cashdesk/registerExpense";
        insertRecords(url, this, tblExpenses, btnRegisterExpense, false);
        setTimeout(() => {
          window.location.reload();
        }, 2000);
      }
    });

    //Load data with datatables plugin
    tblExpenses = $("#tblExpenses").DataTable({
      ajax: {
        url: base_url + "cashdesk/listExpenses",
        dataSrc: "",
      },
      columns: [{ data: "value" }, { data: "description" }, { data: "photo" }],
      language: {
        url: base_url + "assets/js/spanish.json",
      },
      dom,
      buttons,
      responsive: true,
      order: [[0, "asc"]],
    });
    transactions();
  }
});

function transactions() {
  const url = base_url + "cashdesk/transactions";
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
      // if (myChart) {
      //   myChart.destroy();
      // }
      var ctx = document.getElementById("transactionReport").getContext("2d");

      myChart = new Chart(ctx, {
        type: "pie",
        data: {
          labels: ["Monto inicial", "Ingresos", "Gastos", "Egresos", "Saldo"],
          datasets: [
            {
              backgroundColor: [
                "#0c62e0",
                "#515a62",
                "#128e0a",
                "#e4ad07",
                "#e20e22",
              ],

              hoverBackgroundColor: [
                "#0c62e0",
                "#515a62",
                "#128e0a",
                "#e4ad07",
                "#e20e22",
              ],

              data: [
                response.initialValue,
                response.income,
                response.expenses,
                response.outgoings,
                response.remainder,
              ],
              borderWidth: [1, 1, 1, 1, 1],
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          cutoutPercentage: 0,
          legend: {
            position: "bottom",
            display: false,
            labels: {
              boxWidth: 8,
            },
          },
          tooltips: {
            displayColors: false,
          },
        },
      });

      let html = `<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
        <div><i class="fas fa-check-circle"></i> Monto Inicial</div><span class="badge bg-primary rounded-pill">${
          response.currency + " " + response.initialValueDecimal
        }</span>
      </li>
      <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
        <div><i class="fas fa-check-circle"></i> Ingresos</div><span class="badge bg-secondary rounded-pill">${
          response.currency + " " + response.incomeDecimal
        }</span>
      </li>
      <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
        <div><i class="fas fa-check-circle"></i> Gastos</div><span class="badge bg-success rounded-pill">${
          response.currency + " " + response.expensesDecimal
        }</span>
      </li>
      <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
        <div><i class="fas fa-check-circle"></i> Egresos</div><span class="badge bg-warning rounded-pill">${
          response.currency + " " + response.outgoingsDecimal
        }</span>
      </li>
      <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
        <div><i class="fas fa-check-circle"></i> Saldo</div><span class="badge bg-danger rounded-pill">${
          response.currency + " " + response.remainderDecimal
        }</span>
      </li>`;
      document.querySelector("#listTransactions").innerHTML = html;
    }
  };
}

function closeCashdesk() {
  Swal.fire({
    title: "¿Deseas cerrar la caja?",
    text: "Esta acción no se puede reversar.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cierrala!",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + 'cashdesk/closeCashdesk';
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
          if (response.type == "success") {
            window.location.reload();
          }
        }
      };
      // Swal.fire(
      //   'Deleted!',
      //   'Your file has been deleted.',
      //   'success'
      // )
    }
  });
}
