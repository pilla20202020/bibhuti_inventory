@extends('layouts.admin.admin')

@section('title', 'Create a Unit')

@section('content')
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('unit.store')}}" method="POST" enctype="multipart/form-data" >
            @include('unit.form',['header' => 'Create a Unit'])
            </form>
        </div>
    </section>
@endsection

