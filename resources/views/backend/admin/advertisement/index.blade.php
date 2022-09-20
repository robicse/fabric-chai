@extends('backend.layouts.master')
@section("title","Advertisement List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#all_ads" data-toggle="tab">All Advertisement</a></li>
                <li class="nav-item"><a class="nav-link" href="#ads_1" data-toggle="tab">For Home Page</a></li>
                <li class="nav-item"><a class="nav-link" href="#ads_2" data-toggle="tab">For Employer Dashboard</a></li>
{{--                <li class="nav-item"><a class="nav-link" href="#ads_3" data-toggle="tab">For Product Details</a></li>--}}
            </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content">
                <div class="active tab-pane" id="all_ads">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">All Advertisement</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th>Title (EN)</th>
                                    <th>Title (BN)</th>
                                    <th>Image</th>
                                    <th>Link</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($advertisements as $key => $advertisement)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$advertisement->title}}</td>
                                        <td>{{$advertisement->title_bn}}</td>
                                        <td>
                                            <img src="{{url($advertisement->image)}}" width="70" height="60" alt="">
                                        </td>
                                        <td>{{$advertisement->link}}</td>
                                        <td>
                                            <a class="btn btn-info waves-effect" onclick="edit_advertisement({{$advertisement->id}})">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button class="btn btn-danger waves-effect" type="button"
                                                    onclick="deleteAd({{$advertisement->id}})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{$advertisement->id}}" action="{{route('admin.advertisements.destroy',$advertisement->id)}}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#SL</th>
                                    <th>Title (EN)</th>
                                    <th>Title (BN)</th>
                                    <th>Image</th>
                                    <th>Link</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="ads_1">
                    <section class="content">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-info card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title float-left">Advertisement 1</h3>
                                        <div class="float-right">
                                            <a onclick="add_advertisement_1()">
                                                <button class="btn btn-success">
                                                    <i class="fa fa-plus-circle"></i>
                                                    Add
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>#SL</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Link</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(\App\Model\Advertisement::where('position', 1)->latest()->get() as $key => $advertisement)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$advertisement->title}}</td>
                                                    <td>
                                                        <img src="{{url($advertisement->image)}}" width="70" height="60" alt="">
                                                    </td>
                                                    <td>{{$advertisement->link}}</td>
                                                    <td>
                                                        <a class="btn btn-info waves-effect" onclick="edit_advertisement_1({{$advertisement->id}})">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-danger waves-effect" type="button"
                                                                onclick="deleteAd({{$advertisement->id}})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                        <form id="delete-form-{{$advertisement->id}}" action="{{route('admin.advertisements.destroy',$advertisement->id)}}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#SL</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Link</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- /.tab-pane -->

                <div class="tab-pane" id="ads_2">
                    <section class="content">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-info card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title float-left">Advertisement 2</h3>
                                        <div class="float-right">
                                            <a onclick="add_advertisement_2()">
                                                <button class="btn btn-success">
                                                    <i class="fa fa-plus-circle"></i>
                                                    Add
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>#SL</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Link</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(\App\Model\Advertisement::where('position', 2)->latest()->get() as $key => $advertisement)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$advertisement->title}}</td>
                                                    <td>
                                                        <img src="{{url($advertisement->image)}}" width="70" height="60" alt="">
                                                    </td>
                                                    <td>{{$advertisement->link}}</td>
                                                    <td>
                                                        <a class="btn btn-info waves-effect" onclick="edit_advertisement_2({{$advertisement->id}})">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-danger waves-effect" type="button"
                                                                onclick="deleteAd({{$advertisement->id}})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                        <form id="delete-form-{{$advertisement->id}}" action="{{route('admin.advertisements.destroy',$advertisement->id)}}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#SL</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Link</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="ads_3">
                    <section class="content">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-info card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title float-left"> Advertisement 3</h3>
                                        <div class="float-right">
                                            <a onclick="add_advertisement_3()">
                                                <button class="btn btn-success">
                                                    <i class="fa fa-plus-circle"></i>
                                                    Add
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>#SL</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Link</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(\App\Model\Advertisement::where('position', 3)->latest()->get() as $key => $advertisement)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$advertisement->title}}</td>
                                                    <td>
                                                        <img src="{{url($advertisement->image)}}" width="70" height="60" alt="">
                                                    </td>
                                                    <td>{{$advertisement->link}}</td>
                                                    <td>
                                                        <a class="btn btn-info waves-effect" onclick="edit_advertisement_3({{$advertisement->id}})">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-danger waves-effect" type="button"
                                                                onclick="deleteAd({{$advertisement->id}})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                        <form id="delete-form-{{$advertisement->id}}" action="{{route('admin.advertisements.destroy',$advertisement->id)}}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#SL</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Link</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!-- /.tab-content -->
        </div><!-- /.card-body -->
    </div>
@endsection
@push('js')
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script>
        function add_advertisement_1(){
            $.get('{{ route('admin.advertisements.create',1)}}', {}, function(data){
                $('#ads_1').html(data);
            });
        }
        function add_advertisement_2(){
            $.get('{{ route('admin.advertisements.create',2)}}', {}, function(data){
                $('#ads_2').html(data);
            });
        }
        function add_advertisement_3(){
            $.get('{{ route('admin.advertisements.create',3)}}', {}, function(data){
                $('#ads_3').html(data);
            });
        }

        function edit_advertisement(id){
            var url = '{{ route("admin.advertisements.edit", "ads_id") }}';
            url = url.replace('ads_id', id);
            $.get(url, {}, function(data){
                $('#all_ads').html(data);
            });
        }
        function edit_advertisement_1(id){
            var url = '{{ route("admin.advertisements.edit", "ads_id") }}';
            url = url.replace('ads_id', id);
            $.get(url, {}, function(data){
                $('#ads_1').html(data);
            });
        }
        function edit_advertisement_2(id){
            var url = '{{ route("admin.advertisements.edit", "ads_id") }}';
            url = url.replace('ads_id', id);
            $.get(url, {}, function(data){
                $('#ads_2').html(data);
            });
        }

        function edit_advertisement_3(id){
            var url = '{{ route("admin.advertisements.edit", "ads_id") }}';
            url = url.replace('ads_id', id);
            $.get(url, {}, function(data){
                $('#ads_3').html(data);
            });
        }

        //sweet alert
        function deleteAd(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your Data is save :)',
                        'error'
                    )
                }
            })
        }

    </script>
@endpush
