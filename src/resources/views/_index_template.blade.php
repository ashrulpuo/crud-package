<?=
"
@extends('layouts.backend')

@section('styles')
<link href=\"{{ asset('plugins/custom/datatables/datatables.bundle.css?v=7.0.5') }}\" rel=\"stylesheet\" type=\"text/css\" />
@endsection

@section('content')
{{-- <x-alert :type=\"$type\" :message=\"$message\" :icon=\"$icon\" /> --}}
<div class=\"d-flex flex-column-fluid\">
    <!--begin::Container-->
    <div class=\"container\">
        @include('components.alert')
        <!--begin::Card-->
        <div class=\"card card-custom\">
            <div class=\"card-header\">
                <div class=\"card-title\">
                    <span class=\"card-icon\">
                        <i class=\"flaticon2-supermarket text-primary\"></i>
                    </span>
                    <h3 class=\"card-label\">Tetapan ". substr($table, 3) ."</h3>
                </div>
                <div class=\"card-toolbar\">
                    <!--begin::Button-->
                    <button class=\"btn btn-primary font-weight-bolder create\">
                        <span class=\"svg-icon svg-icon-md\">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                            <svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\"
                                width=\"24px\" height=\"24px\" viewBox=\"0 0 24 24\" version=\"1.1\">
                                <g stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\">
                                    <rect x=\"0\" y=\"0\" width=\"24\" height=\"24\" />
                                    <circle fill=\"#000000\" cx=\"9\" cy=\"15\" r=\"6\" />
                                    <path
                                        d=\"M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z\"
                                        fill=\"#000000\" opacity=\"0.3\" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>Tambah</button>
                    <!--end::Button-->
                </div>
            </div>
            <div class=\"card-body\">
                <!--begin: Datatable-->
                <table class=\"table datatable-loaded\" id=\"kt_datatable\" data-route=\"{{ route('". strtolower(substr($table, 3)) .".index') }}\">
                    <thead class=\"thead-light\">
                        <tr>
                            <th>#</th>
"?>
<?php
    foreach ($set as $i => $column) {
        if ($column != $table.'Id') {
            if ($column != 'Papar') {
                echo "\t\t\t\t\t\t\t<th>".$column."</th>\r\n";
            }
        }
    } 
?>
<?="                        <th>Action</th>
                        </tr>
                    </thead>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>

<x-modal title=\"Custom Title\" id=\"modal\">
    @include('tetapan.".strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $table))."._form_".strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $table))."')
</x-modal>
@endsection

@section('scripts')
<script src=\"{{ asset('plugins/custom/datatables/datatables.bundle.js?v=7.0.8')}}\"></script>
<script type=\"text/javascript\" src=\"{{ asset('/js/app.js') }}\"></script>
<script src=\"{{ asset('spr/js/tetapan/". strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', substr($table, 3))) .".js') }}\"></script>
@endsection                           
"
?>