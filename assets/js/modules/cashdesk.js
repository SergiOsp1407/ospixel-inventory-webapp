const initial_value = document.querySelector("#initial_value");
const btnOpenCashdesh = document.querySelector("#btnOpenCashdesh");

document.addEventListener("DOMContentLoaded", function () {
  btnOpenCashdesh.addEventListener("click", function () {
    if (initial_value.value == "") {
      customAlert("warning", "El valor es requerido!");
    } else {
        const url = base_url + 'cashdesk/openCashdesk';        
        //Create an instance of XMLHttpRequest
        const http = new XMLHttpRequest();
        //Open connection - POST - GET
        http.open("POST", url, true);
        //Sen data
        http.send(JSON.stringify({
            amount : initial_value.value
        }));
        //Check status
        http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
        //   const response = JSON.parse(this.responseText);
        console.log(this.responseText);
        }
      };


    }
  });
});
