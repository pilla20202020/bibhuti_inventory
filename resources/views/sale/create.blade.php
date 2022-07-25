@extends('layouts.admin.admin')

@section('title', 'Create a Sale')

@section('content')
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('sale.store')}}" method="POST" enctype="multipart/form-data" >
            @include('sale.form',['header' => 'Create a Sale'])
            </form>
        </div>
    </section>
@endsection

