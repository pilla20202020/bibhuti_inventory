@extends('layouts.admin.admin')

@section('page-specific-styles')
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/TableTools.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/lightbox.css') }}"/>
@endsection

@section('title', 'Purchase Entry List')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex">
                <header class="text-capitalize pt-1">Purchase Entry List</header>
                <div class="tools ml-auto">
                    <a class="btn btn-primary ink-reaction" href="{{ route('purchase_entry.create') }}">
                        <i class="fas fa-plus"></i>
                        Add Purchase Entry
                    </a>
                </div>
            </div>
            <div class="card mt-2 p-4">
                <table id="datatable" class="table border-0 table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>S.No.</th>
                        <th>Product Name</th>
                        <th>Supplier Name</th>
                        <th>Category</th>
                        <th>Available no.</th>
                        <th>Defective no.</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('page-specific-scripts')
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/lightbox.js') }}"></script>
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('purchase_entry.data') }}',
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print',
                //     // exportOptions: {
                //     //     columns: 'th:not(:last-child)'
                //     // }

                // ],
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                buttons: [
                    'pageLength',
                    // 'print',
                    // 'excelHtml5',
                    // 'pdfHtml5',
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    'colvis',

                ],
                "columns": [
                    { "data": "id",  'visible': false },
                    { "data": "DT_RowIndex",  orderable: false, searchable: false },
                    { "data": "product_name" },
                    { "data": "supplier_name" },
                    { "data": "category_name" },
                    { "data": "available_stock" },
                    { "data": "defective_stock" },
                    { "data": "actions", orderable: false, searchable: false },
                ],
                order: [ [0, 'desc'] ]
            });
        } );
    </script>
@endsection


