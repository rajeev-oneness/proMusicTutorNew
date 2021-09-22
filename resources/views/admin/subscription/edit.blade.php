@extends('layouts.auth.authMaster')
@section('title','Subscription Edit')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Subscription
                        <a class="headerbuttonforAdd" href="{{route('admin.master.subscription.list')}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.master.subscription.update',$subscription->id)}}" enctype="multipart/form-data">
                        @csrf
                        <h4>Basic</h4><hr>
                        <img src="{{asset($subscription->image)}}" height="200" width="200">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="image" class="col-form-label">Image:</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                @error('image')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="title" class="col-form-label">Title:</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{(old('title') ?? $subscription->title)}}">
                                @error('title')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="price" class="col-form-label">Price:</label>
                                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="Price" value="{{(old('price') ?? $subscription->price)}}" onkeypress="return isNumberKey(event)">
                                @error('price')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="valid" class="col-form-label">Valid in Month:</label>
                                <input type="text" class="form-control @error('valid') is-invalid @enderror" id="valid" name="valid" placeholder="Valid in Months" value="{{(old('valid') ?? $subscription->valid_for)}}" onkeypress="return isNumberKey(event)">
                                @error('valid')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>
                        <hr>
                        <h4>Features</h4>
                        <table id="featureTable">
                            <tbody>
                                <?php $countFeature = count($subscription->features); $j=0; ?>
                                @if($countFeature > 0)
                                    @foreach($subscription->features as $key => $feature)
                                        <?php $j++; ?>
                                        <tr>
                                            <td>
                                                <label class="col-form-label">Title:</label>
                                                <input type="text" class="form-control" name="features_title[]" placeholder="Features" value="{{$feature->title}}">
                                            </td>
                                            <td>
                                                @if(($j) == $countFeature)
                                                    <a href="javascript:void(0)" class="actionbtn addNew">
                                                        <span class="text-success"><i class="fas fa-plus"></i></span>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)" class="actionbtn remove">
                                                        <span class="text-danger">&#10006;</span>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            <label class="col-form-label">Title:</label>
                                            <input type="text" class="form-control" name="features_title[]" placeholder="Features">
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="actionbtn addNew">
                                                <span class="text-success"><i class="fas fa-plus"></i></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
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
            $('.remove').empty().append('<span class="text-danger">&#10006;</span>');
            var newRow = '<tr><td><label class="col-form-label">Title:</label><input type="text" class="form-control" name="features_title[]" placeholder="Features"></td><td><a href="javascript:void(0)" class="actionbtn addNew"><span class="text-success"><i class="fas fa-plus"></i></span></a></td></tr>';
            $('#featureTable tr:last').after(newRow);
        });

        $(document).on('click','.remove',function(){
            $(this).closest('tr').remove();
        });
    </script>
@stop
@endsection