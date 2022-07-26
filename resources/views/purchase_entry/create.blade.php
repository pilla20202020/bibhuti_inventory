@extends('layouts.admin.admin')

@section('title', 'Create a Purchase Entry')

@section('content')
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('purchase_entry.store')}}" method="POST" enctype="multipart/form-data" >
            @include('purchase_entry.form',['header' => 'Create a Purchase Entry'])
            </form>
        </div>
    </section>
@endsection

