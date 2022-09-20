@extends('frontend.layouts.master')
@section("title","Bidder Reviews")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <!-- Main content -->
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                @include('frontend.buyer.buyer_breadcrumb')
                @include('frontend.buyer.buyer_sidebar')
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title float-left">@lang('website.Bidder Name'): {{$bidder->name}}</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Reviewer Name')</th>
                                            <th>@lang('website.Role')</th>
                                            <th>@lang('website.Ratings')</th>
                                            <th>@lang('website.Comments')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($reviews as $key => $review)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                @php
                                                    $sender = \App\User::where('id',$review->sender_user_id)->first();
                                                @endphp
                                                <td>{{ getNameByBnEn($sender) }}</td>
                                                <td>
                                                    @if(app()->getLocale() == 'en')
                                                        {{ $sender->user_type }}
                                                    @elseif($sender->user_type == 'seller')
                                                        @lang('website.Seller')
                                                    @elseif($sender->user_type == 'buyer')
                                                        @lang('website.Buyer')
                                                    @endif
                                                </td>
                                                <td>{{$review->rating}}</td>
                                                <td>{{ $review->comment }}</td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Reviewer Name')</th>
                                            <th>@lang('website.Role')</th>
                                            <th>@lang('website.Ratings')</th>
                                            <th>@lang('website.Comments')</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
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

    </script>
@endpush
