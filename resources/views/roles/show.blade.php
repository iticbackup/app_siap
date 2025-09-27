@extends('layouts.apps.master')
@section('title')
    Detail Roles
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label align-self-center mb-lg-0">Role Name</label>
                        <div class="col-sm-10">
                            : {{ $role->name }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label align-self-center mb-lg-0">Permission</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @foreach ($custom_permission as $key => $group)
                                    <div class="mb-2 mt-2" style="font-weight: bold">* {{ ucfirst($key) }}</div>
                                    @forelse($group as $permission)
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <input
                                                    {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}
                                                    class="rounded-md border" type="checkbox"
                                                    value="{{ $permission->name }}" disabled>
                                                {{ $permission->name }}
                                            </div>
                                        </div>
                                    @empty
                                        {{ __('No permission in this group !') }}
                                    @endforelse
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
                    <a href="{{ route('roles.edit',$role->id) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
        </div>
    </div>
{{-- <div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2> Detail Role</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $role->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permissions:</strong>
            @if(!empty($rolePermissions))
                @foreach($rolePermissions as $v)
                    <label class="label label-success">{{ $v->name }},</label>
                @endforeach
            @endif
        </div>
    </div>
</div> --}}
@endsection