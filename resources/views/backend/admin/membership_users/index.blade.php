@extends('backend.layouts.master')
@section("title","Membership Users List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Membership Users List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Membership Users List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">Membership Users List</h3>
                        <div class="float-right">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Current Membership Package</th>
                                <th>Membership Activation Date</th>
                                <th>Membership Expire Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $key => $user)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>
                                        {{$user->name}}
                                    </td>
                                    <td>
                                        {{$user->country_code.$user->phone}}
                                    </td>
                                    @php
                                        $roles = json_decode($user->multiple_user_types)
                                    @endphp
                                    <td>
                                        @foreach($roles as $role)
                                            <button class="btn btn-primary">{{$role}}</button>
                                        @endforeach
                                    </td>
                                    <td>
                                        <button class="btn btn-success">{{checkCurrentMembershipName($user->id)}}</button>
                                    </td>
                                    <td>{{date('j M, Y',strtotime($user->membership_activation_date))}}</td>
                                    <td>{{date('j M, Y',strtotime($user->membership_expired_date))}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#SL</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Current Membership Package</th>
                                <th>Membership Activation Date</th>
                                <th>Membership Expire Date</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>

@stop
@push('js')
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

    </script>
@endpush

