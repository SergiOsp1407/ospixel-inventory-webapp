let tblProducts;
const form = document.querySelector('#form');
const btnAction = document.querySelector('#btnAction');

const code = document.querySelector('#code');
const description = document.querySelector('#description');
const purchase_price = document.querySelector('#purchase_price');
const sale_price = document.querySelector('#sale_price');
const id_measure = document.querySelector('#id_measure');
const id_category = document.querySelector('#id_category');

const errorCode = document.querySelector('#errorCode');
const errorDescription = document.querySelector('#errorDescription');
const errorPurchasePrice = document.querySelector('#errorPurchasePrice');
const errorSalePrice = document.querySelector('#errorSalePrice');
const errorMeasure = document.querySelector('#errorMeasure');
const errorCategory = document.querySelector('#errorCategory');

document.addEventListener("DOMContentLoaded", function () {
    //Load data with datatables plugin
  tblProducts = $("#tblProducts").DataTable({
    ajax: {
      url: base_url + "products/list",
      dataSrc: "",
    },
    columns: [{ data: "code" }, { data: "description" }, { data: "purchase_price" }, { data: "sale_price" }, { data: "quantity" }, { data: "measure" }, { data: "category" }, { data: "photo" }, { data: "actions" }],
    language: {
      url: base_url + "assets/js/spanish.json",
    },
    dom,
    buttons,
    responsive: true,
    order: [[0, "asc"]],
  });

  //Register products
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    errorCode.textContent = '';
    errorDescription.textContent = '';
    errorPurchasePrice.textContent = '';
    errorSalePrice.textContent = '';
    errorMeasure.textContent = '';
    errorCategory.textContent = '';

    if (code.value == '') {
        errorCode.textContent = 'El código es necesario';
    } else if (description.value == '') {
        errorDescription.textContent = 'El nombre del producto es necesario';
    } else if (purchase_price.value == '') {
        errorPurchasePrice.textContent = 'El valor de compra es necesario';
    } else if (sale_price.value == '') {
        errorSalePrice.textContent = 'El valor de venta es necesario';
    } else if (id_measure.value == '') {
        errorMeasure.textContent = 'Selecciona la medida';
    } else if (id_category.value == '') {
        errorCategory.textContent = 'Selecciona la categoría';
    }else{
        const url = base_url + 'products/register';
        insertRecords(url, this, tblProducts, btnAction, false);
    }
    
    
    
  });
});
