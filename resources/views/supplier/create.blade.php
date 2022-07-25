@extends('layouts.admin.admin')

@section('title', 'Create a Supplier')

@section('content')
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('supplier.store')}}" method="POST" enctype="multipart/form-data" >
            @include('supplier.form',['header' => 'Create a Supplier'])
            </form>
        </div>
    </section>
@endsection

