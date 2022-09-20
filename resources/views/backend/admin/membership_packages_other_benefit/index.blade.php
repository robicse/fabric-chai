@extends('backend.layouts.master')
@section("title","Membership Package Other Benefits List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Membership Other Benefits Lists</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Membership Package Other Benefits List</li>
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
                        <h3 class="card-title float-left">Membership Other Benefits Lists</h3>
{{--                        <div class="float-right">--}}
{{--                            <a href="{{route('admin.membership-package-other-benefit.create')}}">--}}
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
                                <th>Market Strategic Info.</th>
                                <th>R&D facilities</th>
                                <th>Costing facilities</th>
                                <th>Promotion facilities</th>
                                <th>Bank loan facilities</th>
                                <th>Customer acquisition opportunity</th>
                                <th>Discount offers</th>
                                <th>Training facilities</th>
                                <th>Ad discounts</th>
                                <th>Credit facilities</th>
                                <th>Loyalty Program</th>
                                <th>Yarn price update</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($membership_packages_other_benefits as $key => $membership_packages_other_benefit)
{{--                                @dd($membership_packages_other_benefit->membershipPackage->package_name)--}}
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$membership_packages_other_benefit->membershipPackage->package_name}}</td>
                                    <td>{{$membership_packages_other_benefit->market_strategic}}</td>
                                    <td>{{$membership_packages_other_benefit->rd_facilities}}</td>
                                    <td>{{$membership_packages_other_benefit->costing_facilities}}</td>
                                    <td>{{$membership_packages_other_benefit->promotion_facilities}}</td>
                                    <td>{{$membership_packages_other_benefit->bank_loan_facilities}}</td>
                                    <td>{{$membership_packages_other_benefit->customer_acquisition_facilities}}</td>
                                    <td>{{$membership_packages_other_benefit->discount_offers}}</td>
                                    <td>{{$membership_packages_other_benefit->training_facility}}</td>
                                    <td>{{$membership_packages_other_benefit->ad_discounts}}</td>
                                    <td>{{$membership_packages_other_benefit->credit_facilities}}</td>
                                    <td>{{$membership_packages_other_benefit->loyalty_program}}</td>
                                    <td>{{$membership_packages_other_benefit->yarn_price_update}}</td>
                                    <td>
                                        <a class="btn btn-info waves-effect" href="{{route('admin.membership-package-other-benefit.edit',$membership_packages_other_benefit->id)}}">
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
                                <th>Market Strategic Info.</th>
                                <th>R&D facilities</th>
                                <th>Costing facilities</th>
                                <th>Promotion facilities</th>
                                <th>Bank loan facilities</th>
                                <th>Customer acquisition opportunity</th>
                                <th>Discount offers</th>
                                <th>Training facilities</th>
                                <th>Ad discounts</th>
                                <th>Credit facilities</th>
                                <th>Loyalty Program</th>
                                <th>Yarn price update</th>
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
        function deleteBrand(id) {
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
