@extends('layouts.admin.admin')

@section('title', 'Create a Product')

@section('content')
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('product.store')}}" method="POST" enctype="multipart/form-data" >
            @include('product.form',['header' => 'Create a Product'])
            </form>


            <div class="modal fade" id="addUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group ">
                                        <label for="name" class="col-form-label pt-0">Unit Name</label>
                                        <div class="">
                                            <input class="form-control store_unitname" name="name" type="text" required value="{{ old('name', isset($unit->name) ? $unit->name : '') }}" placeholder="Enter Your Name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn-addunitstore" data-dismiss="modal">Add Unit</button>
                        </div>
                </div>
                </div>
            </div>
        </div>
    </section>
@endsection

