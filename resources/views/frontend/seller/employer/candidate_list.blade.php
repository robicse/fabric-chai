@extends('frontend.layouts.master')
@section("title","Candidate List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <!-- Main content -->
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3 mobile_view">
                    <h3 class="mb-2 text-secondary">@lang('website.Employer Dashboard')</h3>
                </div>
                @include('frontend.seller.seller_sidebar')
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title float-left">@lang('website.Candidates List')</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Image')</th>
                                            <th>@lang('website.Name')</th>
                                            <th>@lang('website.Location')</th>
                                            <th>@lang('website.Expected Salary')</th>
                                            <th>@lang('website.Age')</th>
                                            <th>@lang('website.Verification Status')</th>
                                            <th>@lang('website.Details')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($messages as $key => $message)
                                            @php
                                                $employee = \App\Model\Employee::where('user_id',$message->receiver_user_id)->first();
                                            @endphp
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>
                                                    @if($employee->employee_pic)
                                                    <img loading="lazy" src="{{ url($employee->employee_pic) }}" alt="" class="img-responsive" height="60px" width="auto">
                                                    @else
                                                        <img loading="lazy" src="{{ url($employee->user->avatar_original) }}" alt="" class="img-responsive" height="60px" width="auto">
                                                    @endif
                                                </td>
                                                <td>{{$employee->user->name}}</td>
                                                <td>{{$employee->village_or_area}}</td>
                                                <td>
                                                    @if($employee->expected_salary)
                                                        @php
                                                            $expected_salary = explode(' - ',$employee->expected_salary);
                                                        @endphp
                                                        {{getNumberWithCurrencyByBnEn($expected_salary[0]) .' - '. getNumberWithCurrencyByBnEn($expected_salary[1]) }}
                                                    @endif
                                                </td>
                                                <td>{{getNumberToBangla($employee->age)}}</td>
                                                <td>
                                                    {{$employee->verification_status == 0 ? 'Applied' : 'Verified'}}
                                                </td>
                                                <td>
                                                    <a class="btn btn-success" href="{{route('employee.view_employee_details',$employee->id)}}">
                                                        @lang('website.Profile')
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Image')</th>
                                            <th>@lang('website.Name')</th>
                                            <th>@lang('website.Location')</th>
                                            <th>@lang('website.Expected Salary')</th>
                                            <th>@lang('website.Age')</th>
                                            <th>@lang('website.Verification Status')</th>
                                            <th>@lang('website.Details')</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
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
@endpush
