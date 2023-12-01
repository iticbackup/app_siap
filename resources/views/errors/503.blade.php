@extends('errors::minimal')

{{-- @section('title', __('Service Unavailable')) --}}
@section('title', __('Website sedang maintenance'))
@section('code', '503')
@section('message', __('Website sedang maintenance'))
{{-- @section('message', __('Service Unavailable')) --}}
