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
                        <div class="col-sm-12">
                            {{-- <div class="form-group">
                                <input type="text" name="name" class="form-control" required
                                       value="{{ old('name', isset($branch->name) ? $branch->name : '') }}"/>
                                <span id="textarea1-error" class="text-danger">{{ $errors->first('name') }}</span>
                                <label for="Name">Name</label>
                            </div> --}}

                            <div class="form-group ">
                                <label for="name" class="col-form-label pt-0">Name</label>
                                <div class="">
                                    <input class="form-control" type="text" required name="name" value="{{ old('name', isset($branch->name) ? $branch->name : '') }}" placeholder="Enter Your Name">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group ">
                                <label for="specialization" class="col-form-label pt-0">Email</label>
                                <div class="">
                                    <input class="form-control" type="email" name="email" data-role="tagsinput"
                                    value="{{ old('email', isset($branch->email) ? $branch->email : '') }}" placeholder="Enter a email">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group ">
                                <label for="specialization" class="col-form-label pt-0">Telephone </label>
                                <div class="">
                                    <input class="form-control" type="number" name="telephone" data-role="tagsinput"
                                    value="{{ old('telephone', isset($branch->telephone) ? $branch->telephone : '') }}" placeholder="Enter a Telephone">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="specialization" class="col-form-label pt-0">Phone Number </label>
                                <div class="">
                                    <input class="form-control" type="number" name="phone1" data-role="tagsinput"
                                    value="{{ old('phone1', isset($branch->phone1) ? $branch->phone1 : '') }}" placeholder="Enter a Phone">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="specialization" class="col-form-label pt-0">Alternative Phone Number </label>
                                <div class="">
                                    <input class="form-control" type="number" name="phone2" data-role="tagsinput"
                                    value="{{ old('phone2', isset($branch->phone2) ? $branch->phone2 : '') }}" placeholder="Enter a Alternative Phone Number">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group ">
                                <label for="specialization" class="col-form-label pt-0">Address </label>
                                <div class="">
                                    <input class="form-control" type="text" name="address" data-role="tagsinput"
                                    value="{{ old('address', isset($branch->address) ? $branch->address : '') }}" placeholder="Enter a Address">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group ">
                                <label for="specialization" class="col-form-label pt-0">Company Registration Number </label>
                                <div class="">
                                    <input class="form-control" type="text" name="company_reg" data-role="tagsinput"
                                    value="{{ old('company_reg', isset($branch->company_reg) ? $branch->company_reg : '') }}" placeholder="Enter a Company Registration">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label pt-0">Description</label>
                                <textarea class="form-control" name="description" rows="4" placeholder="Description">{{old('description',isset($branch->description) ? $branch->description : '')}}</textarea>
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
                        @if(isset($branch->image))
                        @if(!empty($branch->image))
                            <input type="file" name="image" class="dropify"
                                data-default-file="{{ asset($branch->image_path) }}"/>
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
                            <span class="pl-1">Is Main</span>
                            <input type="checkbox" id="switch0" switch="none" name="is_main" {{ old('is_main', isset($branch->is_main) ? $branch->is_main : '')=='yes' ? 'checked':'' }}/>
                            <label for="switch0" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                        </div>
                        <div class="form-group d-flex">
                            <span class="pl-1">Status</span>
                            <input type="checkbox" id="switch1" switch="none" name="status" {{ old('status', isset($branch->status) ? $branch->status : '')=='active' ? 'checked':'' }}/>
                            <label for="switch1" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-2 justify-content-center">
                    <div class="form-group">
                        <div>
                            <a class="btn btn-light waves-effect ml-1" href="{{ route('branch.index') }}">
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
    </script>
@endsection
