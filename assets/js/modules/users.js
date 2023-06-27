let tblUsers;
const form = document.querySelector("#form");
const names = document.querySelector("#names");
const lastname = document.querySelector("#lastname");
const email = document.querySelector("#email");
const phone = document.querySelector("#phone");
const address = document.querySelector("#address");
const password = document.querySelector("#password");
const rol = document.querySelector("#rol");

//Elements to show errors
const errorNames = document.querySelector("#errorNames");
const errorLastname = document.querySelector("#errorLastname");
const errorEmail = document.querySelector("#errorEmail");
const errorPhone = document.querySelector("#errorPhone");
const errorAddress = document.querySelector("#errorAddress");
const errorPassword = document.querySelector("#errorPassword");
const errorRol = document.querySelector("#errorRol");

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

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    errorNames.textContent = "";
    errorLastname.textContent = "";
    errorEmail.textContent = "";
    errorPhone.textContent = "";
    errorAddress.textContent = "";
    errorPassword.textContent = "";
    errorRol.textContent = "";

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
      //Create formData
      const data = new FormData(this);
      //Create an instance of XMLHttpRequest
      const http = new XMLHttpRequest();
      //Open connection - POST - GET
      http.open("POST", url, true);
      //Sen data
      http.send(data);
      //Check status
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const response = JSON.parse(this.responseText);
          Swal.fire({
            toast: true,
            position: "top-right",
            icon: response.type,
            title: response.msg,
            showConfirmButton: false,
            timer: 2000,
          });
          if (response.type == "success") {
            form.reset();
            tblUsers.ajax.reload();
          }
        }
      };
    }
  });
});

//Delete Users function
function deleteUser(idUser) {
  Swal.fire({
    title: "Deseas desactivar el usuario?",
    text: "Esta acción se puede reversar.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminalo!",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "users/delete/" + idUser;
      //Create an instance of XMLHttpRequest
      const http = new XMLHttpRequest();
      //Open connection - POST - GET
      http.open('GET', url, true);
      //Sen data
      http.send();
      //Check status
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const response = JSON.parse(this.responseText);
          Swal.fire({
            toast: true,
            position: "top-right",
            icon: response.type,
            title: response.msg,
            showConfirmButton: false,
            timer: 2000,
          });
          if (response.type == 'success') {
            tblUsers.ajax.reload();
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
