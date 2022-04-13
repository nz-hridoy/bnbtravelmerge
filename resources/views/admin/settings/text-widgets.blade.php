@extends('admin.template')
@push('css')
<link href="{{ url('public/backend/css/setting.css') }}" rel="stylesheet" type="text/css" /> 
@endpush
@section('main')
<style>
    .flash-container{
        display: none;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-3 settings_bar_gap">
                @include('admin.common.settings_bar')
            </div>
        
            <div class="col-md-9">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Home Page</h3>
                    </div>
                
                    <div class="box-body">

                        {{-- <div class="row justify-content-center">
                            <div class="col-md-12">
                                @if (session()->has('message'))
                                    <div class="alert alert-success fade in alert-dismissable text-center">{{ session('message') }} <a class="close" href="#" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                                @endif
                            </div>
                        </div> --}}

                        <form action="{{ route('postTextWidget') }}" method="POST">
                            @csrf

                            <div class="form-group row">
                                <label for="" class="col-sm-3 text-right">Top Section Title</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="s1_title" id="" value="{{ $setting->s1_title }}" placeholder="Enter title" />
                                    @error('s1_title')
                                        <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-5">
                                <label for="" class="col-sm-3 text-right">@if ($setting != '') {{ $setting->s2_title }} @endif</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="" style="font-weight: normal;">Title</label>
                                        <input type="text" class="form-control" name="s2_title" value="{{ $setting->s2_title }}" id="" placeholder="Enter title" />
                                        @error('s2_title')
                                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="" style="font-weight: normal;">Description</label>
                                        <textarea type="text" class="form-control" style="height: 120px;" name="s2_text" id="" placeholder="Enter description">{{ $setting->s2_text }}</textarea>
                                        @error('s2_text')
                                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3 text-right">@if ($setting != '') {{ $setting->s3_title }} @endif</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="" style="font-weight: normal;">Title</label>
                                        <input type="text" class="form-control" name="s3_title" value="{{ $setting->s3_title }}" id="" placeholder="Enter title" />
                                        @error('s3_title')
                                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="" style="font-weight: normal;">Description</label>
                                        <textarea type="text" class="form-control" style="height: 120px;" name="s3_text" id="" placeholder="Enter description">{{ $setting->s3_text }}</textarea>
                                        @error('s3_text')
                                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3 text-right">@if ($setting != '') {{ $setting->s4_title }} @endif</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="" style="font-weight: normal;">Title</label>
                                        <input type="text" class="form-control" name="s4_title" value="{{ $setting->s4_title }}" id="" placeholder="Enter title" />
                                        @error('s4_title')
                                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="" style="font-weight: normal;">Description</label>
                                        <textarea type="text" class="form-control" style="height: 120px;" name="s4_text" id="" placeholder="Enter description">{{ $setting->s4_text }}</textarea>
                                        @error('s4_text')
                                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3 text-right">@if ($setting != '') {{ $setting->s5_title }} @endif</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="" style="font-weight: normal;">Title</label>
                                        <input type="text" class="form-control" name="s5_title" value="{{ $setting->s5_title }}" id="" placeholder="Enter title" />
                                        @error('s5_title')
                                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="" style="font-weight: normal;">Description</label>
                                        <textarea type="text" class="form-control" style="height: 120px;" name="s5_text" id="" placeholder="Enter description">{{ $setting->s5_text }}</textarea>
                                        @error('s5_text')
                                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3 text-right">@if ($setting != '') {{ $setting->s6_title }} @endif</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="" style="font-weight: normal;">Title</label>
                                        <input type="text" class="form-control" name="s6_title" value="{{ $setting->s6_title }}" id="" placeholder="Enter title" />
                                        @error('s6_title')
                                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="" style="font-weight: normal;">Description</label>
                                        <textarea type="text" class="form-control" style="height: 120px;" name="s6_text" id="" placeholder="Enter description">{{ $setting->s6_text }}</textarea>
                                        @error('s6_text')
                                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3 text-right"></label>
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-info btn-space">Submit</button>
                                    <a class="btn btn-danger" href="{{ url('admin/settings') }}">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection