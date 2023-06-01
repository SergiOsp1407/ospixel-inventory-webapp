const form = document.querySelector('#form');
const email = document.querySelector('#emailAddress');
const password = document.querySelector('#password');

const errorEmail = document.querySelector('#errorEmail');
const errorPassword = document.querySelector('#errorPassword');


document.addEventListener('DOMContentLoaded', function() {
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        errorEmail.textContent = '';
        errorPassword.textContent = '';
        if (email.value == '') {
            errorEmail.textContent = 'El correo es necesario';            
        } else if (password.value == '') {
            errorPassword.textContent = 'La contraseña es necesaria';                    
        }else{
            const url = base_url + 'home/validate';
            //Create formData
            const data = new FormData(this);
            //Create an instance of XMLHttpRequest
            const http = new XMLHttpRequest();
            //Open connection - POST - GET
            http.open('POST', url, true);
            //Sen data
            http.send(data);
            //Check status
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    
                }                
            }                        
        }        
    });    
})

