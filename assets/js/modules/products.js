let tblProducts;
const form = document.querySelector("#form");
const btnAction = document.querySelector("#btnAction");
const btnNew = document.querySelector("#btnNew");

const id = document.querySelector("#id");
const code = document.querySelector("#code");
const description = document.querySelector("#description");
const purchase_price = document.querySelector("#purchase_price");
const sale_price = document.querySelector("#sale_price");
const id_measure = document.querySelector("#id_measure");
const id_category = document.querySelector("#id_category");
const photo = document.querySelector("#photo");
const actual_photo = document.querySelector("#actual_photo");
const containerPreview = document.querySelector("#containerPreview");

const errorCode = document.querySelector("#errorCode");
const errorDescription = document.querySelector("#errorDescription");
const errorPurchasePrice = document.querySelector("#errorPurchasePrice");
const errorSalePrice = document.querySelector("#errorSalePrice");
const errorMeasure = document.querySelector("#errorMeasure");
const errorCategory = document.querySelector("#errorCategory");

document.addEventListener("DOMContentLoaded", function () {
  //Load data with datatables plugin
  tblProducts = $("#tblProducts").DataTable({
    ajax: {
      url: base_url + "products/list",
      dataSrc: "",
    },
    columns: [
      { data: "code" },
      { data: "description" },
      { data: "purchase_price" },
      { data: "sale_price" },
      { data: "quantity" },
      { data: "measure" },
      { data: "category" },
      { data: "image" },
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

  //Preview - Image
  photo.addEventListener("change", function (e) {
    actual_photo.value = "";
    if (
      e.target.files[0].type == "image/png" ||
      e.target.files[0].type == "image/jpg" ||
      e.target.files[0].type == "image/jpeg"
    ) {
      const url = e.target.files[0];
      const tmpUrl = URL.createObjectURL(url);
      containerPreview.innerHTML = `
        <img class="img-thumbnail" src="${tmpUrl}" width="200">
        <button class="btn btn-danger" type="button" onclick="deleteImg()"><i class="fas fa-trash"></i></button>
      `;
    } else {
      photo.value = "";
      customAlert(
        "warning",
        "Archivo no permitido. Solo se permiten imágenes con extensiones png, jpg y jpeg"
      );
    }
  });

  //Clean fields
  btnNew.addEventListener("click", function () {
    id.value = "";
    btnAction.textContent = "Registrar";
    form.reset();
    deleteImg();
    cleanFields();
  });

  //Register products
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    cleanFields();
    if (code.value == "") {
      errorCode.textContent = "El código es necesario";
    } else if (description.value == "") {
      errorDescription.textContent = "El nombre del producto es necesario";
    } else if (purchase_price.value == "") {
      errorPurchasePrice.textContent = "El valor de compra es necesario";
    } else if (sale_price.value == "") {
      errorSalePrice.textContent = "El valor de venta es necesario";
    } else if (id_measure.value == "") {
      errorMeasure.textContent = "Selecciona la medida";
    } else if (id_category.value == "") {
      errorCategory.textContent = "Selecciona la categoría";
    } else {
      const url = base_url + "products/register";
      insertRecords(url, this, tblProducts, btnAction, false);
    }
  });
});

//Delete image
function deleteImg() {
  photo.value = "";
  containerPreview.innerHTML = "";
  actual_photo.value = "";
}

function deleteProduct(idProduct) {
  const url = base_url + "products/delete/" + idProduct;
  deleteRecords(url, tblProducts);
}

function editProduct(idProduct) {
  cleanFields();
  const url = base_url + "products/edit/" + idProduct;
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
      id.value = response.id;
      code.value = response.code;
      description.value = response.description;
      purchase_price.value = response.purchase_price;
      sale_price.value = response.sale_price;
      id_measure.value = response.id_measure;
      id_category.value = response.id_category;
      actual_photo.value = response.photo;
      containerPreview.innerHTML = `
        <img class="img-thumbnail" src="${
          base_url + response.photo
        }" width="200">
        <button class="btn btn-danger" type="button" onclick="deleteImg()"><i class="fas fa-trash"></i></button>
      `;
      btnAction.textContent = "Actualizar";
      firstTab.show();
    }
  };
}

function cleanFields() {
  errorCode.textContent = "";
  errorDescription.textContent = "";
  errorPurchasePrice.textContent = "";
  errorSalePrice.textContent = "";
  errorMeasure.textContent = "";
  errorCategory.textContent = "";
}
