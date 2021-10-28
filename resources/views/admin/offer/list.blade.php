@extends('layouts.auth.authMaster')
@section('title','Offer List')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Offer
                        <a class="headerbuttonforAdd" href="{{route('admin.offer.create')}}">
                            <i class="fa fa-plus" aria-hidden="true"></i>Add Offer
                        </a>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SR</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Series</th>
                                    <th>Author</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($offers as $key => $offer)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td><img src="{{asset($offer->image)}}" height="100"></td>
                                        <td>{{$offer->title}}</td>
                                        <td style="width: 100px;">
                                            <p class="small mb-0 text-muted">
                                                GBP :<span class="text-dark">{{ $offer->price_gbp }}</span>
                                            </p>
                                            <p class="small mb-0 text-muted">
                                                USD :<span class="text-dark">{{ $offer->price_usd }}</span>
                                            </p>
                                            <p class="small mb-0 text-muted">
                                                EUR :<span class="text-dark">{{ $offer->price_euro }}</span>
                                            </p>
                                        </td>
                                        <td class="readMore">
                                            <p class="small mb-0 text-muted">DESCRIPTION :</p>
                                            <p class="small text-dark">{{ $offer->description }}</p>

                                            <p class="small mb-0 text-muted">OFFER DESCRIPTION :</p>
                                            <p class="small text-dark">{{ $offer->offer_description }}</p>
                                        </td>
                                        <td>
                                            <ol>
                                                @foreach($offer->offer_series as $offerseries)
                                                    <li>
                                                        <div class="media mb-3">
                                                            <img src="{{asset($offerseries->series_details->image)}}" alt="" height="50" class="mr-3">
                                                            <div class="media-body">
                                                                <p class="small text-muted mb-0">{{$offerseries->series_details->title}}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </td>
                                        <td>
                                            @if($author = $offer->author)
                                                <div class="media mb-3">
                                                    <div class="media-body">
                                                        <p class="mt-0 text-muted">{{$author->name}}</p>
                                                        <p>{{$author->email}}</p>
                                                    </div>
                                                </div>
                                            @else
                                                {{('N/A')}}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('admin.offer.edit', $offer->id)}}"><i class="fas fa-edit"></i></a>  <a href="javascript:void(0)" class="seriesDelete" data-id="{{$offer->id}}"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example4').DataTable();
        });

        $(document).on('click','.seriesDelete',function(){
            var seriesDelete = $(this);
            var productSeriesId = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Offer!",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type:'POST',
                        dataType:'JSON',
                        url:"{{route('admin.offer.delete')}}",
                        data: {id:productSeriesId,_token:'{{csrf_token()}}'},
                        success:function(data){
                            if(data.error == false){
                                seriesDelete.closest('tr').remove();
                                swal('Success',"Poof! Your Offer has been deleted!");
                            }else{
                                swal('Error',data.message);
                            }
                        }
                    });
                    
                }
            });
        });
    </script>
@stop
@endsection