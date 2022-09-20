<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body custom-edit-service">
                <!-- Add Medicine -->
                <form role="form" class="dc-formtheme dc-userform" method="post" action="{{route('admin.advertisements.update',$advertisement->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <fieldset>
                        <div class="form-group col-md-6">
                            <label for="title">Advertisement Name</label>
                            <input type="text" name="title" class="form-control" value="{{$advertisement->title}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="title_bn">Advertisement Title (BN) (@lang('website.Optional')) </label>
                            <input type="text" name="title_bn" class="form-control" value="{{$advertisement->title_bn}}" >
                        </div>

                        <div class="form-group col-md-7">
                            <label class="control-label ml-3">Image (@lang('website.Optional')) <small class="text-danger">(jpg,jpeg,png file only)</small></label>
                            <div class="ml-3 mr-3">
                                <div class="row" id="image">
                                    @if ($advertisement->image != null)
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="img-upload-preview">
                                                <img loading="lazy"  src="{{ url($advertisement->image) }}" alt="" class="img-responsive">
                                                <input type="hidden" name="previous_image" value="{{ $advertisement->image }}">
                                                <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="row" id="image"></div>

                            </div>
                        </div>
                        {{--                        <img src="{{url($advertisement->image)}}" width="80" height="50" alt="">--}}
                        {{--                        <div class="form-group">--}}
                        {{--                            <label for="image">Image <small>(size: 270 * 132 pixel)</small></label>--}}
                        {{--                            <input type="file" class="form-control" name="image" id="image" value="{{$advertisement->image}}" >--}}
                        {{--                        </div>--}}
                        <div class="form-group">
                            <label for="link">Link (@lang('website.Optional')) </label>
                            <input type="text" name="link" class="form-control" value="{{$advertisement->link}}">
                        </div>
                        <div class="form-group dc-btnarea">
                            <input type="submit" class="btn btn-info" value="Update">
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
    $('.remove-files').on('click', function(){
        $(this).parents(".col-md-4").remove();
    });
</script>

