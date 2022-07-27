@extends('layouts.admin.admin')

@section('page-specific-styles')
    <link href="{{ asset('css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
@endsection

@section('title',$purchase_entry->name)

@section('content')
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('purchase_entry.update',$purchase_entry->id)}}"
                  method="POST" enctype="multipart/form-data" >
            @method('PUT')
            @include('purchase_entry.editform', ['header' => 'Edit Purchase <span class="text-primary">('.($purchase_entry->id).')</span>'])
            </form>
        </div>
    </section>

@endsection


@section('page-specific-scripts')
    <script src="{{ asset('js/dropify.min.js') }}"></script>
    <script src="{{ asset('resources/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.dropify').dropify();
        });
    </script>
@endsection

