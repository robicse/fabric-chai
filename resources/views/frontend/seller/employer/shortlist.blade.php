@extends('frontend.layouts.master')
@section("title","Employe Shortlist")
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
                                    <h3 class="card-title float-left">@lang('website.Employee Shortlist')</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Image')</th>
                                            <th>@lang('website.Name')</th>
                                            <th>@lang('website.Location')</th>
                                            <th>@lang('website.Experience')</th>
                                            <th>@lang('website.Expected Salary')</th>
                                            <th>@lang('website.Age')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($shortlists as $key => $shortlist)
                                            <tr>
                                                <td>
                                                    <input class='chk' type='checkbox' id='{{$shortlist->employee_user_id}}' style="margin-top: 20px;">
                                                </td>
                                                <td>{{getNumberToBangla($key + 1)}}</td>
                                                @php
                                                    $employee =\App\Model\Employee::where('user_id',$shortlist->employee_user_id)->first();

                                                @endphp
                                                <td>
                                                    @if($employee->employee_pic)
                                                        <img loading="lazy" src="{{ url($employee->employee_pic) }}" alt="" class="img-responsive" height="60px" width="auto">
                                                    @else
                                                        <img loading="lazy" src="{{ url($employee->user->avatar_original) }}" alt="" class="img-responsive" height="60px" width="auto">
                                                    @endif
                                                </td>
                                                <td>{{getNameByBnEn($shortlist->user)}}</td>
                                                <td>{{$shortlist->employee->village_or_area}}</td>
                                                <td>{{$shortlist->employee->experience}}</td>
                                                <td>
                                                    @if($shortlist->employee->expected_salary)
                                                        @php
                                                            $expected_salary = explode(' - ',$shortlist->employee->expected_salary);
                                                        @endphp
                                                        {{getNumberWithCurrencyByBnEn($expected_salary[0]) .' - '. getNumberWithCurrencyByBnEn($expected_salary[1]) }}
                                                    @endif
                                                </td>
                                                <td>{{getNumberToBangla($shortlist->employee->age)}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Image')</th>
                                            <th>@lang('website.Name')</th>
                                            <th>@lang('website.Location')</th>
                                            <th>@lang('website.Experience')</th>
                                            <th>@lang('website.Expected Salary')</th>
                                            <th>@lang('website.Age')</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-header multiple_message">
                                    <h5 class="card-title text-center">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="background-color: #500f50;">
                                            @lang('website.Multiple Message')
                                        </button>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="staticBackdropLabel">Write Your Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('employer.employer_to_employee_multiple_message')}}" method="POST">
                        @csrf
                        <input type='hidden' id='hdncheckbox' name="employee_user_ids" />
                        <div>
                            <div class="" style="padding-top: 20px">
                                <div class="row">
                                    <div class="">
                                        <textarea class="form-control border border-black" name="message" id="comment" rows="8" placeholder="Textarea" style="background-color: #f3f3f3;" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-top: 20px;">
                                <div class="col-md-6 col-6">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" style="background-color: #ab0e0e;">Close</button>
                                </div>
                                <div class="col-md-6 col-6">
                                    <button type="submit" class="btn btn-success" style="background-color: #4ce43a;">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
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


        $(document).ready(function(){
            $('.multiple_message').hide(200);
        });
        var tmp = [];
        $(".chk").on("change", function() {
            tmp = [];
            $(".chk").each(function() {
                if($(this).prop("checked") == true)
                {
                    tmp.push($(this).attr("id"));
                }
            });
            $("#hdncheckbox").val(JSON.stringify(tmp));
            // $("#result").val($("#hdncheckbox").val());
            // console.log($("#hdncheckbox").val())

            // custom start
            if(tmp.length == 0){
                console.log('a')
                $('.multiple_message').hide(200);
            }else{
                console.log('b')
                $('.multiple_message').show(300);
            }
            // custom end
        });
    </script>
@endpush
