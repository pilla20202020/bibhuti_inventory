@extends('layouts.admin.admin')

@section('title', 'Create a Purchase Order')

@section('content')
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('purchaseorder.store')}}" method="POST" enctype="multipart/form-data" >
            @include('purchase_order.form',['header' => 'Create a Purchase Order'])
            </form>
        </div>
    </section>
@endsection

