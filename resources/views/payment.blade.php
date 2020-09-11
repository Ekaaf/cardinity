@extends('layout.master')

@section('main_container')

<div class="box mt-3">
	<h4 class="ml-3"><b>Responses:</b></h4>
	<div class="row no-gutters align-item-center justify-content-center response">
		<p class="mb-0">
           	<b>Amount:<?php echo number_format($total,2); ?> EURO</b>   
            <br>
            <b>Transaction {{$response['status']}}</b>
            @if($response['success'] == false)
            <br>
            <b>Message: {{$response['message']}}</b>
            @endif
       	</p>
	</div>
	<div class="row no-gutters py-3">
		@if($response['success'] == false)
	    <a href="{{'cardinfo'}}" class="btn btn-info text-center w-100">Back to Payment Page</a>
	    @else
	    <a href="/" class="btn btn-info text-center w-100">Back to Mainpage</a>
	    @endif
	</div>
	
</div>

@endsection