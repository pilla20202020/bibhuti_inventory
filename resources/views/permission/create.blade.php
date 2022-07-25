@extends('layouts.admin.admin')

@section('title', 'Create a Permission')

@section('content')
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('permission.store')}}" method="POST" enctype="multipart/form-data" >
            @include('permission.form',['header' => 'Create a permission'])
            </form>
        </div>
    </section>
@endsection

