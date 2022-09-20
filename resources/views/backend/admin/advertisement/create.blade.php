
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body custom-edit-service">
                <!-- Add Medicine -->
                <form role="form" class="dc-formtheme dc-userform" method="post" action="{{route('admin.advertisements.store')}}" enctype="multipart/form-data">
                    @csrf
                    <fieldset>
                        <input type="hidden" name="position" value="{{ $position }}">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="title">Advertisement Title (EN) (@lang('website.Optional')) </label>
                                <input type="text" name="title" class="form-control" placeholder="Enter Advertisement Title EN">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="title">Advertisement Title (BN) (@lang('website.Optional')) </label>
                                <input type="text" name="title" class="form-control" placeholder="Enter Advertisement Title BN">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="link">URL Link (@lang('website.Optional')) </label>
                                <input type="text" name="link" class="form-control" placeholder="Enter Page Link">
                            </div>
                        </div>

                        <div class="form-group col-7"> (@lang('website.Optional')) 
                            <label class="control-label ml-3">Image <small class="text-danger">(jpg,jpeg,png file only)</small></label>
                            <div class="ml-3 mr-3">
                                <div class="row" id="image"></div>

                            </div>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="image">Image <small>(size: 270 * 132 pixel)</small></label>--}}
{{--                            <input type="file" class="form-control" name="image" id="image" >--}}
{{--                        </div>--}}

                        <div class="form-group dc-btnarea">
                            <input type="submit" class="btn btn-info" value="Save">
                        </div>
                    </fieldset>
                </form>
                <!-- /Add Medicine -->
            </div>
        </div>
    </div>
</div>
<script src="{{asset('backend/dist/js/spartan-multi-image-picker-min.js')}}"></script>
<script>
    $("#image").spartanMultiImagePicker({
        fieldName: 'image',
        maxCount: 1,
        rowHeight: '200px',
        groupClassName: 'col-md-4 col-sm-4 col-xs-6',
        maxFileSize: '1500000',
        dropFileLabel: "Drop Here",
        onExtensionErr: function (index, file) {
            console.log(index, file, 'extension err');
            alert('Please only input png or jpg type file')
        },
        onSizeErr: function (index, file) {
            console.log(index, file, 'file size too big');
            alert('Image size too big. Please upload below 150kb');
        },
    });
</script>
