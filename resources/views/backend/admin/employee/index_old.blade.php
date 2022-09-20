@extends('backend.layouts.master')
@section("title","Employee List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Employee List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Employee List</li>
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
                        <h3 class="card-title float-left">Employee Lists</h3>
                        <div class="float-right">
                            <a href="{{route('admin.employee.create')}}">
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
                            <tr style="font-size: 16px;">
                                <th>#SL</th>
                                <th>Reg Date</th>
                                <th>নাম/Name</th>
                                <th>লিঙ্গ/Gender</th>
                                <th>বয়স/Age</th>
                                <th>মোবাইল নাম্বার/Mobile Number</th>
                                <th>যে কাজ খুঁজছি/Looking for Job in</th>
                                <th>Verification Status</th>
                                <th>Reg By</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $key => $employee)

                                <tr>
                                    <td>
                                        {{$key + 1}}
                                    </td>
                                    <td>{{date('d M Y',strtotime($employee->created_at))}}</td>
                                    <td>
                                        {{$employee->user->name}}
                                    </td>
                                    <td>{{$employee->gender}}</td>
                                    <td>{{$employee->age}}</td>
                                    <td>{{$employee->user->country_code.$employee->user->phone}}</td>
                                    <td>
                                        {{$employee->looking_job_industry_category_id ? $employee->lookingForJob->name:null}}
                                    </td>
                                    <td>
                                        <div class="form-group col-md-2">
                                            <label class="switch" >
                                                <input onchange="verification_status(this)" value="{{$employee->id }}" {{$employee->verification_status == 1? 'checked':''}} type="checkbox" >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        {{$employee->user->reg_by}}
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-info waves-effect waves-light mBtn" data-toggle="modal" data-target="#exampleModal" onclick="show_details_modal('{{$employee->id}}');">Details</button>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="bg-info dropdown-item" href="{{route('admin.employee.edit',encrypt($employee->id))}}">
                                                    Edit Profile
                                                </a>
                                                <a class="bg-info dropdown-item" href="{{route('admin.employee.edit-password',encrypt($employee->id))}}">
                                                    Edit Password
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr style="font-size: 16px;">
                                <th>#SL</th>
                                <th>Reg Date</th>
                                <th>নাম/Name</th>
                                <th>লিঙ্গ/Gender</th>
                                <th>বয়স/Age</th>
                                <th>মোবাইল নাম্বার/Mobile Number</th>
                                <th>যে কাজ খুঁজছি/Looking for Job in</th>
                                <th>Verification Status</th>
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
            $.post('{{ route('admin.employee-modal.details') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#employer_details #modal-content').html(data);
                $('#employer_details').modal('show', {backdrop: 'static'});
            });
        }
        function verification_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('admin.employee.verification') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                // alert(data)
                if(data == 1){
                    toastr.success('success', 'Verification Status updated successfully');
                    location.reload();
                }
                else{
                    toastr.danger('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endpush
