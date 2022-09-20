<div class="modal-header">
    <h5 class="modal-title" id="staticBackdropLabel">Education Edit</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="{{route('employee.education-update')}}" method="POST">
        @csrf
        @php
            $y = date('Y');
        @endphp
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12" >
                <label for="degree">Level of Education<span class="required">*</span></label>
                <select class="form-control levels" name="level" id="level_2" onchange="getDegree2()" style="background-color: white">
                    @foreach(\App\Model\EducationLevel::all() as $educationLevel)
                        <option value="{{$educationLevel->name}}" {{$education->level == $educationLevel->name ? 'selected':''}}>{{$educationLevel->name}}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="education_id" id="ed_id" value="{{$education->id}}">
            <input type="hidden" id="ed_degree_{{$education->id}}" value="{{$education->degree}}">
            <div class="col-lg-6 col-md-6 col-12" >
                <label for="degree">Degree<span class="required">*</span></label>
                <select class="form-control" name="degree" id="degree_2" style="background-color: white">

                </select>
            </div>
            <div class="col-lg-6 col-md-6 col-12" >
                <label for="institute">Institute<span class="required">*</span></label>
                <input type="text" class="form-control" name="institute" value="{{$education->institute}}" style="background-color: white">
            </div>

            <div class="col-lg-6 col-md-6 col-12" >
                <label for="passing_year">Passing Year<span class="required">*</span></label>
                <select name="passing_year" class="form-control demo-select2" style="background-color: white">
                    <option value="">Select</option>
                    @for($i=$y;$i >= 1990; $i--)
                        <option value="{{$i}}" {{$education->passing_year == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
                </select>
            </div>
            <div class="col-lg-6 col-md-6 col-12" >
                <label for="group">Group<span class="required">*</span></label>
                <input type="text" class="form-control" name="group" value="{{$education->group}}" style="background-color: white">
            </div>
            <div class="col-lg-6 col-md-6 col-12" >
                <label for="result">Result<span class="required">*</span></label>
                <input type="text" class="form-control" name="result" value="{{$education->result}}" style="background-color: white">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-info">Save</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        getDegree2();
    })
    function getDegree2(){
        var ed_id = $('#ed_id').val();
        var degree_name = $('#level_2').val();
        var ed_degree = $('#ed_degree_'+ed_id).val();

        $.post('{{ route('get_education_degree') }}', {
            _token: '{{ csrf_token() }}',
            degree_name: degree_name
        }, function (data) {
            $('#degree_2').html(null);

            for (var i = 0; i < data.length; i++) {
                $('#degree_2').append($('<option>', {
                    value: data[i].name,
                    text: data[i].name
                }));
            }
            $("#degree_2 > option").each(function() {
                if(this.value == ed_degree){
                    $('#degree_2').val(this.value).change();
                }
            });
        });

    }
</script>
