<link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
<style>
    th{
        color: #212529;
    }
</style>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><b>{{$employee->user->name}}</b> Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table id="modalTbl" class="table table-bordered table-striped">
        <tr>
            <td colspan="2" class="text-center">
                @if($employee->employee_pic != null)
                <img src="{{url($employee->employee_pic)}}" width="120px" height="120px" class="rounded-circle border-dark">
                @else
                    <img src="{{url($employee->user->avatar_original)}}" width="120px" height="120px" class="rounded-circle border-dark">
                @endif
            </td>
        </tr>
        <tr class="text-center">
            <th colspan="2">
                <b >Employee Information</b>
            </th>
        </tr>
        <tr>
            <th>নাম/Name</th>
            <td>{{$employee->user->name}}</td>
        </tr>
        <tr>
            <th>মোবাইল নাম্বার/Mobile Number</th>
            <td>{{$employee->user->phone}}</td>
        </tr>
        <tr>
            <th>ইমেইল/Email</th>
            <td>{{$employee->user->email}}</td>
        </tr>
        <tr>
            <th>লিঙ্গ/Gender</th>
            <td>{{$employee->gender}}</td>
        </tr>
        <tr>
            <th>বয়স/Age</th>
            <td>{{$employee->age}}</td>
        </tr>

        <tr>
            <th>বৈবাহিক অবস্থা/Marital State</th>
            <td>{{$employee->marital_status}}</td>
        </tr>
        <tr>
            <th>গ্রাম অথবা এলাকা/Village or Area</th>
            <td>{{$employee->village_or_area}}</td>
        </tr>
        <tr>
            <th>পোস্ট অফিস/Post Office</th>
            <td>{{$employee->union_id ? $employee->union->name: ''}}</td>

        </tr>
        <tr>
            <th>থানা/Thana</th>
            <td>{{$employee->upazila_id ? $employee->upazila->name: ''}}</td>
        </tr>
        <tr>
            <th>জেলা/District</th>
            <td>{{$employee->district_id ? $employee->district->name: ''}}</td>

        </tr>
        <tr>
            <th>বিভাগ/Division</th>
            <td>{{$employee->division_id ? $employee->division->name: ''}}</td>
        </tr>
        <tr>
            <th>এনআইডি সামনের দিক/NID Front Side</th>
            <td><img src="{{url($employee->nid_front_side ? $employee->nid_front_side: '')}}" width="80" height="80"></td>
        </tr>

        <tr>
            <th>এনআইডি পিছনের দিক/NID Back Side</th>
            <td><img src="{{url($employee->nid_back_side ? $employee->nid_back_side: '')}}" width="80" height="80"></td>
        </tr>
        <tr>
            <th>বর্তমান বেতন/Current Salary</th>
            <td>{{$employee->current_salary}}</td>
        </tr>
        <tr>
            <th>কাঙ্ক্ষিত বেতন/Expected Salary</th>
            <td>{{$employee->expected_salary}}</td>
        </tr>
        <tr>
            <th>যে কাজ খুঁজছি/Looking for Job in</th>
            <td>{{$employee->looking_job_industry_category_id ? $employee->lookingForJob->name: ''}}</td>
        </tr>
        <tr>
            <th>যোগদান/Duration for Joining</th>
            <td>{{$employee->joining_duration}}</td>
        </tr>
        <tr>
            <th rowspan="3">দক্ষতা/Expertise</th>
            <td>{{$employee->industry_employee_type_id ? $employee->industryemployeetype->name: ''}}</td>
        </tr>
        <tr>
            <td>{{$employee->industry_sub_category_id ? $employee->industrysubcategory->name: ''}}</td>
        </tr>
        <tr>
            <td>{{$employee->industry_category_id ? $employee->industrycategory->name: ''}}</td>
        </tr>
        <tr>
            <th>উক্ত দক্ষতায় অভিজ্ঞতা/Years of Experience</th>
            <td>{{$employee->experience}}</td>
        </tr>

    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-rounded btn-outline-danger" data-dismiss="modal">Close</button>
</div>
<script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
