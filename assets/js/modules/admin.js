const form = document.querySelector("#form");
const btnAction = document.querySelector("#btnAction");

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
    const url = base_url + "admin/edit";
    //Create formData
    const data = new FormData(this);
    //Create an instance of XMLHttpRequest
    const http = new XMLHttpRequest();
    //Open connection - POST - GET
    http.open("POST", url, true);
    //Sen data
    http.send(data);
    //Check status
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        // const response = JSON.parse(this.responseText);
        // Swal.fire({
        //   toast: true,
        //   position: "top-right",
        //   icon: response.type,
        //   title: response.msg,
        //   showConfirmButton: false,
        //   timer: 2000,
        // });
      }
    };
  });
});
