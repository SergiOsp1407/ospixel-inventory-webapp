const dom = "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
"<'row'<'col-sm-12'tr>>" +
"<'row'<'col-sm-5'i><'col-sm-7'p>>";
const buttons = [{
                //Excel button
                extend: 'excelHtml5',
                footer: true, 
                //Here we create the custom button
                text: '<span class="badge bg-success"><i class="fas fa-file-excel"></i></span>'
            },
            //PDF button
            {
                extend: 'pdfHtml5',
                download: 'open',
                footer: true,
                text: '<span class="badge bg-danger"><i class="fas fa-file-pdf"></i></span>',
                exportOptions: {
                    columns: [0, ':visible']
                }
            },
            //Copy button
            {
                extend: 'copyHtml5',
                footer: true,
                text: '<span class="badge bg-primary"><i class="fas fa-copy"></i></span>',
                exportOptions: {
                    columns: [0, ':visible']
                }
            },
            //Print button
            {
                extend: 'print',
                footer: true,
                text: '<span class="badge bg-dark"><i class="fas fa-print"></i></span>'
            },
            //CVS button
            {
                extend: 'csvHtml5',
                footer: true,
                text: '<span class="badge bg-success"><i class="fas fa-file-csv"></i></span>'
            },
            {
                extend: 'colvis',
                text: '<span class="badge bg-info"><i class="fas fa-columns"></i></span>',
                postfixButtons: ['colvisRestore']
            }
        ]