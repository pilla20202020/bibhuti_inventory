@extends('layouts.admin.admin')

@section('title', 'Create a Purchase')

@section('content')
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('purchase.store')}}" method="POST" enctype="multipart/form-data" >
            @include('purchase.form',['header' => 'Create a Purchase'])
            </form>
        </div>
    </section>
@endsection

