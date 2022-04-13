@extends('template')

@section('main')
<div class="margin-top-85">
    <div class="container" style="min-height: 70vh;">
        <div class="row m-0">
            @foreach ($blogs as $item)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body p-0">
                            <img src="{{ asset('public/front/images/blogs') }}/{{ $item->image }}" class="img-fluid" style="height: 240px;" alt="">
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('home.blogPost',['slug'=>$item->slug]) }}"><h2><strong>{{ $item->title }}</strong></h2></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
</div>
@stop