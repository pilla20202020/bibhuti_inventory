@extends('layouts.admin.admin')

@section('title', 'Create a Price')

@section('content')
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('price.store')}}" method="POST" enctype="multipart/form-data" >
            @include('price.form',['header' => 'Create a Price'])
            </form>
        </div>
    </section>
@endsection

