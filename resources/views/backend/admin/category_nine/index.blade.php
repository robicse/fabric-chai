@extends('backend.layouts.master')
@section("title","Category Nine List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Category Nine List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Category Nine List</li>
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
                        <h3 class="card-title float-left">Category Nine Lists</h3>
                        <div class="float-right">
                            <a href="{{route(Request::segment(2) == 'category-nine'?'admin.category-nine.create':'admin.wo-category-nine.create')}}">
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
                                <th>Name</th>
                                <th>নাম</th>
                                <th>Category Eight Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categoryNines as $key => $categoryNine)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$categoryNine->name}}</td>
                                    <td>{{$categoryNine->name_bn}}</td>
                                    <td>{{$categoryNine->categoryEight->name}}</td>
                                    <td>
                                        @if(Request::segment(2) == 'category-nine')
                                            <a class="btn btn-info waves-effect" href="{{route('admin.category-nine.edit',$categoryNine->id)}}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-info waves-effect" href="{{route('admin.wo-category-nine.edit',$categoryNine->id)}}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#SL</th>
                                <th>Name</th>
                                <th>নাম</th>
                                <th>Category Eight Name</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
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
