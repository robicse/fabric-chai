@extends('backend.layouts.master')
@section("title","Un Approve Employee List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            margin: 0;
            white-space: nowrap;
            text-align: right;
            display: flex;
            flex-direction: row;
            gap: 5px;
            align-items: center;
            justify-content: end;
        }

        .dataTables_paginate.paging_input .paginate_button {
            border: 1px solid #ddd;
            padding: 2px 5px;
            cursor: pointer;
            transition: all .2s linear;
        }

        .dataTables_paginate.paging_input .paginate_button:hover {
            background: rgba(50, 50, 50, 1);
            color: #fff;
        }

        .dataTables_paginate.paging_input .paginate_input {
            width: 80px;
        }

    </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Un Approve Employee List</h1>
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
                        <h3 class="card-title float-left">Un Approve Employee Lists</h3>
                        <div class="float-right">
                            <a href="{{route('admin.employee.create')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-plus-circle"></i>
                                    Add
                                </button>
                            </a>
                            @if(Auth::User()->user_type == 'admin')
{{--                                <a href="{{route('admin.total-employee-export')}}" target="_blank">--}}
{{--                                    <button class="btn btn-info text-center" style="">Excel</button>--}}
{{--                                </a>--}}
{{--                                <a href="{{route('admin.total-employee-pdf')}}" target="_blank">--}}
{{--                                    <button class="btn btn-primary text-center" style="">PDF</button>--}}
{{--                                </a>--}}
                            @endif
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="customised_data_table" class="table table-bordered table-striped">
                            <thead>
                            <tr style="font-size: 16px;">
                                <th>#SL</th>
                                <th>Reg Date</th>
                                <th>নাম/Name</th>
                                <th>লিঙ্গ/Gender</th>
                                <th>বয়স/Age</th>
                                <th>মোবাইল নাম্বার/Mobile Number</th>
                                <th>Verification Status</th>
                                <th>Reg By</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                            </thead>

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
    <script src="//cdn.datatables.net/plug-ins/1.11.5/pagination/input.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            $('#customised_data_table').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                pagingType: "input",
                aLengthMenu: [
                    [10, 25, 50, 100, 200, 400, 500, -1],
                    [10, 25, 50, 100, 200, 400, 500, "All"]
                ],

                ajax: '{{ route('admin.un-approve-employee-list.ajax') }}',
                columns: [
                    {
                        "title": "#SL",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        searching: false,
                        orderable: false,

                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        searching: false,
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'age',
                        name: 'age',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                    },
                    {
                        data: 'verification_status',
                        name: 'verification_status',
                        searching: false,
                    },
                    {
                        data: 'reg_by',
                        name: 'reg_by',
                    },
                    {
                        data: 'details',
                        name: 'details',
                        searching: false,
                        orderable: false,
                        class: 'text-center'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        searching: false,
                        orderable: false,
                        class: 'text-center'
                    }
                ]
            });
        });
    </script>
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
