@section('page-specific-styles')
    <link href="{{ asset('css/dropify.min.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet"
          href="{{ asset('resources/css/theme-default/libs/bootstrap-tagsinput/bootstrap-tagsinput.css?1424887862')}}"/>
@endsection
@csrf
<div class="row">
    <div class="col-sm-9">
        <div class="card">
            <div class="card-underline">
                <div class="card-head">
                    <header class="ml-3 mt-2">{!! $header !!}</header>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="name" class="col-form-label pt-0">Product Title</label>
                                <div class="">
                                    <input class="form-control" type="text" required name="name" value="{{ old('name', isset($product->name) ? $product->name : '') }}" placeholder="Enter Your Name">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="productcode" class="col-form-label pt-0">Product Code</label>
                                <div class="">
                                    <input class="form-control" type="text" required name="productcode" value="{{ old('productcode', isset($product->productcode) ? $product->productcode : '') }}" placeholder="Enter Product Code">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="supplier_id" class="col-form-label pt-0">Supplier</label>
                                <div class="">
                                    <select data-placeholder="Select Supplier" class="tail-select w-full form-control" name="supplier_id">
                                        @foreach($supplier as $supplier_data)
                                            <option value="{{$supplier_data->id}}"  @if(isset($supplier_search)) @if($supplier_search->id==$supplier_data->id) selected @endif @endif>{{ucfirst($supplier_data->name)}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group ">
                                <label for="unit_id" class="col-form-label pt-0">Unit</label>
                                <div class="">
                                    <select data-placeholder="Select Supplier" class="tail-select w-full form-control unit_class" name="unit_id">
                                        @foreach($unit as $unit_data)
                                            <option value="{{$unit_data->id}}"  @if(isset($unit_search)) @if($unit_search->id==$unit_data->id) selected @endif @endif>{{ucfirst($unit_data->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 p-0">
                            <div class="form-group ">
                                <label for="unit_id" class="col-form-label pt-4"></label>
                                <div class="">
                                    <a href="javascript:;" class="btn-addunit">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group ">
                                <label for="brand" class="col-form-label pt-0">Choose a Category</label>
                                <div class="">
                                    <select data-placeholder="Select Package" class="tail-select w-full form-control" name="category_id">
                                        @foreach($category as $category_data)
                                            <option value="{{$category_data->id}}" @if(isset($category_search)) @if($category_search->id==$category_data->id) selected @endif @endif>{{ucfirst($category_data->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group ">
                                <label for="branch_id" class="col-form-label pt-0">Choose a Branch Location</label>
                                <div class="">
                                    <select data-placeholder="Select Branch" class="tail-select w-full form-control" name="branch_id">
                                        @foreach($branch as $branch_data)
                                            <option value="{{$branch_data->id}}" @if(isset($branch_search)) @if($branch_search->id==$branch_data->id) selected @endif @endif>{{ucfirst($branch_data->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group ">
                                <label for="price" class="col-form-label pt-0">Product Price</label>
                                <div class="">
                                    <input class="form-control" type="text" required name="price" value="{{ old('price', isset($product->price) ? $product->price : '') }}" placeholder="Enter Product Price">
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label pt-0">Description</label>
                                <textarea class="form-control" name="description" rows="4" placeholder="Description">{{old('description',isset($product->description) ? $product->description : '')}}</textarea>
                                <span id="textarea1-error" class="text-danger">{{ $errors->first('description') }}</span>
                            </div>
                        </div>
                    </div>






                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-1">
                    <div class="card-body">
                        <h5 class="card-title">Upload Images</h5>
                        <p class="card-title-desc">You can add a default value</p>
                        @if(isset($product->image))
                        @if(!empty($product->image))
                            <input type="file" name="image" class="dropify"
                                data-default-file="{{ asset($product->image_path) }}"/>
                        @else
                            <input type="file" name="image" class="dropify"/>
                        @endif
                        @else
                            <input type="file" name="image" class="dropify"/>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card" >
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group d-flex">
                            <span class="pl-1">Status</span>
                            <input type="checkbox" id="switch1" switch="none" name="status" {{ old('status', isset($product->status) ? $product->status : '')=='active' ? 'checked':'' }}/>
                            <label for="switch1" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-2 justify-content-center">
                    <div class="form-group">
                        <div>
                            <a class="btn btn-light waves-effect ml-1" href="{{ route('product.index') }}">
                                <i class="md md-arrow-back"></i>
                                Back
                            </a>
                            <input type="submit" name="pageSubmit" class="btn btn-danger waves-effect waves-light" value="Submit">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



@section('page-specific-scripts')
    <script src="{{asset('resources/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/dropify.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.dropify').dropify();
        });


        $('.btn-addunit').click(function(e){
            e.preventDefault();
            $('#addUnit').modal('show');
        });

        $('.btn-addunitstore').click(function(e){
            e.preventDefault();
            var unit_name = $('.store_unitname').val();
            $.ajax({

                url: "{{route('unit.unitStore')}}",
                type: "post",
                data: {
                    _token: $("meta[name='csrf-token']").attr('content'),
                    name: unit_name,
                },
                success:function(response){
                    if(typeof(response) != "object"){
                        response = JSON.parse(response);
                    }
                    var body = "";
                    if(response.data){
                        $.each(response.data.data, function(key, names){
                            body += "<option value='"+names.id+"'>"+names.name+"</option>";
                        });
                        $('.unit_class').html(body);
                    }
                }
            })

        })
    </script>
@endsection
