let tblUsers;
const form = document.querySelector('#form');
const names = document.querySelector('#names');
const lastname = document.querySelector('#lastname');
const email = document.querySelector('#email');
const phone = document.querySelector('#phone');
const address = document.querySelector('#address');
const password = document.querySelector('#password');
const rol = document.querySelector('#rol');

//Elements to show errors
const errorNames = document.querySelector('#errorNames');
const errorLastname = document.querySelector('#errorLastname');
const errorEmail = document.querySelector('#errorEmail');
const errorPhone = document.querySelector('#errorPhone');
const errorAddress = document.querySelector('#errorAddress');
const errorPassword = document.querySelector('#errorPassword');
const errorRol = document.querySelector('#errorRol');

document.addEventListener("DOMContentLoaded", function () {

    //Load data with datatables plugin
    $('#tblUsers').DataTable( {
        ajax: {
            url: base_url + 'users/list',
            dataSrc: ''
        },
        columns: [
            { data: 'completeName' },
            { data: 'email' },
            { data: 'phone' },
            { data: 'address' },
            { data: 'rol' },
            { data: 'actions' }
        ],
        language : {
            url : base_url + 'assets/js/spanish.json'
        },
        dom,
        buttons
    } );

    form.addEventListener('submit', function(e) {

        e.preventDefault();
        if (names.value == '') {
            errorNames.textContent = 'El nombre es requerido';
            
        }
        
    })



})