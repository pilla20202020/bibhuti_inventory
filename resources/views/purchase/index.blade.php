@extends('layouts.admin.admin')

@section('page-specific-styles')
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/TableTools.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/lightbox.css') }}"/>
@endsection

@section('title', 'Purchase')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex">
                <header class="text-capitalize pt-1">Purchase</header>
                <div class="tools ml-auto">
                    <a class="btn btn-primary ink-reaction" href="{{ route('purchase.create') }}">
                        <i class="md md-add"></i>
                        Add
                    </a>
                </div>
            </div>
            <div class="card mt-2 p-4">
                <table id="datatable" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>S.No.</th>
                        <th>Supplier Name</th>
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Visibility</th>
                        <th>Availability</th>
                        <th>Status</th>
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
                "ajax": '{{ route('purchase.data') }}',
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print',
                //     // exportOptions: {
                //     //     columns: 'th:not(:last-child)'
                //     // }
                // ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Export Search Results',
                        className: 'btn btn-default',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    }
                ],
                "columns": [
                    { "data": "id",  'visible': false },
                    { "data": "DT_RowIndex",  orderable: false, searchable: false },
                    { "data": "supplier" },
                    { "data": "category" },
                    { "data": "product" },
                    { "data": "available_stock" },
                    { "data": "visibility" },
                    { "data": "availability" },
                    { "data": "status" },
                    { "data": "actions", orderable: false, searchable: false },
                ],
                order: [ [0, 'desc'] ]
            });
        } );
    </script>
@endsection


