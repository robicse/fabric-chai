<div class="modal-header">
    <h5 class="modal-title" id="staticBackdropLabel">Job Experience Edit</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="{{route('employee.job-experience-update')}}" method="POST">
        @csrf
        @php
            $y = date('Y');
        @endphp
        <div class="row" >
            <input type="hidden" name="id" value="{{$employeeJob->id}}">
            <div class="col-lg-6 col-md-6 col-12" >
                <label for="designation">Designation<span class="required">*</span></label>
                <input type="text" class="form-control" name="designation" value="{{$employeeJob->designation}}" style="background-color: white">
            </div>
            <div class="col-lg-6 col-md-6 col-12" >
                <label for="company_name">Company Name<span class="required">*</span></label>
                <input type="text" class="form-control" name="company_name" value="{{$employeeJob->company_name}}" style="background-color: white">
            </div>
            <div class="col-lg-6 col-md-6 col-12" >
                <label for="start_year">Start Year<span class="required">*</span></label>
                <select name="start_year" class="form-control demo-select2" style="background-color: white">
                    <option value="">Select</option>
                    @for($i=$y;$i >= 1990; $i--)
                        <option value="{{$i}}" {{$employeeJob->start_year == $i ? 'selected':''}}>{{$i}}</option>
                    @endfor
                </select>
            </div>
            <div class="col-lg-6 col-md-6 col-12" >
                <label for="end_year">End Year<span class="required">*</span></label>
                <select name="end_year" class="form-control demo-select2" style="background-color: white">
                    <option value="">Select</option>
                    <option value="Current" {{$employeeJob->end_year == 'Current' ? 'selected' : ''}}>Current</option>
                    @for($i=$y;$i >= 1990; $i--)
                        <option value="{{$i}}" {{$employeeJob->end_year == $i ? 'selected':''}}>{{$i}}</option>
                    @endfor
                </select>
            </div>
            <div class="col-lg-6 col-md-6 col-12" >
                <label for="response">Response</label>
                <textarea name="response" rows="3" class="form-control" style="background-color: white">{!! $employeeJob->response !!}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-info">Save</button>
        </div>
    </form>
</div>
