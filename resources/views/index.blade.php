@extends('layout.master')

@section('main_container')

<div class="box mt-3">    
    <h4 class="ml-3"><b>List of Products</b></h4>
    <ul class="list-group px-2">
        @foreach($products as $product)
        <li class="list-group-item">
            <div class="row">
                <div class="product-info">
                    {{$product->name}}<br>
                    {{$product->price_unit}}
                </div>
                <div class="float-right add_product" data-id="{{$product->id}}" data-price="{{$product->price}}">
                    <i class="fas fa-plus-circle fa-3x cursor-pointer"></i>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>

<div id="mySidenav" class="sidenav">
    <div class="row no-gutters justify-content-end">
        <button onclick="closeNav()" type="button" class="float-right">Close</button>
    </div>
    <br>
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
    <div class="row no-gutters px-2 mt-2">
        <div class="col-6">
            Number of Items: <span id="items_cart"> @if(isset($sessionData)) {{$sessionData['totalNumber']}} @else 0 @endif  </span>    
        </div>
        <div class="col-6">
            Total Price: <span id="amount_cart">@if(isset($sessionData)) {{$sessionData['totalPrice']}} @else 0 @endif </span>{{$products[0]->currency}}    
        </div>
    </div>
    <div class="row no-gutters mt-2">
      <a href="{{URL::to('cart')}}" class="btn btn-secondary text-center w-100 <?php if(!isset($sessionData)) echo 'disbale-event'; ?>" id="place_order">Place Order</a>
    </div>
</div>


<div class="product-bag" onclick="openNav()" id="cart_open">
    <div class="row no-gutters justify-content-center d-none d-sm-block">
        <i class="fas fa-shopping-bag fa-3x cursor-pointer"></i>
    </div>
    <span id="items">@if(isset($sessionData)) {{$sessionData['totalNumber']}} @else 0 @endif </span>items
    <br>
    <span id="amount">@if(isset($sessionData)) {{$sessionData['totalPrice']}} @else 0 @endif  </span>{{$products[0]->currency}}
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