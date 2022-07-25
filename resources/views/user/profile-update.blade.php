@extends('layouts.admin.admin')

@section('page-specific-styles')
    <link href="{{ asset('css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
@endsection

@section('title','Update Profile')

@section('content')
    <section>
        <div class="section-body justify-content-center">
            <div class="row">
                <div class="col-sm-6 col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-underline">
                            <div class="card-body">
                                <form class="form form-validate floating-label" action="{{route('user.updateProfile',Auth()->user()->id)}}"
                                    method="POST" enctype="multipart/form-data" >
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group ">
                                                <label for="specialization" class="col-form-label pt-0">Email</label>
                                                <div class="">
                                                    <input class="form-control" type="email" name="email" data-role="tagsinput"
                                                    value="{{ old('email', isset(Auth()->user()->email) ? Auth()->user()->email : '') }}" required placeholder="Change email">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group ">
                                                <label for="specialization" class="col-form-label pt-0">New Password </label>
                                                <div class="">
                                                    <input class="form-control" type="password" name="password" data-role="tagsinput"
                                                    value="{{ old('password') }}" required placeholder="Enter a Password">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2 justify-content-center">
                                        <div class="form-group">
                                            <div>
                                                <a class="btn btn-light waves-effect ml-1" href="{{ route('dashboard') }}">
                                                    <i class="md md-arrow-back"></i>
                                                    Back
                                                </a>
                                                <input type="submit" name="pageSubmit" class="btn btn-danger waves-effect waves-light" value="Submit">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('page-specific-scripts')
    <script src="{{ asset('js/dropify.min.js') }}"></script>
    <script src="{{ asset('resources/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.dropify').dropify();
        });
    </script>
@endsection

