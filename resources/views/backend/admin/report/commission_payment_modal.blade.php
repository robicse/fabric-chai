<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Pay Seller Commission</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{route('admin.commission-payment.store',$seller->id)}}" method="POST">
        @csrf
        <div class="form-group">
{{--            <div class="row">--}}
{{--                <div class="col-4">--}}
{{--                    <label class="col-form-label">Commission Amount</label>--}}
{{--                </div>--}}
{{--                <div class="col-8">--}}
{{--                    <input type="number" name="" id="commission_due_amount" value="{{$amount}}" class="form-control" disabled>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row">--}}
{{--                <div class="col-4">--}}
{{--                    <label class="col-form-label">Paid Amount <span>*</span></label>--}}
{{--                </div>--}}
{{--                <div class="col-8">--}}
{{--                    <input type="number" name="amount" id="amount" value="{{$amount}}" class="form-control" required onkeyup="ShowHideDiv2()">--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="row">
                <div class="col-4">
                    <label class="col-form-label">Commission Amount</label>
                </div>
                <div class="col-8">
                    <input type="hidden" name="invoice_code" value="{{$invoice_code}}" class="form-control">
                    <input type="number" name="amount" id="commission_due_amount" value="{{getInvoiceWiseCommissionAmount($invoice_code)}}" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <input type="radio" name="payment_with" value="Pay Manually" id="PayManually" class="shipping_method" checked style="display: none">
                    <label>Pay Manually <span>*</span></label>
                </div>
                <div class="col-8">
                    <div class="col-4">
                        <input type="radio" name="payment_type" value="Cash" id="Cash" class="payment_type" onclick="ShowHideDiv1()" checked>
                        <label>Cash</label>
                    </div>
                    <div class="col-4">
                        <input type="radio" name="payment_type" value="LC" id="LC" class="payment_type" onclick="ShowHideDiv1()">
                        <label>LC</label>
                    </div>
                    <div class="col-4">
                        <input type="radio" name="payment_type" value="Check" id="Check" class="payment_type" onclick="ShowHideDiv1()">
                        <label>cheque</label>
                    </div>
                    <div id="div_check_number" style="display: none;">
                        <div class="col-4">
                            Bank Name:
                            <input type="text" name="bank_name" id="txtBankName" />
                        </div>
                        <div class="col-4">
                            cheque Number:
                            <input type="text" name="check_number" id="txtEmail" />
                        </div>
                        <div class="col-4">
                            Dispatch Date:
                            <input type="text" name="dispatch_date" id="txtDispatchDate" />
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="col-12">&nbsp;</div>
            <div class="row">
                <div class="col-4">
                    <label>Description: <span>*</span></label>
                </div>
                <div class="col-8">
{{--                    <textarea class="form-control" name="description" required></textarea>--}}
                    <textarea name="description" id="meta_desc" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-4">
                    <label>Account Name: </label>
                </div>
                <div class="col-8">Fabric Lagbe Limited</div>
                <div class="col-4">
                    <label>A/c No.: </label>
                </div>
                <div class="col-8">1301010010590</div>
                <div class="col-4">
                    <label>Bank Name: </label>
                </div>
                <div class="col-8">Mutual Trust Bank Limited</div>
                <div class="col-4">
                    <label>Branch Name: </label>
                </div>
                <div class="col-8">Gulshan Branch</div>
                <div class="col-4">
                    <label>Branch Code: </label>
                </div>
                <div class="col-8">175261840</div>
                <div class="col-4">
                    <label>Swift Code: </label>
                </div>
                <div class="col-8">MTBLBDDHGUL</div>
                <div class="col-4">
                    <label>Routing Number: </label>
                </div>
                <div class="col-8">145261720</div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Pay</button>
        </div>
    </form>

</div>
