let tblUsers;

document.addEventListener("DOMContentLoaded", function () {
  //Load data with datatables plugin
  tblUsers = $("#tblUsers").DataTable({
    ajax: {
      url: base_url + "users/listInactives",
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
});


//Reactivate Users function
function reactivateUser(idUser) {
    Swal.fire({
      title: "Deseas activar el usuario?",
      text: "Esta acción se puede reversar.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, activalo de nuevo!",
    }).then((result) => {
      if (result.isConfirmed) {
        const url = base_url + "users/reactivate/" + idUser;
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
            Swal.fire({
              toast: true,
              position: "top-right",
              icon: response.type,
              title: response.msg,
              showConfirmButton: false,
              timer: 2000,
            });
            if (response.type == "success") {
              tblUsers.ajax.reload();
            }
          }
        };
      }
    });
  }
