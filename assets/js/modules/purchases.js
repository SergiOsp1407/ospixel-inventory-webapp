const inputSearchByCode = document.querySelector("#searchByProductCode");
const inputSearchByName = document.querySelector("#searchByProductName");
const barCode = document.querySelector("#barCode");
const description = document.querySelector("#description");
const containerCode = document.querySelector("#containerCode");
const containerName = document.querySelector("#containerName");

const tblNewPurchase = document.querySelector("#tblNewPurchase tbody");
const totalPay = document.querySelector("#totalPay");
const serie = document.querySelector("#serie");

//Suppliers info
const supplierPhone = document.querySelector("#phone");
const supplierAddress = document.querySelector("#address");
const idSupplier = document.querySelector("#idSupplier");

const btnAction = document.querySelector("#btnAction");

let listShoppingCart;

document.addEventListener("DOMContentLoaded", function () {
  //Check products on localStorage
  if (localStorage.getItem("posPurchase") != null) {
    listShoppingCart = JSON.parse(localStorage.getItem("posPurchase"));
  }
  //Show input for search by description
  description.addEventListener("click", function () {
    containerCode.classList.add("d-none");
    containerName.classList.remove("d-none");
    inputSearchByName.value = "";
    inputSearchByName.focus();
  });

  //Show input for search by code
  barCode.addEventListener("click", function () {
    containerName.classList.add("d-none");
    containerCode.classList.remove("d-none");
    inputSearchByCode.value = "";
    inputSearchByCode.focus();
  });

  inputSearchByCode.addEventListener("keyup", function (e) {
    if (e.keyCode === 13) {
      searchProduct(e.target.value);
    }
    return;
  });

  //Autocomplete products
  $("#searchByProductName").autocomplete({
    source: function (request, response) {
      $.ajax({
        url: base_url + "products/searchByName",
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
      console.log(ui.item);
      addProduct(ui.item.id, 1);
      inputSearchByName.value = "";
      inputSearchByName.focus();
      return false;
    },
  });

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
    } else if (
      idSupplier.value == "" &&
      supplierPhone.value == ""
    ) {
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
          if (response.type == 'success') {
            localStorage.removeItem('posPurchase');
            setTimeout(() => {
              window.location.reload();
              // window.open('route, _blank');
            }, 2000);
            
          }
        }
      };
    }
  });
});

function searchProduct(value) {
  const url = base_url + "products/searchByCode/" + value;
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
      console.log(this.responseText);
      addProduct(response.id, 1);
      inputSearchByCode.value = "";
      inputSearchByCode.focus();
    }
  };
}

//Add products to localStorage
function addProduct(idProduct, quantity) {
  if (localStorage.getItem("posPurchase") == null) {
    listShoppingCart = [];
  } else {
    for (let i = 0; i < listShoppingCart.length; i++) {
      if (listShoppingCart[i]["id"] == idProduct) {
        listShoppingCart[i]["quantity"] = parseInt(
          listShoppingCart[i]["quantity"] + 1
        );
        localStorage.setItem("posPurchase", JSON.stringify(listShoppingCart));
        customAlert("success", "Producto agregado");
        showProducts();
        return;
      }
    }
  }
  listShoppingCart.push({
    id: idProduct,
    quantity: quantity,
  });

  localStorage.setItem("posPurchase", JSON.stringify(listShoppingCart));
  customAlert("success", "Producto agregado");
  showProducts();
}

//Load products
function showProducts() {
  if (localStorage.getItem("posPurchase") != null) {
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
                    <td>${product.subTotal}</td>
                    <td><button class="btn btn-danger btnDelete" data-id="${product.id}" type="button"><i class="fas fa-trash"></i></button></td>
                </tr>`;
          });
          tblNewPurchase.innerHTML = html;
          totalPay.value = response.total;
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

//Add click event to delete
function btnDeleteProduct() {
  let list = document.querySelectorAll(".btnDelete");
  for (let i = 0; i < list.length; i++) {
    list[i].addEventListener("click", function () {
      let idProduct = list[i].getAttribute("data-id");
      console.log(idProduct);
      deleteProduct(idProduct);
    });
  }
}

//Delete product from table
function deleteProduct(idProduct) {
  for (let i = 0; i < listShoppingCart.length; i++) {
    if (listShoppingCart[i]["id"] == idProduct) {
      listShoppingCart.splice(i, 1);
    }
  }
  localStorage.setItem("posPurchase", JSON.stringify(listShoppingCart));
  customAlert("success", "Producto eliminado");
  showProducts();
}

//Add change event to increase products quantities
function addQuantity() {
  let list = document.querySelectorAll(".inputQuantity");
  for (let i = 0; i < list.length; i++) {
    list[i].addEventListener("change", function () {
      let idProduct = list[i].getAttribute("data-id");
      let quantity = list[i].value;
      changeQuantity(idProduct, quantity);
    });
  }
}

function changeQuantity(idProduct, quantity) {
  for (let i = 0; i < listShoppingCart.length; i++) {
    if (listShoppingCart[i]["id"] == idProduct) {
      listShoppingCart[i]["quantity"] = quantity;
    }
  }
  localStorage.setItem("posPurchase", JSON.stringify(listShoppingCart));
  showProducts();
}
