@extends('layouts.admin.admin')

@section('title', 'Create a Category')

@section('content')
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('category.store')}}" method="POST" enctype="multipart/form-data" >
            @include('category.form',['header' => 'Create a Category'])
            </form>
        </div>
    </section>
@endsection

