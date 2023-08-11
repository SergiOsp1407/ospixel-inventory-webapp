const initial_value = document.querySelector("#initial_value");
const btnOpenCashdesh = document.querySelector("#btnOpenCashdesh");

const form = document.querySelector("#form");
const valueExpense = document.querySelector("#value");
const description = document.querySelector("#description");
const btnRegisterExpense = document.querySelector("#btnRegisterExpense");

document.addEventListener("DOMContentLoaded", function () {
  btnOpenCashdesh.addEventListener("click", function () {
    if (initial_value.value == "") {
      customAlert("warning", "El valor es requerido!");
    } else {
        const url = base_url + 'cashdesk/openCashdesk';        
        //Create an instance of XMLHttpRequest
        const http = new XMLHttpRequest();
        //Open connection - POST - GET
        http.open("POST", url, true);
        //Sen data
        http.send(JSON.stringify({
            amount : initial_value.value
        }));
        //Check status
        http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const response = JSON.parse(this.responseText);
          customAlert(response.type, response.msg);        
        }
      };


    }
  });

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
      { data: "name" }
    ],
    language: {
      url: base_url + "assets/js/spanish.json",
    },
    dom,
    buttons,
    responsive: true,
    order: [[0, "asc"]],
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
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    if (valueExpense.value == '') {
      customAlert("warning", "El valor es requerido!");      
    } else if (description.value == '') {
      customAlert("warning", "La descripción es requerida");
    } else {
      const url = base_url + 'cashdesk/registerExpense';
      insertRecords(url, this, null, btnRegisterExpense, false);
    }
  })
});
