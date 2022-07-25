@extends('layouts.admin.admin')

@section('title', 'Create a Branch')

@section('content')
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('branch.store')}}" method="POST" enctype="multipart/form-data" >
            @include('branch.form',['header' => 'Create a Branch'])
            </form>
        </div>
    </section>
@endsection


