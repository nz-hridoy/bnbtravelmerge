@extends('template')

@section('main')
<div class="margin-top-85">
    <div class="container mb-5" style="min-height: 70vh;">
        <div class="row m-0">
            <div class="col-md-12">
                <div class="card bg-white border-0">
                    <div class="card-header bg-white border-0"><h1><strong>{{ $blog->title }}</strong></h1></div>
                    <div class="card-body border-0">
                        {!! $blog->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@stop