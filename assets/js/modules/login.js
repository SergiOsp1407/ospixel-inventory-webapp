const form = document.querySelector("#form");
const email = document.querySelector("#email");
const password = document.querySelector("#password");

const errorEmail = document.querySelector("#errorEmail");
const errorPassword = document.querySelector("#errorPassword");

document.addEventListener("DOMContentLoaded", function () {
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    errorEmail.textContent = "";
    errorPassword.textContent = "";
    if (email.value == "") {
      errorEmail.textContent = "El correo es necesario";
    } else if (password.value == "") {
      errorPassword.textContent = "La contraseña es necesaria";
    } else {
      const url = base_url + "home/validate";
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

          Swal.fire("Mensaje", response.msg, response.type);

          if (response.type == "success") {
            setTimeout(() => {
              let timerInterval;
              Swal.fire({
                title: response.msg,
                html: "Creando cosas increíbles en <b></b> milisegundos.",
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                  Swal.showLoading();
                  const b = Swal.getHtmlContainer().querySelector("b");
                  timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft();
                  }, 100);
                },
                willClose: () => {
                  clearInterval(timerInterval);
                },
              }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                  window.location = base_url + "admin";
                }
              });
            }, 2000);
          }
        }
      };
    }
  });
});
