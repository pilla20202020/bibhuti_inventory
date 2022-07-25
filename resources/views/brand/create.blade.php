@extends('layouts.admin.admin')

@section('title', 'Create a Brand')

@section('content')
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('brand.store')}}" method="POST" enctype="multipart/form-data" >
            @include('brand.form',['header' => 'Create a Brand'])
            </form>
        </div>
    </section>
@endsection

