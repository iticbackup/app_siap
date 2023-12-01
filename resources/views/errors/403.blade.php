{{-- @extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden')) --}}

@extends('layouts.apps.master')
@section('title', __('Forbidden'))
@section('content')
<div class="alert alert-light mb-0" role="alert">
    <h4 class="alert-heading font-18">403 {{ __('Forbidden') }}</h4>
    {{ __($exception->getMessage() ?: 'Forbidden') }}
</div>
@endsection