const tblNewSale = document.querySelector("#tblNewSale tbody");

const idClient = document.querySelector("#idClient");
const clientPhone = document.querySelector("#phone");
const clientAddress = document.querySelector("#address");

const discount = document.querySelector("#discount");
const paymentMethod = document.querySelector("#paymentMethod");

document.addEventListener("DOMContentLoaded", function () {
  //Load data from localStorage
  showProducts();

  //Autocomplete clients
  $("#searchClient").autocomplete({
    source: function (request, response) {
      $.ajax({
        url: base_url + "clients/search",
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
      clientPhone.value = ui.item.phone;
      clientAddress.innerHTML = ui.item.address;
      idClient.value = ui.item.id;
    },
  });

  //Complete Sale
  btnAction.addEventListener("click", function () {
    const files = document.querySelectorAll("#tblNewSale tr").length;
    if (files < 2) {
      customAlert("warning", "Carrito vacío");
      return;
    } else if (idClient.value == "" && clientPhone.value == "") {
      customAlert("warning", "El cliente es necesario");
      return;
    } else if (paymentMethod.value == "") {
      customAlert("warning", "El método de pago es necesaria");
      return;
    } else {
      const url = base_url + "sales/registerSale";
      //Create an instance of XMLHttpRequest
      const http = new XMLHttpRequest();
      //Open connection - POST - GET
      http.open("POST", url, true);
      //Sen data
      http.send(
        JSON.stringify({
          products: listShoppingCart,
          idClient: idClient.value,
          paymentMethod: paymentMethod.value,
          discount: discount.value,
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
                    "sales/report/receipt/" +
                    response.idSale;
                  window.open(route, "_blank");
                } else if (result.isDenied) {
                  const route =
                    base_url +
                    "sales/report/invoice/" +
                    response.idSale;
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
                      <td>${product.sale_price}</td>
                      <td width="100">
                      <input type="number" class="form-control inputQuantity" data-id="${product.id}" value="${product.quantity}" placeholder="Cantidad">
                      </td>
                      <td>${product.subTotalSale}</td>
                      <td><button class="btn btn-danger btnDelete" data-id="${product.id}" type="button"><i class="fas fa-trash"></i></button></td>
                  </tr>`;
          });
          tblNewSale.innerHTML = html;
          totalPay.value = response.totalSale;
          btnDeleteProduct();
          addQuantity();
        } else {
          tblNewSale.innerHTML = "";
        }
      }
    };
  } else {
    tblNewSale.innerHTML = `<tr>
              <td colspan="4" class="text-center">Carrito vacío</td>
          </tr>`;
  }
}
