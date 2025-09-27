@extends('layouts.apps.master')
@section('title')
    Manage Roles
@endsection
@section('css')
    {{-- <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" /> --}}
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
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Manages Roles</h4>
                        </div>
                        <div class="col-auto">
                            @can('role-create')
                                <a class="btn btn-outline-primary" href="{{ route('roles.create') }}"><i class="fa fa-plus"></i> Create New Role</a>
                            @endcan
                            {{-- <button class="btn btn-outline-primary" onclick="buat()" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter"><i class="fas fa-plus"></i> Buat Data</button>
                            <button class="btn btn-outline-primary" onclick="reload()"><i class="fas fa-undo"></i> Reload
                                Data</button> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatables" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Role Name</th>
                                <th>Role Guard</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->guard_name }}</td>
                                    <td>
                                        <div class="button-items">
                                            <a class="btn btn-outline-info" href="{{ route('roles.show', $role->id) }}"><i class="far fa-eye"></i> Detail</a>
                                            @can('role-edit')
                                                <a class="btn btn-outline-warning" href="{{ route('roles.edit', $role->id) }}"><i class="far fa-edit"></i> Edit</a>
                                            @endcan
                                            @can('role-delete')
                                            <form action="{{ route('roles.destroy',$role->id) }}" method="DELETE">
                                            <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash"></i> Delete</button>
                                            </form>
                                            @endcan
                                        </div>
                                            {{-- {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-outline-danger']) !!}
                                            {!! Form::close() !!} --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $roles->links('vendor.pagination.template1.default') }}
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Role Management</h2>
            </div>
            <div class="pull-right">
                @can('role-create')
                    <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($roles as $key => $role)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('roles.show', $role->id) }}">Show</a>
                    @can('role-edit')
                        <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">Edit</a>
                    @endcan
                    @can('role-delete')
                        {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    @endcan
                </td>
            </tr>
        @endforeach
    </table>


    {!! $roles->render() !!}


    <p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p> --}}
@endsection
@section('script')
    {{-- <script src="{{ URL::asset('public/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.datatable.init.js') }}"></script> --}}
    {{-- <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // var table = $('#datatables').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: "{{ route('roles.index') }}",
        //     columns: [
        //         {
        //             data: 'name',
        //             name: 'name'
        //         },
        //         {
        //             data: 'guard_name',
        //             name: 'guard_name'
        //         },
        //         {
        //             data: 'access_detail',
        //             name: 'access_detail'
        //         },
        //         // {
        //         //     data: 'created_at',
        //         //     name: 'created_at'
        //         // },
        //         // {
        //         //     data: 'updated_at',
        //         //     name: 'updated_at'
        //         // },
        //         {
        //             data: 'action',
        //             name: 'action',
        //             orderable: false,
        //             searchable: false
        //         },
        //     ]
        // });

        function buat() {
            $('.modalBuat').modal();
        }

        function reload() {
            table.ajax.reload();
        }
    </script> --}}
@endsection
