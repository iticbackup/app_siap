@extends('layouts.apps.master')
@section('title')
    Profile
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @yield('title')
        @endslot
        @slot('title')
            @yield('title')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="dastone-profile">
                        <div class="row">
                            <div class="col-lg-4 align-self-center mb-3 mb-lg-0">
                                <div class="dastone-profile-main">
                                    <div class="dastone-profile-main-pic">
                                        <img src="{{ (isset(Auth::user()->avatar) && Auth::user()->avatar != '') ? asset(Auth::user()->avatar) : asset('public/assets/images/users/user-1.jpg') }}" alt="" height="110" class="rounded-circle">
                                        <span class="dastone-profile_main-pic-change" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </span>
                                    </div>
                                    <div class="dastone-profile_user-detail">
                                        <h5 class="dastone-user-name">{{ Auth::user()->name }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 ms-auto align-self-center">
                                <ul class="list-unstyled personal-detail mb-0">
                                    <li class="mt-2"><i class="ti ti-email text-secondary font-16 align-middle me-2"></i> <b> Email </b> : {{ auth()->user()->email != null ? auth()->user()->email : '-' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-4">
        <ul class="nav-border nav nav-pills mb-0" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="settings_detail_tab" data-bs-toggle="pill" href="#Profile_Settings">Settings</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="Profile_Settings" role="tabpanel" aria-labelledby="settings_detail_tab">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <form id="personal_update" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h4 class="card-title">Personal Information</h4>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <!--end card-header-->
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center">Username</label>
                                            <div class="col-lg-9 col-xl-8">
                                                <input class="form-control" type="text" value="{{ auth()->user()->username }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center">Name</label>
                                            <div class="col-lg-9 col-xl-8">
                                                <input class="form-control" type="text" name="name" value="{{ auth()->user()->name }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center">Email Address</label>
                                            <div class="col-lg-9 col-xl-8">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="las la-at"></i></span>
                                                    <input type="text" class="form-control" value="{{ auth()->user()->email != null ? auth()->user()->email : null }}" placeholder="Email" aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-9 col-xl-8 offset-lg-3">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">Submit</button>
                                                <button type="button" class="btn btn-sm btn-outline-danger">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--end col-->
                        <div class="col-lg-6 col-xl-6">
                            <form id="update_password" method="post">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Change Password</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center">New Password</label>
                                            <div class="col-lg-9 col-xl-8">
                                                <input class="form-control" type="password" name="password" placeholder="New Password" required autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center">Confirm Password</label>
                                            <div class="col-lg-9 col-xl-8">
                                                <input class="form-control" type="password" name="password_confirmation" placeholder="Re-Password" required autocomplete="new-password">
                                                <span class="form-text text-muted font-12">Never share your password.</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-9 col-xl-8 offset-lg-3">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">Change Password</button>
                                                <button type="button" class="btn btn-sm btn-outline-danger">Cancel</button>
                                            </div>
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
@endsection
@section('script')
<script src="{{ URL::asset('public/assets/js/iziToast.min.js') }}"></script>
<script>
    $('#personal_update').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $('#image-input-error').text('');
        $.ajax({
            type:'POST',
            url: "{{ route('profile.personal_info') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: (result) => {
                if(result.success != false){
                    iziToast.success({
                        title: result.message_title,
                        message: result.message_content
                    });
                }else{
                    iziToast.error({
                        title: result.success,
                        message: result.error
                    });
                }
            },
            error: function (request, status, error) {
                iziToast.error({
                    title: 'Error',
                    message: error,
                });
            }
        });
    });
    $('#update_password').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $('#image-input-error').text('');
        $.ajax({
            type:'POST',
            url: "{{ route('profile.password_personal_update') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: (result) => {
                if(result.success == true){
                    iziToast.success({
                        title: result.message_title,
                        message: result.message_content
                    });
                }else{
                    iziToast.error({
                        title: result.success,
                        message: result.error
                    });
                }
            },
            error: function (request, status, error) {
                iziToast.error({
                    title: 'Error',
                    message: error,
                });
            }
        });
    });
</script>
@endsection