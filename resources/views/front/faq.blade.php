@extends('layouts.master')
@section('title','How it Works')
@section('content')
    @if(count($data->faq) > 0)
        <section class="pt-5 pb-5 bg-light-blue faqs">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center title-inner">
                        <h1 class="mb-5 text-white">Frequently Asked Questions</h1>
                    </div>
                </div>
                <div>
                    <div id="accordion" class="accordion">
                        <div class="card mb-0 border-0 bg-transparent">
                            @foreach($data->faq as $key => $faq)
                                <div class="card-header collapsed" data-toggle="collapse" href="#collapseFaq{{$key}}">
                                    <a class="card-title text-white"> {{$key +1 . '. ' .$faq->title}} </a>
                                </div>
                                <div id="collapseFaq{{$key}}" class="card-body collapse {{ ($key==0) ? 'show' : '' }} p-0" data-parent="#accordion">
                                    <div class="p-4 pb-0">
                                        <p class="text-white mb-0"> {!! $faq->description !!} </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection