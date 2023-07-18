const inputSearchByCode = document.querySelector("#searchByProductCode");
const inputSearchByName = document.querySelector("#searchByProductName");
const barCode = document.querySelector("#barCode");
const description = document.querySelector("#description");
const containerCode = document.querySelector("#containerCode");
const containerName = document.querySelector("#containerName");

const tblNewPurchase = document.querySelector("#tblNewPurchase tbody");

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
    },
  });

  //Load data
  showProducts();
});

function searchProduct(value) {
  const url = base_url + "products/searchCode/" + value;
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
        console.log(this.responseText);
        let html = "";
        if (response.products.length > 0) {
          response.products.forEach((product) => {
            html += `<tr>
                    <td>${product.description}</td>
                    <td>${product.purchase_price}</td>
                    <td>${product.quantity}</td>
                    <td>${product.subTotal}</td>
                </tr>`;
          });
          tblNewPurchase.innerHTML = html;
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
