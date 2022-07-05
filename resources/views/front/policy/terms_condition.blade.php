@extends('layouts.master')
@section('title','Login')
@section('content')
    <div class="policy align-items-start">
        <div class="content-priv px-5">
            <h3>{{$term_condition->heading}}</h3>
            {!! $term_condition->description !!}
        </div>
      <!--   <div class="privacy-image">
            <img src="{{asset($term_condition->image)}}">
        </div> -->
    </div>
@endsection
