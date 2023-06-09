let tblUsers;


document.addEventListener("DOMContentLoaded", function () {

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



})