@extends('layout.master')

@section('main_container')

<div class="box mt-3">
    <form method="post" action="{{URL::to('payment')}}" name="cardinfo_form">
    @csrf
        <h4 class="ml-3"><b>Enter Transaction Details</b></h4>

        <div class="row no-gutters">
            <input type="text" class="form-control" id="cardholder_name" name="cardholder_name" placeholder="Cardholder Name">
            @error('cardholder_name')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div class="row no-gutters">
            <input type="text" class="form-control cc-number identified" id="pan_number" name="pan_number" placeholder="Pan Number">
            @error('pan_number')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div class="row no-gutters">
            <div class="col-6 pr-2">
                <input type="text" class="form-control" id="exp_data" name="exp_data" placeholder="Exp Date">
                @error('exp_data')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-6 pl-2">
                <input type="password" class="form-control" id="cvv" name="cvv" placeholder="CVC" maxlength="4" minlength="3">
                @error('cvv')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="row no-gutters py-3">
            <button type="submit" class="btn btn-secondary text-center w-100">Pay</button>
        </div>

        <div class="row no-gutters">
            <a href="{{URL::to('cart')}}" class="btn btn-info text-center w-100">Back</a>
        </div>
    </form>
</div>

<style type="text/css">
    .error{
        color: #ff0000;
    border-color: #ff0000;
    }
    .cc-number.identified {
        background-repeat: no-repeat;
        background-position-y: 3px;
        background-position-x: 99%;
    }

.cc-number.visa {
    background-image: url(uploads/visa.png);
}
</style>
@endsection