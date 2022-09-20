@extends('backend.layouts.master')
@section("title","Employer List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Employer List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Employer List</li>
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
                        <h3 class="card-title float-left">Employer Lists</h3>
                        <div class="float-right">
                            <a href="{{route('admin.employer.create')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-plus-circle"></i>
                                    Add
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Reg Date</th>
                                <th>Name</th>
                                <th>Company Name</th>
                                <th>Company Owner</th>
                                <th>Company Phone</th>
                                <th>Company Location</th>
                                <th>Reg By</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employers as $key => $employer)

                                <tr>
                                    <td>
                                        {{$key + 1}}
                                    </td>
                                    <td>{{date('d M Y',strtotime($employer->created_at))}}</td>
                                    <td>
                                        {{$employer->user->name}}
                                    </td>
                                    <td>
                                        {{$employer->seller->company_name}}
                                    </td>
                                    <td>{{$employer->owner_name}}</td>
                                    <td>{{$employer->seller->company_phone}}</td>
                                    <td>
                                        {{$employer->seller->company_address}}
                                    </td>
                                    @php
                                        $types = json_decode($employer->industry_category_id);
                                    @endphp
                                    <td>
                                        {{$employer->user->reg_by}}
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-info waves-effect waves-light mBtn" data-toggle="modal" data-target="#exampleModal" onclick="show_details_modal('{{$employer->id}}');">Details</button>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="bg-info dropdown-item" href="{{route('admin.employer.edit',encrypt($employer->id))}}">
                                                    Edit Profile
                                                </a>
                                                <a class="bg-info dropdown-item" href="{{route('admin.employer.edit-password',encrypt($employer->id))}}">
                                                    Edit Password
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#SL</th>
                                <th>Reg Date</th>
                                <th>Name</th>
                                <th>Company Name</th>
                                <th>Company Owner</th>
                                <th>Company Phone</th>
                                <th>Company Location</th>
                                <th>Reg By</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="employer_details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>
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
    <script>

        function show_details_modal(id){
            $.post('{{ route('admin.employer-modal.details') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#employer_details #modal-content').html(data);
                $('#employer_details').modal('show', {backdrop: 'static'});
            });
        }
    </script>
@endpush
