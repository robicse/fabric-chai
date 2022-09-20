@extends('backend.layouts.master')
@section("title","Seller List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Seller List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Seller List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">Seller Lists</h3>
                        <div class="float-right">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Reg Date</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Verification Status</th>
                                <th>Reg By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sellerInfos as $key => $seller)
                                @if($seller->user)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{date('d M Y',strtotime($seller->created_at))}}</td>
                                        <td>
                                            {{$seller->user->name}}
                                            @if($seller->user->verification_code != null && $seller->user->banned == 1)
                                                <strong class="badge badge-danger">Banned</strong>
                                            @endif
                                        </td>
                                        <td>{{$seller->user->phone}}</td>
                                        <td>
                                            <span class="btn btn-{{$seller->verification_status == 0 ? 'info' : 'success'}}">{{$seller->verification_status == 0 ? 'Applied' : 'Approved'}}</span>
                                        </td>
                                        <td>
                                            @if($seller->user->verification_code != null && $seller->user->banned == 0)
                                                <div class="form-group col-md-2">
                                                    <label class="switch" >
                                                        <input onchange="verification_status(this)" value="{{$seller->id }}" {{$seller->verification_status == 1? 'checked':''}} type="checkbox" >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            @elseif($seller->user->verification_code == null)
                                                <strong class="badge badge-danger w-100">Deactivated</strong>
                                            @else
                                                <strong class="badge badge-danger w-100">Banned</strong>
                                            @endif
                                        </td>
                                        <td>{{$seller->user->reg_by}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="bg-dark dropdown-item" href="{{route('admin.seller.profile.show',encrypt($seller->user->id))}}">
                                                        <i class="fa fa-user"></i> Profile
                                                    </a>
                                                    @if($seller->user->verification_code != null && $seller->user->banned != 1)
                                                        <a class=" dropdown-item " href="#" onclick="confirm_ban('{{route('admin.buyer.ban', $seller->user_id)}}');"> Ban this Seller <i class="fa fa-ban text-danger" aria-hidden="true"></i> </a>
                                                    @elseif($seller->user->verification_code == null)
                                                        <a class=" dropdown-item" href="#" onclick="confirm_activate('{{route('admin.buyer.activate', $seller->user_id)}}');"><i class="fa fa-check text-success" aria-hidden="true"></i> Activate this Seller </a>
                                                    @else
                                                        <a class=" dropdown-item" href="#" onclick="confirm_unban('{{route('admin.buyer.ban', $seller->user_id)}}');"> Unban this Seller <i class="fa fa-check text-success" aria-hidden="true"></i></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#SL</th>
                                <th>Reg Date</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Verification Status</th>
                                <th>Reg By</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal html start--}}
        {{--        <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
        {{--            <div class="modal-dialog">--}}
        {{--                <div class="modal-content" id="modal-content">--}}

        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </section>
    <div class="modal fade" id="confirm-ban" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header" style="background-color: #0871b8">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >×</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>

                <div class="modal-body">
                    <p>Do you really want to ban this Seller?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a id="confirmation" class="btn btn-danger btn-ok">Proceed!</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-unban" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header" style="background-color: #0871b8">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>

                <div class="modal-body">
                    <h5>Do you really want to unban this Seller?</h5>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a id="confirmationunban" class="btn btn-success btn-ok">Proceed!</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm-active" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header" style="background-color: #0871b8">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>

                <div class="modal-body">
                    <h5>Do you really want to activate this Seller?</h5>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a id="confirmationactivate" class="btn btn-success btn-ok">Proceed!</a>
                </div>
            </div>
        </div>
    </div>

@stop
@push('js')
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
        function confirm_ban(url)
        {
            $('#confirm-ban').modal('show', {backdrop: 'static'});
            document.getElementById('confirmation').setAttribute('href' , url);
        }

        function confirm_unban(url)
        {
            $('#confirm-unban').modal('show', {backdrop: 'static'});
            document.getElementById('confirmationunban').setAttribute('href' , url);
        }
        function confirm_activate(url)
        {
            $('#confirm-active').modal('show', {backdrop: 'static'});
            document.getElementById('confirmationactivate').setAttribute('href' , url);
        }

        function verification_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('admin.seller.verification') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    toastr.success('success', 'Verification Status updated successfully');
                    location.reload();
                }
                else{
                    toastr.error( 'Verification Status disabled successfully');
                }
            });
        }
    </script>
@endpush
