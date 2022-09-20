<div class="row" style="padding: 10px;">
    <div class="col-6">
        <h5>Action</h5>
    </div>
    <div class="col-2">
        @if($buyer->verification_status == 1)
            <a class="btn btn-danger" href="{{route('admin.buyer.status-update',$buyer->id)}}">Deactive</a>
        @else
            <a class="btn btn-success" href="{{route('admin.buyer.status-update',$buyer->id)}}">Active</a>
        @endif
    </div>
</div>
