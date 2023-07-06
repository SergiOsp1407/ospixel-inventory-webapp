let tblCategories;

const form = document.querySelector("#form");
const id = document.querySelector("#id");
const category = document.querySelector("#category");
const errorCategory = document.querySelector("#errorCategory");
const btnAction = document.querySelector("#btnAction");
const btnNew = document.querySelector("#btnNew");

document.addEventListener("DOMContentLoaded", function () {
  //Load data with datatables plugin
  tblCategories = $("#tblCategories").DataTable({
    ajax: {
      url: base_url + "categories/list",
      dataSrc: "",
    },
    columns: [{ data: "category" }, { data: "date" }, { data: "actions" }],
    language: {
      url: base_url + "assets/js/spanish.json",
    },
    dom,
    buttons,
    responsive: true,
    order: [[0, "asc"]],
  });

  btnNew.addEventListener('click', function() {
    id.value = '';
    btnAction.textContent = 'Registrar';
    form.reset();    
  });

  //Create category
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    errorCategory.textContent = "";
    if (category.value == "") {
      errorCategory.textContent = "* El nombre de la categoría es necesario";
    } else {
      const url = base_url + "categories/register";
      insertRecords(url, this, tblCategories, btnAction, false);
    }
  });
});

function deleteCategory(idCategory) {
  const url = base_url + "categories/delete/" + idCategory;
  deleteRecords(url, tblCategories);
}

function editCategory(idCategory) {
  const url = base_url + "categories/edit/" + idCategory;
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
      category.value = response.category;
      btnAction.textContent = "Actualizar";
      firstTab.show();
    }
  };
}
