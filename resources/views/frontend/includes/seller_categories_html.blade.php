<div id="buyer_selected_category" class="col-md-12">
    <label for="category_1">@lang('website.Select your Product willing to sell') <span class="required">*</span> </label>
    <select name="category_1" id="category_id" class="form-control demo-select2 bg-gray-light" required>
        <option selected disabled>@lang('website.Select')</option>
        @foreach(\App\Model\Category::all() as $category)
            <option value="{{$category->id}}">{{getNameByBnEn($category)}}</option>
        @endforeach
    </select>
</div>
<div class="mt-3 col-md-12" id="buyer_category_2">
    <select name="category_2" id="sub_category_id" class="form-control demo-select2">

    </select>
</div>
<div class="mt-3 col-md-12" id="buyer_category_3" >
    <select name="category_3" id="sub_sub_category_id" class="form-control demo-select2">

    </select>
</div>
<div class="mt-3 col-md-12" id="buyer_category_4" >
    <select name="category_4" id="sub_sub_child_category_id" class="form-control demo-select2">

    </select>
</div>
<div class="mt-3 col-md-12" id="buyer_category_5" >
    <select name="category_5" id="sub_sub_child_child_category_id" class="form-control demo-select2">

    </select>
</div>
<div class="mt-3 col-md-12" id="buyer_category_6" >
    <select name="category_6" id="category_six_id" class="form-control demo-select2">

    </select>
</div>
<div class="mt-3 col-md-12" id="buyer_category_7" >
    <select name="category_7" id="category_seven_id" class="form-control demo-select2">

    </select>
</div>
<div class="mt-3 col-md-12" id="buyer_category_8" >
    <select name="category_8" id="category_eight_id" class="form-control demo-select2">

    </select>
</div>
<div class="mt-3 col-md-12" id="buyer_category_9" >
    <select name="category_9" id="category_nine_id" class="form-control demo-select2">

    </select>
</div>
<div class="mt-3 col-md-12" id="buyer_category_10" >
    <select name="category_10" id="category_ten_id" class="form-control demo-select2">

    </select>
</div>

