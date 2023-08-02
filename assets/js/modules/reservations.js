const modalReservation = new bootstrap.Modal("#modalReservation");
const modalRetirement = new bootstrap.Modal("#modalRetirement");
const date_reservation = document.querySelector("#date_reservation");
const date_retirement = document.querySelector("#date_retirement");
const partialPayment = document.querySelector("#partialPayment");
const color = document.querySelector("#color");

const tblNewReservation = document.querySelector("#tblNewReservation tbody");

const idClient = document.querySelector("#idClient");
const clientPhone = document.querySelector("#phone");
const clientAddress = document.querySelector("#address");

const idReservation = document.querySelector("#idReservation");
const clientReservation = document.querySelector("#clientReservation");
const partialPaymentRet = document.querySelector("#partialPaymentRet");
const total = document.querySelector("#total");
const missingToPay = document.querySelector("#missingToPay");

const btnProcess = document.querySelector("#btnProcess");

document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");
  var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay",
    },
    locale: "es",
    events: base_url + "reservations/list",
    dateClick: function (info) {
      const actualDate = document.querySelector("#actualDate").value;
      if (actualDate > info.dateStr) {
        customAlert("warning", "Fecha pasada");
        return;
      } else {
        date_reservation.value = info.dateStr;
        date_retirement.setAttribute("min", date_reservation.value);
        modalReservation.show();
      }
    },
    eventClick: function (info) {
      const url = base_url + "reservations/showData/" + info.event.id;
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
          const totalMissing =
            parseFloat(response.total) - parseFloat(response.partialPayment);
          idReservation.value = response.id;
          clientReservation.value = response.name;
          partialPaymentRet.value = response.partialPayment;
          total.value = response.total;
          missingToPay.value = totalMissing.toFixed(2);
          modalRetirement.show();
        }
      };
    },
  });
  calendar.render();

  btnProcess.addEventListener("click", function () {
    Swal.fire({
      title: "¿Deseas procesar la entrega?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, procesar!",
    }).then((result) => {
      if (result.isConfirmed) {
        const url =
          base_url + "reservations/processRetirement/" + idReservation.value;
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
            triggerPdf(idReservation.value);
            idReservation.value = "";
            modalRetirement.hide();
          }
        };
      }
    });
  });

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

  //Complete Reservations
  btnAction.addEventListener("click", function () {
    const files = document.querySelectorAll("#tblNewReservation tr").length;
    if (files < 2) {
      customAlert("warning", "Carrito vacío");
      return;
    } else if (idClient.value == "" && clientPhone.value == "") {
      customAlert("warning", "El cliente es necesario");
      return;
    } else if (date_reservation.value == "") {
      customAlert("warning", "La fecha de reserva es necesaria");
      return;
    } else if (date_retirement.value == "") {
      customAlert(
        "warning",
        "La fecha de reserva retiro del producto es necesaria"
      );
      return;
    } else if (partialPayment.value == "") {
      customAlert("warning", "El valor del abono es necesario");
      return;
    } else {
      const url = base_url + "reservations/registerReservation";
      //Create an instance of XMLHttpRequest
      const http = new XMLHttpRequest();
      //Open connection - POST - GET
      http.open("POST", url, true);
      //Sen data
      http.send(
        JSON.stringify({
          products: listShoppingCart,
          idClient: idClient.value,
          date_reservation: date_reservation.value,
          date_retirement: date_retirement.value,
          partialPayment: partialPayment.value,
          color: color.value,
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
            triggerPdf(response.idReservation);
          }
        }
      };
    }
  });

  //Load data with datatables plugin
  tblHistory = $("#tblHistory").DataTable({
    ajax: {
      url: base_url + "reservations/listHistory",
      dataSrc: "",
    },
    columns: [
      { data: "date_create" },
      { data: "name" },
      { data: "partialPayment" },
      { data: "total" },
      { data: "date_reservation" },
      { data: "date_retirement" },
      { data: "status" },
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
          tblNewReservation.innerHTML = html;
          totalPay.value = response.totalSale;
          btnDeleteProduct();
          addQuantity();
        } else {
          tblNewReservation.innerHTML = `<tr>
            <td colspan="5" class="text-center">Carrito vacío</td>
            </tr>`;
        }
      }
    };
  } else {
    tblNewReservation.innerHTML = `<tr>
                <td colspan="5" class="text-center">Carrito vacío</td>
                </tr>`;
  }
}

function triggerPdf(idReservation) {
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
        const route = base_url + "reservations/report/receipt/" + idReservation;
        window.open(route, "_blank");
      } else if (result.isDenied) {
        const route = base_url + "reservations/report/invoice/" + idReservation;
        window.open(route, "_blank");
      }
      window.location.reload();
    });
  }, 2000);
}

function viewReport(idReservation) {
  Swal.fire({
    title: "¿Desea generar el reporte?",
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: "Recibo",
    denyButtonText: `Factura`,
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      const route = base_url + "reservations/report/receipt/" + idReservation;
      window.open(route, "_blank");
    } else if (result.isDenied) {
      const route = base_url + "reservations/report/invoice/" + idReservation;
      window.open(route, "_blank");
    }
  });
}
