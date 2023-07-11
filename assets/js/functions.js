const firstTabEl = document.querySelector("#nav-tab button:last-child");
const firstTab = new bootstrap.Tab(firstTabEl);

function insertRecords(url, idForm, tbl, idButton, action) {
  //Create formData
  const data = new FormData(idForm);
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
        if (action) {
          password.removeAttribute("readonly");
        }
        if (tbl != null) {
          document.querySelector("#id").value = "";
          idButton.textContent = "Registrar";
          idForm.reset();
          tbl.ajax.reload();
        }
      }
    }
  };
}

function deleteRecords(url, tbl) {
  Swal.fire({
    title: "Deseas eliminar el registro?",
    text: "Esta acción se puede reversar.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminalo!",
  }).then((result) => {
    if (result.isConfirmed) {
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
            tbl.ajax.reload();
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

function restoreRecords(url, tbl) {
  Swal.fire({
    title: "Deseas activar el registro?",
    text: "Esta acción se puede reversar.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, activalo de nuevo!",
  }).then((result) => {
    if (result.isConfirmed) {
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
            tbl.ajax.reload();
          }
        }
      };
    }
  });
}

function customAlert(type, msg) {
  Swal.fire({
    toast: true,
    position: "top-right",
    icon: type,
    title: msg,
    showConfirmButton: false,
    timer: 2000,
  });
}
