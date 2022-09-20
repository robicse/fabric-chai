@extends('backend.layouts.master')
@section("title","Sub Sub Child Child categories List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sub Sub Child Child Categories List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Sub Sub Child Child Categories List</li>
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
                        <h3 class="card-title float-left">Sub Sub Child Child Categories Lists</h3>
                        <div class="float-right">
                            <a href="{{route(Request::segment(2) == 'sub-sub-child-child-categories'?'admin.sub-sub-child-child-categories.create':'admin.wo-sub-sub-child-child-categories.create')}}">
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
                                <th>#Id</th>
                                <th>Name</th>
                                <th>নাম</th>
                                <th>Sub Sub Child Category Name</th>
                                <th>Sub Sub Category Name</th>
                                <th>Sub Category Name</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subSubChildChildCategories as $key => $subSubChildChildCategory)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$subSubChildChildCategory->name}}</td>
                                <td>{{$subSubChildChildCategory->name_bn}}</td>
                                <td>{{$subSubChildChildCategory->subsubchildcategory->name}}</td>
                                <td>{{$subSubChildChildCategory->subsubchildcategory->subsubcategory->name}}</td>
                                <td>{{$subSubChildChildCategory->subsubchildcategory->subsubcategory->subcategory->name}}</td>
                                <td>{{$subSubChildChildCategory->subsubchildcategory->subsubcategory->subcategory->category->name}}</td>
                                <td>
                                    @if(Request::segment(2) == 'sub-sub-child-child-categories')
                                        <a class="btn btn-info waves-effect" href="{{route('admin.sub-sub-child-child-categories.edit',$subSubChildChildCategory->id)}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-info waves-effect" href="{{route('admin.wo-sub-sub-child-child-categories.edit',$subSubChildChildCategory->id)}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#Id</th>
                                <th>Name</th>
                                <th>নাম</th>
                                <th>Sub Sub Child Category Name</th>
                                <th>Sub Sub Category Name</th>
                                <th>Sub Category Name</th>
                                <th>Category Name</th>
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

        //sweet alert
        function deleteSubCategory(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your Data is save :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush
