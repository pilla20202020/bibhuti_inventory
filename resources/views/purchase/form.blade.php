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
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="available_stock" class="col-form-label pt-0">Quantity</label>
                                <div class="">
                                    <input class="form-control" type="number" required name="available_stock" value="{{ old('available_stock', isset($purchase->available_stock) ? $purchase->available_stock : '') }}" placeholder="Enter Quantity">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="category_id" class="col-form-label pt-0">Category</label>
                                <div class="">
                                    <select data-placeholder="Select Supplier" class="tail-select w-full form-control category_id" name="category_id">
                                        @foreach($category as $category_data)
                                            <option value="{{$category_data->id}}"  @if(isset($category_search)) @if($category_search->id==$category_data->id) selected @endif @endif>{{ucfirst($category_data->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="product_id" class="col-form-label pt-0">Product</label>
                                <div class="">
                                    <select data-placeholder="Select Supplier" class="tail-select w-full form-control purchase_class product_class" name="product_id">
                                        @if(isset($category_search))
                                            @foreach($product as $product_data)
                                                <option value="{{$product_data->id}}"  @if(isset($category_search)) @if($category_search->id==$product_data->id) selected @endif @endif>{{ucfirst($product_data->name)}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="buying_price" class="col-form-label pt-0">Buying Price</label>
                                <div class="">
                                    <input class="form-control" type="number" required name="buying_price" value="{{ old('buying_price', isset($purchase->buying_price) ? $purchase->buying_price : '') }}" placeholder="Enter Buying Price">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="buying_date" class="col-form-label pt-0">Buying Date</label>
                                <div class="">
                                    <input class="form-control" type="date" required name="buying_date" value="{{ old('buying_date', isset($purchase->buying_date) ? $purchase->buying_date : '') }}" placeholder="Enter Buying Price">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label pt-0">Description</label>
                                <textarea class="form-control" name="description" rows="4" placeholder="Description">{{old('description',isset($purchase->description) ? $purchase->description : '')}}</textarea>
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
                        @if(isset($purchase->image))
                        @if(!empty($purchase->image))
                            <input type="file" name="image" class="dropify"
                                data-default-file="{{ asset($purchase->image_path) }}"/>
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
                            <input type="checkbox" id="switch1" switch="none" name="status" {{ old('status', isset($purchase->status) ? $purchase->status : '')=='active' ? 'checked':'' }}/>
                            <label for="switch1" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                        </div>
                        <div class="form-group d-flex" >
                            <span class="pl-1">Availability</span>
                            <input type="checkbox" id="switch2" switch="none" name="availability" {{ old('availability', isset($purchase->availability) ? $purchase->availability : '')=='available' ? 'checked':'' }}/>
                            <label for="switch2" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                        </div>
                        <div class="form-group d-flex">
                            <span class="pl-1" >Featured</span>
                            <input type="checkbox" id="switch3" switch="none" name="visibility" {{ old('visibility', isset($purchase->visibility) ? $purchase->visibility : '')=='visible' ? 'checked':'' }}/>
                            <label for="switch3" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-2 justify-content-center">
                    <div class="form-group">
                        <div>
                            <a class="btn btn-light waves-effect ml-1" href="{{ route('purchase.index') }}">
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

        $('.category_id').change(function(e){
            e.preventDefault();
            var category_id = $(this).val();
            var body;
            $.ajax({
                url: "{{route('product.categoryproductajax')}}",
                type: "post",
                data: {
                    _token: $("meta[name='csrf-token']").attr('content'),
                    category_id: category_id,
                },
                success:function(response){
                    if(typeof(response) != "object"){
                        response = JSON.parse(response);
                    }
                    
                    if(response.data){
                        $.each(response.data, function(key, product){
                            body += "<option value='"+product.id+"'>"+product.name+"</option>";
                        });
                        $('.product_class').html(body);
                    }
                }
            })

        })
    </script>
@endsection
