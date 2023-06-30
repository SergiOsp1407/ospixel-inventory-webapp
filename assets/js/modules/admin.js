const form = document.querySelector("#form");
const btnAction = document.querySelector("#btnAction");

const nit = document.querySelector("#nit");
const name = document.querySelector("#name");
const phone = document.querySelector("#phone");
const email = document.querySelector("#email");
const address = document.querySelector("#address");

const errorNit = document.querySelector("#errorNit");
const errorName = document.querySelector("#errorName");
const errorPhone = document.querySelector("#errorPhone");
const errorEmail = document.querySelector("#errorEmail");
const errorAddress = document.querySelector("#errorAddress");

document.addEventListener("DOMContentLoaded", function () {
  //Usage of ckeditor
  ClassicEditor.create(document.querySelector("#message"), {
    toolbar: {
      items: [
        "exportPDF",
        "exportWord",
        "|",
        "findAndReplace",
        "selectAll",
        "|",
        "heading",
        "|",
        "bold",
        "italic",
        "strikethrough",
        "underline",
        "code",
        "subscript",
        "superscript",
        "removeFormat",
        "|",
        "bulletedList",
        "numberedList",
        "todoList",
        "|",
        "outdent",
        "indent",
        "|",
        "undo",
        "redo",
        "-",
        "fontSize",
        "fontFamily",
        "fontColor",
        "fontBackgroundColor",
        "highlight",
        "|",
        "alignment",
        "|",
        "link",
        "insertImage",
        "blockQuote",
        "insertTable",
        "mediaEmbed",
        "codeBlock",
        "htmlEmbed",
        "|",
        "specialCharacters",
        "horizontalLine",
        "pageBreak",
        "|",
        "textPartLanguage",
        "|",
        "sourceEditing",
      ],
      shouldNotGroupWhenFull: true,
    },
  }).catch((error) => {
    console.error(error);
  });

  //Update data
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    errorNit.textContent = "";
    errorName.textContent = "";
    errorPhone.textContent = "";
    errorEmail.textContent = "";
    errorAddress.textContent = "";

    if (nit.value == "") {
      errorNit.textContent = "El NIT es obligatorio";
    } else if (name.value == "") {
      errorName.textContent = "El nombre es obligatorio";
    } else if (phone.value == "") {
      errorPhone.textContent = "El teléfono es obligatorio";
    } else if (email.value == "") {
      errorEmail.textContent = "El correo es obligatorio";
    } else if (address.value == "") {
      errorAddress.textContent = "La dirección es obligatoria";
    } else {
      const url = base_url + "admin/edit";
      insertRecords(url, this, null, btnAction, false);
    }
  });
});
