<link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
<style>
    th{
        color: #212529;
    }
</style>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><b>{{$employer->user->name}}</b> Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table id="modalTbl" class="table table-bordered table-striped">

        <tr class="text-center">
            <th colspan="2">
                <b >Employer Information</b>
            </th>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{$employer->user->name}}</td>
        </tr>
        <tr>
            <th>Mobile Number</th>
            <td>{{$employer->user->phone}}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{$employer->user->email}}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{$employer->user->address}}</td>
        </tr>
        <tr class="text-center">
            <th colspan="2">
                <b >Company Information</b>
            </th>
        </tr>
        <tr>
            <th>Company Name</th>
            <td>{{$employer->seller->company_name}}</td>
        </tr>
        <tr>
            <th>Company Owner</th>
            <td>{{$employer->owner_name}}</td>
        </tr>
        <tr>
            <th>Company Contact no.</th>
            <td>{{$employer->seller->company_phone}}</td>
        </tr>
        <tr>
            <th>Company Email</th>
            <td>{{$employer->seller->company_email}}</td>
        </tr>
        <tr>
            <th>Company Address</th>
            <td>{{$employer->seller->company_address}}</td>
        </tr>

        <tr>
            <th>Looking to Hire</th>
            <td>
                @php
                    $types = json_decode($employer->industry_category_id)
                @endphp
                @if($types)
                @foreach($types as $type)
                    @php
                        $industry_category = \App\Model\IndustryCategory::find($type);
                    @endphp
                    {{$industry_category->name}},
                @endforeach
                @endif
            </td>
        </tr>
        <tr>
            <th>Number of Employees</th>
            <td>{{$employer->no_of_employee}}</td>
        </tr>
        <tr>
            <th>Salary Type</th>
            <td>{{$employer->salary_type}}</td>
        </tr>
        <tr>
            <th>Established Year</th>
            <td>{{$employer->established_year}}</td>
        </tr>
        <tr class="text-center">
            <th colspan="2">
                <b >Uploaded Documents</b>
            </th>
        </tr>
        <tr>
            <th>Trade Licence</th>
            <td>
                @if($employer->seller->trade_licence)
                <img src="{{url($employer->seller->trade_licence)}}" width="80" height="80">
                @endif
            </td>
        </tr>

        <tr>
            <th>VAT</th>
            <td>
                @if($employer->vat)
                <img src="{{url($employer->vat)}}" width="80" height="80">
                @endif
            </td>
        </tr>

        <tr>
            <th>Owner's NID (Front)</th>
            <td>
                @if($employer->owner_nid_back != null)
                <img src="{{url($employer->owner_nid_front)}}" width="80" height="80">
                @elseif($employer->seller->owner_nid_back != null)
                    <img src="{{url($employer->seller->owner_nid_front)}}" width="80" height="80">
                @endif
            </td>
        </tr>
        <tr>
            <th>Owner's NID (Back)</th>
            <td>
                @if($employer->owner_nid_back != null)
                <img src="{{url($employer->owner_nid_back)}}" width="80" height="80">
                @elseif($employer->seller->owner_nid_back != null)
                    <img src="{{url($employer->seller->owner_nid_front)}}" width="80" height="80">
                @endif
            </td>
        </tr>

        <tr>
            <th>Factory Certificates</th>
            <td>
                @if($employer->factory_certificate != null)
                <img src="{{url($employer->factory_certificate)}}" width="80" height="80">
                @endif
            </td>
        </tr>
        <tr>
            <th>Fire Licence</th>
            <td>
                @if($employer->fire_licence != null)
                <img src="{{url($employer->fire_licence)}}" width="80" height="80">
                @endif
            </td>
        </tr>
        <tr>
            <th>BTMA/BGMEA/BKMEA/Others</th>
            <td>
                @if($employer->membership_image != null)
                <img src="{{url($employer->membership_image)}}" width="80" height="80">
                @endif
            </td>
        </tr>
        <tr class="text-center">
            <th colspan="2">
                <b>Subscription Package</b>
            </th>
        </tr>
        <tr>
            <th>Package Name</th>
            <td><button class="btn btn-info">{{$employer->user->membershipPackage->package_name}}</button></td>
        </tr>
        <tr>
            <th>Package Name</th>
            <td><button class="btn btn-info">{{$employer->user->membershipPackage->package_name}}</button></td>
        </tr>
        <tr>
            @php
            $package_details = \App\Model\MembershipPackageDetail::where('membership_package_id',$employer->user->membership_package_id)->first();
            @endphp
            <th>Free SMS</th>
            <td>{{$package_details->free_sms}}</td>
        </tr>
{{--        <tr>--}}
{{--            <th>Used SMS</th>--}}
{{--            <td>--}}
{{--                --}}
{{--            </td>--}}
{{--        </tr>--}}
        <tr>
            <th>Subscription Date</th>
            <td> {{date('j M, Y', strtotime($employer->user->membership_activation_date))}}</td>
        </tr>
        <tr>
            <th>Expired Date</th>
            <td class="text-success">{{date('j M, Y', strtotime($employer->user->membership_expired_date))}}</td>
        </tr>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-rounded btn-outline-danger" data-dismiss="modal">Close</button>
</div>
<script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
