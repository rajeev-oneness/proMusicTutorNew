@extends('layouts.auth.authMaster')
@section('title','Subscription Create')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Add Subscription
                        <a class="headerbuttonforAdd" href="{{route('admin.master.subscription.list')}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.master.subscription.save')}}" enctype="multipart/form-data">
                        @csrf
                        <h4>Basic</h4><hr>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="image" class="col-form-label">Image:</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                @error('image')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="title" class="col-form-label">Title:</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{old('title')}}">
                                @error('title')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="price" class="col-form-label">Price:</label>
                                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="Price" value="{{old('price')}}" onkeypress="return isNumberKey(event)">
                                @error('price')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="valid" class="col-form-label">Valid in Month:</label>
                                <input type="text" class="form-control @error('valid') is-invalid @enderror" id="valid" name="valid" placeholder="Valid in Months" value="{{old('valid')}}" onkeypress="return isNumberKey(event)">
                                @error('valid')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>
                        <hr>
                        <h4>Features</h4>
                        <table class="table table-sm table-hover" id="featureTable">
                            <tbody>
                                @if(old('features_title'))
                                    @for( $i = 0; $i < count(old('features_title')); $i++)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="features_title[]" placeholder="Feature title" value="{{ old('features_title.'.$i)}}">
                                            </td>
                                            <td class="align-middle text-center">
                                                @if(($i+1) == count(old('features_title')))
                                                    <a href="javascript:void(0)" class="actionbtn addNew">
                                                        <button class="btn btn-sm btn-success"><i class="fas fa-plus"></i></button>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)" class="actionbtn remove">
                                                        <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endfor
                                @else
                                    <tr>
                                        <td>
                                            {{-- <label class="col-form-label">Title:</label> --}}
                                            <input type="text" class="form-control" name="features_title[]" placeholder="Feature title">
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="javascript:void(0)" class="actionbtn addNew">
                                                <button class="btn btn-sm btn-success"><i class="fas fa-plus"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script type="text/javascript" src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).on('click','.addNew',function(){
            $('.actionbtn').removeClass('addNew').addClass('remove');
            $('.remove').empty().append('<button class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>');
            var newRow = '<tr><td><input type="text" class="form-control" name="features_title[]" placeholder="Feature title"></td><td  class="align-middle text-center"><a href="javascript:void(0)" class="actionbtn addNew"><button class="btn btn-sm btn-success"><i class="fas fa-plus"></i></button></a></td></tr>';
            $('#featureTable tr:last').after(newRow);
        });

        $(document).on('click','.remove',function(){
            $(this).closest('tr').remove();
        });
    </script>
@stop
@endsection