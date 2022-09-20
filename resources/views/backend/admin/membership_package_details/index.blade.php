@extends('backend.layouts.master')
@section("title","Membership Package Detail List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Membership Package Detail List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Membership Package Detail List</li>
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
                        <h3 class="card-title float-left">Membership Package Detail Lists</h3>
{{--                        <div class="float-right">--}}
{{--                            <a href="{{route('admin.membership-package-details.create')}}">--}}
{{--                                <button class="btn btn-success">--}}
{{--                                    <i class="fa fa-plus-circle"></i>--}}
{{--                                    Add--}}
{{--                                </button>--}}
{{--                            </a>--}}
{{--                        </div>--}}
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#Id</th>
                                <th>Package Name</th>
                                <th>Buy</th>
                                <th>Sell</th>
                                <th>Commission</th>
                                <th>Job</th>
                                <th>Free SMS</th>
                                <th>Work Order</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($membership_package_details as $key => $membership_package_detail)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$membership_package_detail->membershipPackage->package_name}}</td>
                                <td>{{$membership_package_detail->buy}}</td>
                                <td>{{$membership_package_detail->sell}}</td>
                                <td>{{$membership_package_detail->commission}}</td>
                                <td>{{$membership_package_detail->job}}</td>
                                <td>{{$membership_package_detail->free_sms}}</td>
                                <td>{{$membership_package_detail->work_order}}</td>
                                <td>
                                    <a class="btn btn-info waves-effect" href="{{route('admin.membership-package-details.edit',$membership_package_detail->id)}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
{{--                                    <button class="btn btn-danger waves-effect" type="button"--}}
{{--                                            onclick="deleteSubCategory({{$membership_package_detail->id}})">--}}
{{--                                        <i class="fa fa-trash"></i>--}}
{{--                                    </button>--}}
{{--                                    <form id="delete-form-{{$membership_package_detail->id}}" action="{{route('admin.membership-package-details.destroy',$membership_package_detail->id)}}" method="POST" style="display: none;">--}}
{{--                                        @csrf--}}
{{--                                        @method('DELETE')--}}
{{--                                    </form>--}}
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#Id</th>
                                <th>Package Name</th>
                                <th>Buy</th>
                                <th>Sell</th>
                                <th>Commission</th>
                                <th>Job</th>
                                <th>Free SMS</th>
                                <th>Work Order</th>
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
