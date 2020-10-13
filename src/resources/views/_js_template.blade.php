<?=
"
$(function() {

var statusCode;

var table = $('#kt_datatable')

var ". strtolower(substr($table, 3)) ."DT = table.DataTable({
    responsive: true,
    searchDelay: 500,
    processing: true,
    serverSide: true,
    scrollCollapse: true,
    pagingType: 'full_numbers',
    ordering: false,
    responsive: true,
    ajax: {
        url: table.data('route'),
        method: 'GET',
        dataType: 'json',
        dataSrc: \"data\",
    },
    columns: [
"?>
<?php
    foreach ($set as $i => $column) { 
        if($column == $table.'Id'){
            echo "\t\t{
            data: '" . $column . "',
            render: function(data, type, full, meta) {
                return meta.row + 1;
            }
        },";
        } else {
            if ($column != "DaftarPada") {
                echo "\n\t\t{ data: '" . $column . "' },";
            } else {
                echo "\n\t\t{
            data: '" . $column . "',
            render: function(row) {
                return moment(row).format('DD/MM/YYYY');
            },
        },";
            }
        }
    } 
?>
<?php
foreach ($set as $i => $column) { 
    if($column == $table.'Id'){
        echo "\n\t\t{ data: '" . $column . "', responsivePriority: -1 },";
    }
} 
?>
<?="
    ],
    columnDefs: [{
        width: '75px',
        targets: -1,
"?>
<?php
foreach ($set as $i => $column) { 
    if($column == $table.'Id'){
        echo "\t\tdata: '" . $column . "',";
    }
}
?>
<?="
        title: 'Actions',
        orderable: false,
        render: function(data, type, full, meta) {
            return '\
                <a href=\"javascript:;\" id=\"' + data + '\" class=\"btn btn-sm btn-clean btn-icon edit\" title=\"Edit details\">\
                    <i class=\"la la-edit\"></i>\
                </a>\
                <a href=\"javascript:;\" id=\"' + data + '\" class=\"btn btn-sm btn-clean btn-icon delete\" title=\"Delete\">\
                    <i class=\"la la-trash\"></i>\
                </a>\
            ';
        },
    }, ],
});

$('body').on('click', '.create', function() {
    $('#tetapan" .substr($table, 3). "')[0].reset();
    $('#modelHeading').html(\"Tetapan ".preg_replace('/([a-z])([A-Z])/s','$1 $2', substr($table, 3))."\" );

    $('.modal').modal();
});

//submit 
$('#simpan').click(function(e) {
    // e.preventDefault();

    let method;
    let url;

    var id = $(\"#". $table."Id" ."\").val();
    if (id === '') {
        url = table.data('route');
        method = \"POST\";
    } else {
        url = table.data('route') + '/' + id;
        method = \"PUT\";
    }

    $.ajax({
        data: $('#tetapan".substr($table, 3)."').serialize(),
        url: url,
        type: method,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
        },
        success: ((data) => {
            statusCode = 1;
            window.err.success(data, statusCode);
            ". strtolower(substr($table, 3)) ."DT.draw();
        }),
        error: function(data) {
            window.err.error(data)
        }
    });
});

//edit
$('body').on('click', '.edit', function() {
    var ". strtolower(substr($table, 3)).'Id' ." = $(this).attr('id');
    var route = table.data('route') + '/' + ". strtolower(substr($table, 3)).'Id' ." + '/edit';
    console.log(route)

    $.get(route, function(data) {
"?>
<?php
foreach ($set as $i => $column) { 
    echo "\t\t$('#". $column ."').val(data.data.". $column .");"."\r\n";
    if($column == 'Papar'){
        echo "\t\t$(\"#Papar\").prop(\"checked\", (data.data.Papar === 1) ? true : false);"."\r\n";
    }
}   
?>
<?="    
        $('#modelHeading').html(\"Kemaskini\");
        $('#simpan').html(\"Kemaskini\" );
        $('.modal').modal();
    })
});

//delete
$('body').on('click', '.delete', function() {
    var ". strtolower(substr($table, 3)).'Id' ." = $(this).attr('id');
    var url = table.data('route') + '/' + ". strtolower(substr($table, 3)).'Id' .";

    if (confirm(\"Anda pasti untuk padam ?\")) {
        $.ajax({
            type: \"DELETE\",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
            },
            success: function(data) {
                statusCode = 2;
                window.err.success(data, statusCode)
                ". strtolower(substr($table, 3)) ."DT.draw();
            },
            error: function(data) {
                $('#alert').removeClass('alert-success').addClass('alert-danger');
                $('#icon').removeClass('flaticon2-check-mark').addClass('flaticon2-delete');
                $(\"#text\").html(data.message);
                $(\".alert\").delay(3000).fadeOut();
                ". strtolower(substr($table, 3)) ."DT.draw();
            }
        });
    }
});
});
"
?>