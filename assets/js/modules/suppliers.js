let tblSuppliers, editAddress;

const form = document.querySelector("#form");
const btnAction = document.querySelector("#btnAction");
const btnNew = document.querySelector("#btnNew");

const nit = document.querySelector("#nit");
const name = document.querySelector("#name");
const phone = document.querySelector("#phone");
const email = document.querySelector("#email");
const address = document.querySelector("#address");
const id = document.querySelector("#id");

const errorNit = document.querySelector("#errorNit");
const errorSupplierName = document.querySelector("#errorSupplierName");
const errorPhone = document.querySelector("#errorPhone");
const errorEmail = document.querySelector("#errorEmail");
const errorAddress = document.querySelector("#errorAddress");

document.addEventListener("DOMContentLoaded", function () {
  //Load data with datatables plugin
  tblSuppliers = $("#tblSuppliers").DataTable({
    ajax: {
      url: base_url + "suppliers/list",
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

  //Usage of ckeditor
  ClassicEditor.create(document.querySelector("#address"), {
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
  })
    .then((editor) => {
      editAddress = editor;
    })
    .catch((error) => {
      console.error(error);
    });

  //Clean fields
  btnNew.addEventListener("click", function () {
    id.value = "";
    btnAction.textContent = "Registrar";
    editAddress.setData("");
    form.reset();
    cleanFields();
  });

  //Register suppliers
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    cleanFields();

    if (nit.value == "") {
      errorNit.textContent = "El NIT es requerido";
    } else if (name.value == "") {
      errorSupplierName.textContent = "El nombre del proveedor es requerido";
    } else if (phone.value == "") {
      errorPhone.textContent = "El teléfono del proveedor es requerido";
    } else if (email.value == "") {
      errorEmail.textContent =
        "El correo electrónico del proveedor es requerido";
    } else if (address.value == "") {
      errorAddress.textContent = "La dirección del proveedor es requerida";
    } else {
      const url = base_url + "suppliers/register";
      insertRecords(url, this, tblSuppliers, btnAction, false);
    }
  });
});

function deleteSupplier(idSupplier) {
  const url = base_url + "suppliers/delete/" + idSupplier;
  deleteRecords(url, tblSuppliers);
}

function editSupplier(idSupplier) {
  cleanFields();
  const url = base_url + "suppliers/edit/" + idSupplier;
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
      nit.value = response.nit;
      name.value = response.name;
      phone.value = response.phone;
      email.value = response.email;
      editAddress.setData(response.address);
      btnAction.textContent = "Actualizar";
      firstTab.show();
    }
  };
}

function cleanFields() {
  errorNit.textContent = "";
  errorSupplierName.textContent = "";
  errorPhone.textContent = "";
  errorEmail.textContent = "";
  errorAddress.textContent = "";
}
