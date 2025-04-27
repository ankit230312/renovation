$(function () {
    $('.js-basic-example').DataTable();

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
                responsive: true,
                lengthMenu: [
                    [ 10, 25, 50,100],
                    [ '10', '25', '50', '100' ]
                ],
                buttons: [
                    'csv','excel','pageLength',
                ],
                "order": [[ 0, "desc" ]],
    });
});