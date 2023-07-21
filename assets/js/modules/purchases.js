const tblNewPurchase = document.querySelector("#tblNewPurchase tbody");
const serie = document.querySelector("#serie");

//Suppliers info
const supplierPhone = document.querySelector("#phone");
const supplierAddress = document.querySelector("#address");
const idSupplier = document.querySelector("#idSupplier");

document.addEventListener("DOMContentLoaded", function () {
  //Autocomplete suppliers
  $("#searchSupplier").autocomplete({
    source: function (request, response) {
      $.ajax({
        url: base_url + "suppliers/search",
        dataType: "json",
        data: {
          term: request.term,
        },
        success: function (data) {
          response(data);
        },
      });
    },
    minLength: 2,
    select: function (event, ui) {
      supplierPhone.value = ui.item.phone;
      supplierAddress.innerHTML = ui.item.address;
      idSupplier.value = ui.item.id;
      serie.focus();
    },
  });

  //Load data
  showProducts();

  //Complete purchase
  btnAction.addEventListener("click", function () {
    const files = document.querySelectorAll("#tblNewPurchase tr").length;
    if (files < 2) {
      customAlert("warning", "Carrito vacío");
      return;
    } else if (idSupplier.value == "" && supplierPhone.value == "") {
      customAlert("warning", "El proveedor es necesario");
      return;
    } else if (serie.value == "") {
      customAlert("warning", "La serie es necesaria");
      return;
    } else {
      const url = base_url + "purchases/registerPurchase";
      //Create an instance of XMLHttpRequest
      const http = new XMLHttpRequest();
      //Open connection - POST - GET
      http.open("POST", url, true);
      //Sen data
      http.send(
        JSON.stringify({
          products: listShoppingCart,
          idSupplier: idSupplier.value,
          serie: serie.value,
        })
      );
      //Check status
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const response = JSON.parse(this.responseText);
          console.log(this.responseText);
          customAlert(response.type, response.msg);
          if (response.type == "success") {
            localStorage.removeItem(nameKey);
            setTimeout(() => {
              Swal.fire({
                title: "¿Desea generar el reporte?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Recibo",
                denyButtonText: `Factura`,
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                  const route =
                    base_url +
                    "purchases/report/receipt/" +
                    response.idPurchase;
                  window.open(route, "_blank");
                } else if (result.isDenied) {
                  const route =
                    base_url +
                    "purchases/report/invoice/" +
                    response.idPurchase;
                  window.open(route, "_blank");
                }
                window.location.reload();
              });
            }, 2000);
          }
        }
      };
    }
  });

  //Show purchases historial
  //Load data with datatables plugin
  tblHistory = $("#tblHistory").DataTable({
    ajax: {
      url: base_url + "purchases/list",
      dataSrc: "",
    },
    columns: [
      { data: "date" },
      { data: "time" },
      { data: "total" },
      { data: "name" },
      { data: "serie" },
      { data: "actions" },
    ],
    language: {
      url: base_url + "assets/js/spanish.json",
    },
    dom,
    buttons,
    responsive: true,
    order: [[0, "desc"]],
  });

  
});

//Load products
function showProducts() {
  if (localStorage.getItem(nameKey) != null) {
    const url = base_url + "products/showData";
    //Create an instance of XMLHttpRequest
    const http = new XMLHttpRequest();
    //Open connection - POST - GET
    http.open("POST", url, true);
    //Sen data
    http.send(JSON.stringify(listShoppingCart));
    //Check status
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const response = JSON.parse(this.responseText);
        let html = "";
        if (response.products.length > 0) {
          response.products.forEach((product) => {
            html += `<tr>
                    <td>${product.description}</td>
                    <td>${product.purchase_price}</td>
                    <td width="100">
                    <input type="number" class="form-control inputQuantity" data-id="${product.id}" value="${product.quantity}" placeholder="Cantidad">
                    </td>
                    <td>${product.subTotalPurchase}</td>
                    <td><button class="btn btn-danger btnDelete" data-id="${product.id}" type="button"><i class="fas fa-trash"></i></button></td>
                </tr>`;
          });
          tblNewPurchase.innerHTML = html;
          totalPay.value = response.totalPurchase;
          btnDeleteProduct();
          addQuantity();
        } else {
          tblNewPurchase.innerHTML = "";
        }
      }
    };
  } else {
    tblNewPurchase.innerHTML = `<tr>
            <td colspan="4" class="text-center">Carrito vacío</td>
        </tr>`;
  }
}

function viewReport(idPurchase) {
  Swal.fire({
    title: "¿Desea generar el reporte?",
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: "Recibo",
    denyButtonText: `Factura`,
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      const route = base_url + "purchases/report/receipt/" + idPurchase;
      window.open(route, "_blank");
    } else if (result.isDenied) {
      const route = base_url + "purchases/report/invoice/" + idPurchase;
      window.open(route, "_blank");
    }
  });
}

function cancelPurchase(idPurchase) {
  Swal.fire({
    title: "¿Deseas eliminar el registro?",
    text: "El stock de los productos se reintegrará",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminalo!",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "purchases/cancel/" + idPurchase;
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
          customAlert(response.type, response.msg);
          if (response.type == "success") {
            tblHistory.ajax.reload();
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
