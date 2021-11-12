@extends('layouts.app')

@section('content')
<div class="container-fluid mt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form action="https://staging-ipg.blinq.pk/Payment/PaymentProcess.aspx" method="post">
                    <input type="hidden" name="client_id" id="client_id" value="yKiKwABdhRsdDb0" />
                    <input type="hidden" name="payment_via" id="payment_via" value="BLINQ_VM" />
                    <input type="hidden" name="order_id" id="order_id" value="RGP0010921770" />
                    <input type="hidden" name="paymentcode" id="paymentcode" value="00582124600001" />
                    <input type="hidden" name="product_description" id="product_description" value="TestInvoice" />
                    <input type="hidden" name="encrypted_form_data" id="encrypted_form_data"
                    value="de7a851f7fa383108634be3ccc061728" />
                    <input type="hidden" name="return_url" id="return_url"
                    value="http://192.168.101.219:8000/order-confirmation" />
                    <button type="submit">Pay</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
