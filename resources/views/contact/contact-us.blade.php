@extends('template')

@section('main')
<div class="margin-top-85 mb-5">
    <div class="container" style="min-height: 70vh;">
        <div class="row m-0 justify-content-center">
            <div class="col-md-6">
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h1 style="font-size: 40px;"><strong>Contact Us</strong></h1>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success text-center">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                
                <form action="{{ route('home.sendContactMsg') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Full Name</label>
                        <input type="text" name="full_name" class="form-control" placeholder="Enter your name" required />
                    </div>

                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required />
                    </div>

                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Subject</label>
                        <input type="text" name="subject" class="form-control" placeholder="Enter subject" required />
                    </div>

                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Your message</label>
                        <textarea name="message" class="form-control" placeholder="Enter your message" required style="min-height: 150px;"></textarea>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn vbtn-outline-success text-14 font-weight-700 p-0 mt-2 pl-4 pr-4">
                            <p class="p-3 mb-0">{{trans('Send Message')}}</p>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
@stop