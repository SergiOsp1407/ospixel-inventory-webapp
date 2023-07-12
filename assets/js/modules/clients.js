let tblClients, editAddress;

const form = document.querySelector("#form");
const btnAction = document.querySelector("#btnAction");
const btnNew = document.querySelector("#btnNew");

const identity_type = document.querySelector("#identity_type");
const client_identity = document.querySelector("#client_identity");
const name = document.querySelector("#name");
const phone = document.querySelector("#phone");
const email = document.querySelector("#email");
const address = document.querySelector("#address");
const id = document.querySelector("#id");

const errorIdentityType = document.querySelector("#errorIdentityType");
const errorClientIdentity = document.querySelector("#errorClientIdentity");
const errorClientName = document.querySelector("#errorClientName");
const errorPhone = document.querySelector("#errorPhone");
const errorAddress = document.querySelector("#errorAddress");

document.addEventListener("DOMContentLoaded", function () {
  //Load data with datatables plugin
  tblClients = $("#tblClients").DataTable({
    ajax: {
      url: base_url + "clients/list",
      dataSrc: "",
    },
    columns: [
      { data: "identity_type" },
      { data: "client_identity" },
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
  .then(editor => {
    editAddress = editor;
  })
  .catch((error) => {
    console.error(error);
  });

  //Clean fields
  btnNew.addEventListener('click', function () {

    id.value = '';    
    btnAction.textContent = 'Registrar';
    editAddress.setData('');
    form.reset();  
    
  })

  //Register clients
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    errorIdentityType.textContent = "";
    errorClientIdentity.textContent = "";
    errorClientName.textContent = "";
    errorPhone.textContent = "";
    errorEmail.textContent = "";
    errorAddress.textContent = "";

    if (identity_type.value == "") {
      errorIdentityType.textContent = "El tipo de identificación es requerido";
    } else if (client_identity.value == "") {
      errorClientIdentity.textContent =
        "El número de identificación es requerido";
    } else if (name.value == "") {
      errorClientName.textContent = "El nombre del cliente es requerido";
    } else if (phone.value == "") {
      errorPhone.textContent = "El teléfono del cliente es requerido";
    } else if (address.value == "") {
      errorAddress.textContent = "La dirección del cliente es requerida";
    } else {
      const url = base_url + "clients/register";
      insertRecords(url, this, tblClients, btnAction, false);
    }
  });
});

function deleteClient(idClient) {
  const url = base_url + "clients/delete/" + idClient;
  deleteRecords(url, tblClients);
}

function editClient(idClient) {
  const url = base_url + "clients/edit/" + idClient;
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
      identity_type.value = response.identity_type;
      client_identity.value = response.client_identity;
      name.value = response.name;
      phone.value = response.phone;
      email.value = response.email;
      editAddress.setData(response.address);
      btnAction.textContent = "Actualizar";
      firstTab.show();
    }
  };
}
