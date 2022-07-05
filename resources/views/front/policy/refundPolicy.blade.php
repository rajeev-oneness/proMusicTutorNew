@extends('layouts.master')
@section('title','Login')
@section('content')
    <div class="policy align-items-center">
        <div class="content-priv">
            <h3>{{$refundPolicy->heading}}</h3>
            {!! $refundPolicy->description !!}
        </div>
        <div class="privacy-image">
            <img src="{{asset($refundPolicy->image)}}">
        </div>
    </div>
@endsection
