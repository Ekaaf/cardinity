@extends('layout.master')

@section('main_container')

<div class="box mt-3">
    <h4 class="ml-3"><b>List of Products</b></h4>
    <ul class="list-group" id="cart_div">
        @if(isset($sessionData))
        @foreach($sessionData['productsCart'] as $cart)
       <li class="list-group-item">
            <div class="row no-gutters d-flex align-items-center">
                <div class="col-1 text-center">
                    {{$cart['quantity']}}
                </div>
                <div class="col-1 text-center">
                    <i class="fas fa-chevron-up cursor-pointer" onclick="updateQuantity('{{$cart['id']}}', '{{$cart['price']}}', 'increase');"></i>
                    <br>
                    <i class="fas fa-chevron-down cursor-pointer" onclick="updateQuantity('{{$cart['id']}}', '{{$cart['price']}}', 'decrease');"></i>
                </div>
                <div class="col-6 text-center">
                    {{$cart['name']}}
                </div>
                <div class="col-3 text-center">
                    {{$cart['itemTotalPrice']}}
                </div>
                <div class="col-1 text-center cursor-pointer" onclick="removeItem('{{$cart['id']}}', '{{$cart['price']}}');">
                    x
                </div>
            </div>
        </li>
        @endforeach
        @endif
    </ul>
    <div class="row no-gutters ml-3">
        Total Price: <span id="amount_cart">@if(isset($sessionData)) {{$sessionData['totalPrice']}} @else 0 @endif </span>&nbspEuro
    </div>
    <div class="row no-gutters py-3 px-1">
        <a href="{{URL::to('cardinfo')}}" class="btn btn-secondary text-center w-100 <?php if(!isset($sessionData)) echo 'disbale-event'; ?>" id="buy">Buy</a>
    </div>

    <div class="row no-gutters px-1">
        <a href="{{URL::to('/')}}" class="btn btn-info text-center w-100" >Back</a>
    </div>
</div>


@endsection

@section('page_bottom_js')
@if(isset($sessionData))
<script type="text/javascript">
    items = {!! $sessionData['items'] !!};
    totalPrice = {{$sessionData['totalPrice']}};
    itemNumber = {{$sessionData['totalNumber']}};
</script>
@endif
@endsection