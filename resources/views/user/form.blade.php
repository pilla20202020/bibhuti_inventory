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
                                       value="{{ old('name', isset($user->name) ? $user->name : '') }}"/>
                                <span id="textarea1-error" class="text-danger">{{ $errors->first('name') }}</span>
                                <label for="Name">Name</label>
                            </div> --}}

                            <div class="form-group ">
                                <label for="name" class="col-form-label pt-0">Name</label>
                                <div class="">
                                    <input class="form-control" type="text" required name="name" value="{{ old('name', isset($user->name) ? $user->name : '') }}" placeholder="Enter Your Name">
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
                                    value="{{ old('email', isset($user->email) ? $user->email : '') }}" placeholder="Enter a email">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group ">
                                <label for="specialization" class="col-form-label pt-0">Password </label>
                                <div class="">
                                    <input class="form-control" type="password" name="password" data-role="tagsinput"
                                    value="{{ old('phone1', isset($user->password) ? $user->password : '') }}" placeholder="Enter a Password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group ">
                                <label for="user" class="col-form-label pt-0">Choose a role</label>
                                <div class="">
                                    <select data-placeholder="Select Roles" class="js-example-basic-multiple form-control" name="roles[]" multiple="multiple">
                                        @foreach($roles as $role_data)
                                            @if(isset($userRoles))
                                                @foreach($userRoles as $user_role)
                                                    <option value="{{$role_data->id}}" @if($user_role->id==$role_data->id) selected @endif>{{ucfirst($role_data->name)}}</option>
                                                @endforeach
                                            @else
                                                <option value="{{$role_data->id}}">{{ucfirst($role_data->name)}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" >
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group d-flex">
                            <span class="pl-1">Status</span>
                            <input type="checkbox" id="switch1" switch="none" name="status" {{ old('status', isset($user->status) ? $user->status : '')=='active' ? 'checked':'' }}/>
                            <label for="switch1" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-2 justify-content-center">
                    <div class="form-group">
                        <div>
                            <a class="btn btn-light waves-effect ml-1" href="{{ route('user.index') }}">
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
