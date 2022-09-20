@extends('frontend.layouts.master')
@section('title', 'Employee Profile')
@push('css')
@endpush
@section('content')
    <div class="full-row" style="background-color: #ffffff;">
        <div class="container">
            <div class="row">
                @include('frontend.employee.employee_breadcrumb')
                @include('frontend.employee.employee_sidebar')
                <div class="col-lg-9">
                    <h4 class="text-center">@lang('website.Profile')</h4>

                    <div class="" style="padding-top: 20px; padding-left: 10px;">
                        <div class="row">
                            <div class="card col-lg-12 col-md-12 col-12">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td colspan="3">নাম/Name:</td>
                                        <td colspan="3">{{getNameByBnEn(Auth::User())}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">ইমেইল/Email:</td>
                                        <td colspan="3">{{Auth::User()->email}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">ফোন নাম্বার/Phone Number:</td>
                                        <td colspan="3">{{Auth::User()->country_code.Auth::User()->phone}}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="3">বর্তমান চাকরীর অবস্থা/Current Job Status:</td>
                                        <td colspan="3">{{$employee->current_job_status == '0' ? 'Searching For Job' : 'Already In Job'}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">ভেরিফিকেশন স্টেটাস/Verification Status:</td>
                                        <td colspan="3">{{$employee->verification_status == '0' ? 'Applied' : 'Approved'}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">বিভাগ/Division:</td>
                                        <td colspan="3">{{$employee->division_id != NULL ? getNameByBnEn($employee->division):''}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">জেলা/District:</td>
                                        <td colspan="3">{{$employee->district_id != NULL ? getNameByBnEn($employee->district):''}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">থানা/Thana:</td>
                                        <td colspan="3">{{$employee->upazila_id != NULL ? getNameByBnEn($employee->upazila):''}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">পোস্ট অফিস/Post Office:</td>
                                        <td colspan="3">{{$employee->union_id != NULL ? getNameByBnEn($employee->union):''}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">গ্রাম অথবা এলাকা/Village or Area:</td>
                                        <td colspan="3">{{$employee->village_or_area}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">বৈবাহিক অবস্থা/Marital Status:</td>
                                        <td colspan="3">@lang('website.'.$employee->marital_status)</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">বয়স/Age:</td>
                                        <td colspan="3">{{ $employee->age !== NULL ? getNumberToBangla($employee->age) : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">লিঙ্গ/Gender:</td>
                                        <td colspan="3">@lang('website.'.$employee->gender)</td>
                                    </tr>
                                    @php
                                        $current_salary = explode(' - ',$employee->current_salary);
                                        $expected_salary = explode(' - ',$employee->expected_salary);
                                    @endphp
                                    <tr>
                                        <td colspan="3">বর্তমান বেতন/Current Salary:</td>
                                        <td colspan="3">

                                            @if($employee->current_salary)
                                            {{getNumberWithCurrencyByBnEn($current_salary[0]) .' - '. getNumberWithCurrencyByBnEn($current_salary[1]) }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">কাঙ্ক্ষিত বেতন/Expected Salary:</td>
                                        @if($employee->expected_salary)
                                        <td colspan="3">{{getNumberWithCurrencyByBnEn($expected_salary[0]) .' - '. getNumberWithCurrencyByBnEn($expected_salary[1]) }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td colspan="3">কয়দিনের মধ্যে যোগদান করতে পারবে/Joining Duration:</td>
                                        <td colspan="3">{{$employee->joining_duration}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">দক্ষতা /Expertise:</td>
                                        <td colspan="3">{{$employee->industrycategory ? getNameByBnEn($employee->industrycategory) : ''}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="3">{{$employee->industrysubcategory ? getNameByBnEn($employee->industrysubcategory) : ''}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="3">{{$employee->industryemployeetype ? getNameByBnEn($employee->industryemployeetype) : ''}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table mt-3">
                                    <tbody>
                                    <tr>
                                        <td colspan="3">কাজের অভিজ্ঞতা / Job Experience</td>
                                        <td colspan="3"><a data-bs-toggle="modal" data-bs-target="#jobExperienceAdd" style="font-size: 18px; color: green"><i class="fa fa-plus-circle text-success"></i>@lang('website.Add More')</a></td>
                                    </tr>
                                    @if($employee->employeeJobExperience)
                                        <tr style="background-color: grey">
                                            <td colspan="2" >@lang('website.Designation')</td>
                                            <td colspan="1">@lang('website.Company Name')</td>
                                            <td>@lang('website.Start Year')</td>
                                            <td>@lang('website.End Year')</td>
                                            <td></td>
                                        </tr>
                                        @foreach($employee->employeeJobExperience as $experience)
                                            <tr>
                                                <td colspan="2">{{$experience->designation}}</td>
                                                <td colspan="1">{{$experience->company_name}}</td>
                                                <td>{{getNumberToBangla($experience->start_year)}}</td>
                                                <td>{{getNumberToBangla($experience->end_year)}}
                                                </td>
                                                <td>
                                                    <a class="text-info" data-bs-toggle="modal" data-bs-target="#job_edit" onclick="show_job_edit_modal('{{$experience->id}}');"><i class="fa fa-edit text-info"></i> Edit</a>
                                                    <a class="" onclick="deleteEducation('{{$experience->id}}');"><i class="fa fa-trash"></i> Delete</a>
                                                    <form id="delete-form-{{$experience->id}}" action="{{route('employee.job-experience.destroy',$experience->id)}}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>

                                <table class="table mt-5">
                                    <tbody>
                                    <tr class="mt-5">
                                        <td colspan="3" class="text-bold">শিক্ষাগত যোগ্যতা / Educational Qualification </td>
                                        <td colspan="3"><a data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="font-size: 18px; color: green"><i class="fa fa-plus-circle text-success"></i> @lang('website.Add More')</a></td>

                                    </tr>
                                    @if($employee->employeeEducation)
                                        <tr style="background-color: grey">
                                            <td >@lang('website.Level')</td>
                                            <td >@lang('website.Degree')</td>
                                            <td >@lang('website.Institute')</td>
                                            <td >@lang('website.Passing Year')</td>
                                            <td >@lang('website.Group')</td>
                                            <td >@lang('website.Result')</td>
                                        </tr>
                                        @foreach($employee->employeeEducation as $education)
                                            <tr>
                                                <td>{{$education->level}}</td>
                                                <td>{{$education->degree}}</td>
                                                <td>{{$education->institute}}</td>
                                                <td>{{getNumberToBangla($education->passing_year)}}</td>
                                                <td>{{$education->group}}</td>
                                                <td>
                                                    {{getNumberToBangla($education->result)}}
                                                    <a class="text-info" data-bs-toggle="modal" data-bs-target="#education_edit" onclick="show_edit_modal('{{$education->id}}');"><i class="fa fa-edit text-info"></i> Edit</a>
                                                    <a class="" data-bs-toggle="modal" data-bs-target="#education_edit" onclick="deleteEducation('{{$education->id}}');"><i class="fa fa-trash"></i> Delete</a>
                                                    <form id="delete-form-{{$education->id}}" action="{{route('employee.education.destroy',$education->id)}}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>

                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6"></td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <table class="table mt-5">
                                    <tbody>
                                    <tr>
                                        <td colspan="2">এনআইডি সামনের দিক/NID Front Side:</td>
                                        <td colspan="4">
                                            @if ($employee->nid_front_side != null)
                                                <div class="col-md-4 col-sm-4 col-xs-6">
                                                    <div class="img-upload-preview">
                                                        <a href="{{ url($employee->nid_front_side) }}"> <img loading="lazy"  src="{{ url($employee->nid_front_side) }}" alt="" class="img-responsive"> </a>
                                                    </div>
                                                </div>
                                            @else
                                                <p>Image not found</p>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">এনআইডি পিছনের দিক/NID Back Side:</td>
                                        <td colspan="4">
                                            @if ($employee->nid_back_side != null)
                                                <div class="col-md-4 col-sm-4 col-xs-6">
                                                    <div class="img-upload-preview">
                                                        <a href="{{ url($employee->nid_back_side) }}"> <img loading="lazy"  src="{{ url($employee->nid_back_side) }}" alt="" class="img-responsive"> </a>
                                                    </div>
                                                </div>
                                            @else
                                                <p>Image not found</p>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">প্রোফাইল ছবি/Profile Image:</td>
                                        <td colspan="4">
                                            @if ($employee->employee_pic != null)
                                                <div class="col-md-4 col-sm-4 col-xs-6">
                                                    <div class="img-upload-preview">
                                                        <a href="{{ url($employee->employee_pic) }}"> <img loading="lazy"  src="{{ url($employee->employee_pic) }}" alt="" class="img-responsive"> </a>
                                                    </div>
                                                </div>
                                            @else
                                                <p>Image not found</p>
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 40px;">
                        <div class="col-lg-4 col-md-4 col-5">
                            <a class="btn btn-primary" href="{{route('employee.edit-profile')}}">@lang('website.Edit Profile') </a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-7">
                            <form action="{{route('password-update.otp-send')}}" method="POST">
                                @csrf
                                <input type="hidden" name="phone" value="{{Auth::User()->phone}}">
                                <button type="submit" class="woocommerce-form-login__submit btn btn-primary rounded-0" style="background-color: purple" >
                                    @lang('website.Change Password')
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Education Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('employee.education-store')}}" method="POST">
                        @csrf
                        @php
                            $y = date('Y');
                        @endphp
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12" >
                                <label for="degree">Level of Education<span class="required">*</span></label>
                                <select class="form-control levels" name="level" id="level" onchange="getDegree()" style="background-color: white">
                                    @foreach(\App\Model\EducationLevel::all() as $educationLevel)
                                        <option value="{{$educationLevel->name}}">{{$educationLevel->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12" >
                                <label for="degree">Degree<span class="required">*</span></label>
                                <select class="form-control" name="degree" id="degree" style="background-color: white">

                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12" >
                                <label for="institute">Institute<span class="required">*</span></label>
                                <input type="text" class="form-control" name="institute" placeholder="Enter Institute Name" style="background-color: white">
                            </div>

                            <div class="col-lg-6 col-md-6 col-12" >
                                <label for="passing_year">Passing Year<span class="required">*</span></label>
                                <select name="passing_year" class="form-control demo-select2" style="background-color: white">
                                    <option value="">Select</option>
                                    @for($i=$y;$i >= 1990; $i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12" >
                                <label for="group">Group<span class="required">*</span></label>
                                <input type="text" class="form-control" name="group" placeholder="Enter Group Name" style="background-color: white">
                            </div>
                            <div class="col-lg-6 col-md-6 col-12" >
                                <label for="result">Result<span class="required">*</span></label>
                                <input type="text" class="form-control" name="result" placeholder="Enter Result" style="background-color: white">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-info">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="jobExperienceAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Job Experience Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('employee.job-experience-store')}}" method="POST">
                        @csrf
                        @php
                            $y = date('Y');
                        @endphp
                        <div class="row" >
                            <div class="col-lg-6 col-md-6 col-12" >
                                <label for="designation">Designation<span class="required">*</span></label>
                                <input type="text" class="form-control" name="designation" placeholder="Enter Your Designation" style="background-color: white">
                            </div>
                            <div class="col-lg-6 col-md-6 col-12" >
                                <label for="company_name">Company Name<span class="required">*</span></label>
                                <input type="text" class="form-control" name="company_name" placeholder="Enter Your Company Name" style="background-color: white">
                            </div>
                            <div class="col-lg-6 col-md-6 col-12" >
                                <label for="start_year">Start Year<span class="required">*</span></label>
                                <select name="start_year" class="form-control demo-select2" style="background-color: white">
                                    <option value="">Select</option>
                                    @for($i=$y;$i >= 1990; $i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12" >
                                <label for="end_year">End Year<span class="required">*</span></label>
                                <select name="end_year" class="form-control demo-select2" style="background-color: white">
                                    <option value="">Select</option>
                                    <option value="Current">Current</option>
                                    @for($i=$y;$i >= 1990; $i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12" >
                                <label for="response">Response</label>
                                <textarea name="response" rows="3" class="form-control" style="background-color: white"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-info">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="education_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="modal-content-edit">


            </div>
        </div>
    </div>
    <div class="modal fade" id="job_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="modal-content-job_edit">


            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script>
        function deleteEducation(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-sm btn-success',
                cancelButtonClass: 'btn btn-sm btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    result.dismiss === swal.DismissReason.cancel,
                        location.reload()

                ) {
                    swal(
                        'Cancelled',
                        'Your Data is save :)',
                        'error'
                    )

                }
            })
        }
        function show_edit_modal(id){
            $.post('{{ route('employee.education.edit') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#education_edit #modal-content-edit').html(data);
                $('#education_edit').modal('show', {backdrop: 'static'});
            });
        }
        function show_job_edit_modal(id){
            $.post('{{ route('employee.job-experience.edit') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#job_edit #modal-content-job_edit').html(data);
                $('#job_edit').modal('show', {backdrop: 'static'});
            });
        }

        $(document).ready(function () {
            getDegree();
            getDegree2();
        })
        function getDegree(){
            var degree_name = $('#level').val();

            $.post('{{ route('get_education_degree') }}', {
                _token: '{{ csrf_token() }}',
                degree_name: degree_name
            }, function (data) {
                $('#degree').html(null);

                for (var i = 0; i < data.length; i++) {
                    $('#degree').append($('<option>', {
                        value: data[i].name,
                        text: data[i].name
                    }));
                }
            });
        }

    </script>
@endpush

