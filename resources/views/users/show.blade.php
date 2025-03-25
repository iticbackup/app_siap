@extends('layouts.apps.master')
@section('title')
    Detail - {{ $user->name }}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Detail User - {{ $user->name }}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title">Detail User - {{ $user->name }}</h5>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label for="example-text-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Name :
                </label>
                <div class="col-sm-10">
                    {{ $user->name }}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="example-text-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Email :
                </label>
                <div class="col-sm-10">
                    {!! !empty($user->email) ? $user->email : '-' !!}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="example-text-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Roles :
                </label>
                <div class="col-sm-10">
                    {{-- @dd($user->getRoleNames()) --}}
                    @if (!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $v)
                            @if ($v == 'Admin')
                            <label class="badge bg-primary">{{ $v }}</label>
                            @else
                            <label class="badge bg-info">{{ $v }}</label>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
        </div>
    </div>


    {{-- <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $user->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {{ $user->email }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Roles:</strong>
                @if (!empty($user->getRoleNames()))
                    @foreach ($user->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                @endif
            </div>
        </div>
    </div> --}}
@endsection
