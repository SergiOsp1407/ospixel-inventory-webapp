const inputSearchByCode = document.querySelector("#searchByProductCode");
const inputSearchByName = document.querySelector("#searchByProductName");
const barCode = document.querySelector("#barCode");
const description = document.querySelector("#description");
const containerCode = document.querySelector("#containerCode");
const containerName = document.querySelector("#containerName");

const btnAction = document.querySelector("#btnAction");
const totalPay = document.querySelector("#totalPay");

//Variables used in date filter
const from = document.querySelector("#from");
const until = document.querySelector("#until");

let listShoppingCart, tblHistory;

document.addEventListener("DOMContentLoaded", function () {
  //Check products on localStorage
  if (localStorage.getItem(nameKey) != null) {
    listShoppingCart = JSON.parse(localStorage.getItem(nameKey));
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
      addProduct(ui.item.id, 1, ui.item.stock);
      inputSearchByName.value = "";
      inputSearchByName.focus();
      return false;
    },
  });

  //Filter by date ranges
  from.addEventListener("change", function () {
    tblHistory.draw();
  });
  until.addEventListener("change", function () {
    tblHistory.draw();
  });

  //Function to create filters in date , in order to show purchases history
  $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var FilterStart = from.value;
    var FilterEnd = until.value;
    var DataTableStart = data[0].trim();
    var DataTableEnd = data[0].trim();
    if (FilterStart == "" || FilterEnd == "") {
      return true;
    }
    if (DataTableStart >= FilterStart && DataTableEnd <= FilterEnd) {
      return true;
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
      if (response.status) {
        addProduct(response.dataSet.id, 1, response.dataSet.quantity);        
      }else{
        customAlert('warning', 'Código no encontrado');
      }
      inputSearchByCode.value = "";
      inputSearchByCode.focus();        
    }
  };
}

//Add products to localStorage
function addProduct(idProduct, quantity, actualStock) {
  

  if (localStorage.getItem(nameKey) == null) {
    listShoppingCart = [];
  } else {
    if (nameKey === "posSale") {
      let quantityAdded = 0;
      for (let i = 0; i < listShoppingCart.length; i++) {
        if (listShoppingCart[i]["id"] == idProduct) {
          quantityAdded =
            parseInt(listShoppingCart[i]["quantity"]) + parseInt(quantity);
        }
      }
      console.log(quantityAdded);
      if (quantityAdded > actualStock) {
        customAlert("warning", "Unidades insuficientes");
        return;
      }
    }
    
    for (let i = 0; i < listShoppingCart.length; i++) {
      if (listShoppingCart[i]["id"] == idProduct) {
        listShoppingCart[i]["quantity"] = parseInt(
          listShoppingCart[i]["quantity"] + 1
        );
        localStorage.setItem(nameKey, JSON.stringify(listShoppingCart));
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

  localStorage.setItem(nameKey, JSON.stringify(listShoppingCart));
  customAlert("success", "Producto agregado");
  showProducts();
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
  localStorage.setItem(nameKey, JSON.stringify(listShoppingCart));
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
  if (nameKey === "posSale") {
    const url = base_url + "sales/checkStock/" + idProduct;
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
        if (response.quantity >= quantity) {
          for (let i = 0; i < listShoppingCart.length; i++) {
            if (listShoppingCart[i]["id"] == idProduct) {
              listShoppingCart[i]["quantity"] = quantity;
            }
          }
          localStorage.setItem(nameKey, JSON.stringify(listShoppingCart));
          
        } else {
          customAlert("warning", "Unidades insuficientes");
        }
        showProducts();
        return;
      }
    };
  } else {
    for (let i = 0; i < listShoppingCart.length; i++) {
      if (listShoppingCart[i]["id"] == idProduct) {
        listShoppingCart[i]["quantity"] = quantity;
      }
    }
    localStorage.setItem(nameKey, JSON.stringify(listShoppingCart));
    showProducts();
  }
}
