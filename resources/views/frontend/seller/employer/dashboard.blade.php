@extends('frontend.layouts.master')
@section('title', 'Employer Dashboard')
@push('css')
@endpush
@section('content')
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3 mobile_view">
                    <h3 class="mb-2 text-secondary">@lang('website.Employer Dashboard')</h3>
                </div>
                @include('frontend.seller.seller_sidebar')
                <div class="col-lg-9 col-sm-9" style="background: #fff;">
                    <h3 class="text-center mt-3">@lang('website.Welcome') <span>{{getNameByBnEn(Auth::user())}}</span></h3>
                    <h5 class="text-center mt-3">@lang('website.Search Your Desired Candidate'):</h5>
                    <form action="{{route('employee.search_candidate')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-4">
                                <input type="hidden" name="lang" id="lang" value="{{app()->getLocale('locale')}}">
                                <label>@lang('website.Industry')</label>
                                <select class="form-control demo-select2" name="industry_category_id" id="industry_categories">
                                    <option disabled selected>@lang('website.Select')</option>
                                    @foreach(\App\Model\IndustryCategory::all() as $industry)
                                        <option value="{{$industry->id}}" {{$industry->id == $industry_category_id ? 'selected' : ''}}>{{getNameByBnEn($industry)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label>@lang('website.Sub Category')</label>
                                <select class="form-control" name="industry_sub_category_id" id="industry_subcategories">
                                    <option disabled selected>@lang('website.Select')</option>
{{--                                    <option>Select</option>--}}
{{--                                    @if(!empty($industry_category_id))--}}
{{--                                        @foreach(\App\Model\IndustrySubCategory::all() as $industrySubCategory)--}}
{{--                                            <option value="{{$industrySubCategory->id}}" {{$industrySubCategory->id == $industry_sub_category_id ? 'selected' : ''}}>{{$industrySubCategory->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}

                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label>@lang('website.Employee Type')</label>
                                <select class="form-control" name="industry_employee_type_id" id="industry_employee_type">

                                    <option disabled selected>@lang('website.Select')</option>

{{--                                    @if(!empty($industry_category_id))--}}
{{--                                        @foreach(\App\Model\IndustryEmployeeType::all() as $industryEmployeeType)--}}
{{--                                            <option value="{{$industryEmployeeType->id}}" {{$industryEmployeeType->id == $industry_employee_type_id ? 'selected' : ''}}>{{$industryEmployeeType->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
                                </select>
                            </div>
                            <div class="text-center mt-2">
                                <button class="btn btn-info"><i class="fa fa-search"></i>@lang('website.Search')</button>
                            </div>
                        </div>
                    </form>

                    @if($employees && count($employees) > 0)
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('website.SL')</th>
                                <th>@lang('website.Image')</th>
                                <th>@lang('website.Name')</th>
                                <th>@lang('website.Experience')</th>
                                <th>@lang('website.Location')</th>
                                <th>@lang('website.Expected Salary')</th>
                                <th>@lang('website.Age')</th>
                                <th>@lang('website.Verification Status')</th>
                                <th>@lang('website.Details')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $key => $employee)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>
                                        @if($employee->employee_pic)
                                        <img loading="lazy" src="{{ url($employee->employee_pic) }}" alt="" class="img-responsive" height="60px" width="auto">
                                        @else
                                            <img src="{{asset('default.png')}}" height="60">
                                        @endif

                                    </td>
                                    <td>{{getNameByBnEn($employee->user)}}</td>
                                    <td>{{$employee->experience}}</td>
                                    <td>{{$employee->village_or_area}}</td>
                                    <td>{{$employee->expected_salary}}</td>
                                    <td>{{getNumberToBangla($employee->age)}}</td>
                                    <td>
                                        @if($employee->verification_status == 0)
                                            @lang('website.Applied')
                                        @else
                                            @lang('website.Verified')
                                        @endif
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
                                <th>@lang('website.Experience')</th>
                                <th>@lang('website.Location')</th>
                                <th>@lang('website.Expected Salary')</th>
                                <th>@lang('website.Age')</th>
                                <th>@lang('website.Verification Status')</th>
                                <th>@lang('website.Details')</th>
                            </tr>
                            </tfoot>
                        </table>
                        @else
                            <h3 class="text-center mt-3">@lang('website.No Candidate Found!')</h3>
                        @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
<script>
    $(document).ready(function () {
        get_industry_subcategories();
        get_industry_employee_type();
    });

    $('#industry_categories').on('change', function () {
        get_industry_subcategories();
    });
    $('#industry_subcategories').on('change', function () {
        get_industry_employee_type();
    });

    // Get BN EN Name
    function getNameBnEn($name,$name_bn){
        var lang = $('#lang').val();
        var curr_lang = '';
        if(lang === 'en'){
            curr_lang = $name;
        }else{
            curr_lang = $name_bn ? $name_bn : $name;
        }
        return curr_lang;
    }

    function get_industry_subcategories(){
        var industry_category_id = $('#industry_categories').val();
        console.log(industry_category_id);
        $.post('{{ route('employee.get_industry_subcategories') }}', {
            _token: '{{ csrf_token() }}',
            industry_category_id: industry_category_id
        }, function (data) {
            //console.log(data)
                $('#industry_subcategories').html(null);
                $('#industry_subcategories').append($('<option>', {
                    value: null,
                    text: null
                }));
                for (var i = 0; i < data.length; i++) {
                    $('#industry_subcategories').append($('<option>', {
                        value: data[i].id,
                        text: getNameBnEn(data[i].name,data[i].name_bn)
                    }));
                }
                $("#industry_subcategories > option").each(function() {
                    if(this.value == '{{$industry_sub_category_id}}'){
                        $("#industry_subcategories").val(this.value).change();
                    }
                });
        });
    }
    function get_industry_employee_type(){
        var industry_category_id = $('#industry_categories').val();
        var industry_subcategory_id = $('#industry_subcategories').val();
        console.log(industry_subcategory_id);
        $.post('{{ route('employee.get_industry_employee_type') }}', {
            _token: '{{ csrf_token() }}',
            industry_category_id: industry_category_id,
            industry_subcategory_id: industry_subcategory_id,
        }, function (data) {
            console.log(data)

            $('#industry_employee_type').html(null);
            $('#industry_employee_type').append($('<option>', {
                value: null,
                text: null
            }));
            for (var i = 0; i < data.length; i++) {
                $('#industry_employee_type').append($('<option>', {
                    value: data[i].id,
                    text: getNameBnEn(data[i].name,data[i].name_bn)
                }));
            }
                $("#industry_employee_type > option").each(function() {
                    if(this.value == '{{$industry_employee_type_id}}'){
                        $("#industry_employee_type").val(this.value).change();
                    }
                });

        });
    }
</script>
@endpush

