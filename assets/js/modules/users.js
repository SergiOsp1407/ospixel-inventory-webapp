let tblUsers;
const form = document.querySelector("#form");
const names = document.querySelector("#names");
const lastname = document.querySelector("#lastname");
const email = document.querySelector("#email");
const phone = document.querySelector("#phone");
const address = document.querySelector("#address");
const password = document.querySelector("#password");
const rol = document.querySelector("#rol");
const id = document.querySelector("#id");

//Elements to show errors
const errorNames = document.querySelector("#errorNames");
const errorLastname = document.querySelector("#errorLastname");
const errorEmail = document.querySelector("#errorEmail");
const errorPhone = document.querySelector("#errorPhone");
const errorAddress = document.querySelector("#errorAddress");
const errorPassword = document.querySelector("#errorPassword");
const errorRol = document.querySelector("#errorRol");
const btnAction = document.querySelector("#btnAction");
const btnNew = document.querySelector("#btnNew");

document.addEventListener("DOMContentLoaded", function () {
  //Load data with datatables plugin
  tblUsers = $("#tblUsers").DataTable({
    ajax: {
      url: base_url + "users/list",
      dataSrc: "",
    },
    columns: [
      { data: "completeName" },
      { data: "email" },
      { data: "phone" },
      { data: "address" },
      { data: "rol" },
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

  //Clean fields
  btnNew.addEventListener("click", function () {
    id.value = "";
    btnAction.textContent = "Registrar";
    password.removeAttribute("readonly");
    form.reset();
    names.focus();
    cleanFields();
  });

  //Register users
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    cleanFields();
    if (names.value == "") {
      errorNames.textContent = "El nombre es requerido";
    } else if (lastname.value == "") {
      errorLastname.textContent = "El apellido es requerido";
    } else if (email.value == "") {
      errorEmail.textContent = "El correo es requerido";
    } else if (phone.value == "") {
      errorPhone.textContent = "El teléfono es requerido";
    } else if (address.value == "") {
      errorAddress.textContent = "La dirección es requerida";
    } else if (password.value == "") {
      errorPassword.textContent = "La contraseña es requerido";
    } else if (rol.value == "") {
      errorRol.textContent = "El rol es requerido";
    } else {
      const url = base_url + "users/register";
      insertRecords(url, this, tblUsers, btnAction, true);
    }
  });
});

//Delete Users function
function deleteUser(idUser) {
  const url = base_url + "users/delete/" + idUser;
  deleteRecords(url, tblUsers);
}

//Edit Users function
function editUser(idUser) {
  cleanFields();
  const url = base_url + "users/edit/" + idUser;
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
      names.value = response.name;
      lastname.value = response.lastname;
      email.value = response.email;
      phone.value = response.phone;
      address.value = response.address;
      rol.value = response.rol;
      password.value = "000000";
      password.setAttribute("readonly", "readonly");
      btnAction.textContent = "Actualizar";
      const firstTabEl = document.querySelector("#nav-tab button:last-child");
      const firstTab = new bootstrap.Tab(firstTabEl);
      firstTab.show();
    }
  };
}

function cleanFields() {
  errorNames.textContent = "";
  errorLastname.textContent = "";
  errorEmail.textContent = "";
  errorPhone.textContent = "";
  errorAddress.textContent = "";
  errorPassword.textContent = "";
  errorRol.textContent = "";
}
