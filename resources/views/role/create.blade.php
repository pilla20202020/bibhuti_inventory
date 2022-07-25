@extends('layouts.admin.admin')

@section('title', 'Create a role')

@section('content')
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('role.store')}}" method="POST" enctype="multipart/form-data" >
            @include('role.form',['header' => 'Create a role'])
            </form>
        </div>
    </section>
@endsection

