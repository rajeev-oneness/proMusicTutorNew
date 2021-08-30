@extends('layouts.master')
@section('title','Login')
@section('content')
    <div class="policy">
        <div class="content-priv">
            <h3>{{$privacy->heading}}</h3>
            {!! $privacy->description !!}
        </div>
        <div class="privacy-image">
            <img src="{{asset($privacy->image)}}">
        </div>
    </div>
@endsection
