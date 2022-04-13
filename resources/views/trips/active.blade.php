@extends('template')

@section('main')
<div class="margin-top-85">
	<div class="row m-0">
		@include('users.sidebar')
		<div class="col-lg-10">
			<div class="main-panel">
				<div class="container-fluid min-height">
					<div class="row">
						<div class="col-md-12 p-0 mb-3">
							<div class="list-bacground mt-4 rounded-3 p-4 border">
							<span class="text-18 pt-4 pb-4 font-weight-700">
								{{trans('messages.users_dashboard.my_trips')}}
							</span>

							<div class="float-right">
								<div class="d-flex">
									<div class="pr-4">
										<span class="text-14 pt-2 pb-2 font-weight-700">{{trans('messages.users_dashboard.sort_by')}}</span>
									</div>

									<div>
										<form action="{{url('/trips/active')}}" method="POST" id="my-trip-form">
											{{ csrf_field() }}
											<select class="form-control room-list-status text-14 minus-mt-6" name="status" id="trip_select">
												<option value="All" {{ $status == "All" ? ' selected="selected"' : '' }}>All</option>
												<option value="Current" {{ $status == "Current" ? ' selected="selected"' : '' }}>Current</option>
												<option value="Upcoming" {{ $status == "Upcoming" ? ' selected="selected"' : '' }}>Upcoming</option>
												<option value="Pending" {{ $status == "Pending" ? ' selected="selected"' : '' }}>Pending</option>
												<option value="Completed" {{ $status == "Completed" ? ' selected="selected"' : '' }}>Completed</option>
												<option value="Expired" {{ $status == "Expired" ? ' selected="selected"' : '' }}>Expired</option>
											</select>
										</form>
									</div>
								</div>
							</div>
							</div>
						</div>
					</div>
					@if(Session::has('message'))
					<div class="alert alert-success text-center" role="alert" id="alert">
                        <span id="messages">{{ Session::get('message') }}</span>
                    </div>
                    @endif
					@forelse($bookings as $booking)
						<?php 
                            if ($booking->created_at < $yesterday && $booking->status != 'Paid') {

                                $booking->status = 'Expired';
                            }
                        ?>

						<div class="row border border p-2  rounded-3 mt-4">
							<div class="col-md-3 col-xl-4 p-2">
                                <div class="img-event">
                                    <a href="{{ url('/') }}/properties/{{ $booking->properties->slug }}">
                                        <img class="room-image-container200 rounded" src="{{ $booking->properties->cover_photo }}" alt="cover_photo">
                                    </a>  
                                </div>
							</div>
							
							<div class="col-md-9 col-xl-8 pl-2">
								<div class="row m-0 pr-4">
									<div class="col-10 col-sm-9 p-0">
										<a href="{{ url('/') }}/properties/{{ $booking->properties->slug}}">
											<p class="mb-0 text-18 text-color font-weight-700 text-color-hover pr-2">{{ $booking->properties->name}} </p>     
										</a>
									</div>

									<div class="col-2 col-sm-3">
										<span class="badge vbadge-success text-13 mt-3 p-2 {{ $booking->status}}">{{ $booking->status}}</span>
									</div>
								</div>

								<div class="d-flex justify-content-between ">
									<div>
										<p class="text-14 text-muted mb-0">
											<i class="fas fa-map-marker-alt"></i>
											{{ $booking->properties->property_address->address_line_1 }}
										</p>
										<p class="text-14 mt-3"> 
											<i class="fas fa-calendar"></i> {{ date(' M d, Y', strtotime($booking->start_date)) }}  -  {{ date(' M d, Y', strtotime($booking->end_date)) }}
										</p>
		
										<p class="text-14 mt-3">
											<span class="{{$booking->status == 'Paid' ? '' : 'd-none' }}">
												<a href="{{ url('/') }}/booking/receipt?code={{ $booking->code }}">
													<i class="fas fa-receipt"></i> {{trans('messages.trips_active.view_receipt')}}
												</a>
												@if ($booking->disputed_at == '')
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#dispute-booking-modal" id="dispute_btn" data-bookingg_id="{{ $booking->id }}" style="margin-left: 5px;">
                                                    <i class="fas fa-undo"></i> {{ trans('Dispute') }}
                                                @else
                                                    <a href="javascript:void(0)" style="margin-left: 5px;">
                                                    <i class="fas fa-check"></i> {{ trans('Disputed') }}
                                                @endif
											</span>

											<a href="{{ url('/') }}/booking_payment/{{ $booking->id }}" style="@if($booking->status != 'Processing') display: none; @endif">
												<i class="fab fa-cc-amazon-pay"></i>  Make {{trans('messages.payment.payment')}}
											</a>

											<span class="">
												@if ($booking->cancelled_at != '')
													<i class="fa fa-check ml-2"></i> Cancelled
                                                @else
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#cancel-trip-modal" id="cancel_trip_btn" data-booking_cancel_id="{{ $booking->id }}" class="ml-2">
														<i class="fa fa-times"></i> Cancel Trip
													</a>
                                                @endif
												
											</span>

										</p>
									</div>

									<div class="pr-2 mt-5 mt-sm-0">
										<div class="align-self-center  mt-sm-0 w-100">
											<div class="row justify-content-center">
												<div class='img-round '>
													<a href="{{ url('/') }}/users/show/{{ $booking->host_id}}">
														<img src="{{ $booking->host->profile_src }}" alt="{{ $booking->host->first_name }}" class="rounded-circle img-70x70" onerror="this.onerror=null;this.src='{{ asset('public/images/placeholderuser.jpg') }}';">
													</a>
												</div>
											</div>

											<p class="text-center font-weight-700 mb-0">
												<a href="{{ url('/') }}/users/show/{{ $booking->host_id}}" class="text-color text-color-hover">
													{{ $booking->host->first_name}}
												</a>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					@empty
						<div class="row jutify-content-center position-center w-100 p-4 mt-4 ">
							<div class="text-center w-100">
								<img src="{{ url('public/img/unnamed.png')}}" alt="notfound" class="img-fluid">
								<p class="text-center"> {{trans('messages.message.empty_tripts')}} </p>
							</div>
						</div>
					@endforelse 

					<div class="row justify-content-between overflow-auto pb-3 mt-4 mb-5">
						{{ $bookings->appends(request()->except('page'))->links('paginate')}}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade mt-5 modal-z-index" id="dispute-booking-modal" tabindex="-1" role="dialog" aria-labelledby="dispute-booking-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="w-100 pt-3">
                            <h4 class="modal-title text-20 text-center font-weight-700">Dispute Booking</h4>
                        </div>
                            
                        <div>
                            <button type="button" class="close text-28 mr-2 filter-cancel font-weight-500" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div> 
                    </div>
    
                    <div class="modal-body p-4">
                        <form accept-charset="UTF-8" action="{{ url('booking/dispute') }}" id="dispute_reservation_form" method="post" name="dispute_reservation_form">
                            {{ csrf_field() }}
                            <input type="hidden" name="bookingg_id" id="bookingg_id" />
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="cancel_message" class="row-space-top-2">
                                        {{ trans('Dispute reason') }}
                                    </label>
                                    <textarea class="form-control" id="dispute_message" name="dispute_message" rows="4"></textarea>
                                </div>
    
                                <div class="col-md-12">
                                    <div class="row mt-4">
                                        <div class="col-sm-1 p-0">
                                            <input id="tos_confirm" name="tos_confirm" type="checkbox" value="1">
                                        </div>
    
                                        <div class="col-sm-11 p-0 text-16 text-justify">
                                            <label class="label-inline" for="tos_confirm">{{ trans('messages.booking_detail.check_box_agree') }} <br><a href="{{ url('/') }}/host_guarantee" target="_blank" class="font-weight-700">{{ trans('messages.booking_detail.guarantee_term_condition') }}</a> <br><a href="{{ url('/') }}/guest_refund" target="_blank" class="font-weight-700">{{ trans('messages.booking_detail.refund_policy_term') }}</a>, {{ trans('messages.booking_detail.and') }} and <a href="{{ url('/') }}/terms_of_service" target="_blank" class="font-weight-700">{{ trans('messages.booking_detail.term_of_service') }}</a>.</label>
                                        </div>
                                    </div>  
                                </div>
                                
                                <div class="col-md-12 text-right mt-4">
                                    <input type="hidden" name="decision" value="accept">
    
                                    <button type="button" class="btn btn-outline-danger text-16 font-weight-700 pl-5 pr-5 pt-2 pb-2 pl-5 pr-5 mt-4 ml-2" data-dismiss="modal">{{trans('messages.booking_detail.close')}}</button>
    
                                    <button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-2 pb-2 pl-5 pr-5 mt-4 mr-2" id="accept_submit" name="commit"> <i class="spinner fa fa-spinner fa-spin d-none" id="accept_spinner" ></i>
                                    <span id="accept_btn-text">{{trans('Dispute')}}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>

	<div class="modal fade mt-5 modal-z-index" id="cancel-trip-modal" tabindex="-1" role="dialog" aria-labelledby="dispute-booking-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="w-100 pt-3">
                            <h4 class="modal-title text-20 text-center font-weight-700">Cancel Trip</h4>
                        </div>
                            
                        <div>
                            <button type="button" class="close text-28 mr-2 filter-cancel font-weight-500" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div> 
                    </div>
    
                    <div class="modal-body p-4">
                        <form accept-charset="UTF-8" action="{{ url('trips/guest_cancel') }}" id="cancel_reservation_form" method="post" name="cancel_reservation_form">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" id="booking_cancel_id" />
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="cancel_message" class="row-space-top-2">
                                        {{ trans('Your message for host') }}
                                    </label>
                                    <textarea class="form-control" id="cancel_message" name="cancel_message" rows="4"></textarea>
                                </div>
    
                                <div class="col-md-12">
                                    <div class="row mt-4">
                                        <div class="col-sm-1 p-0">
                                            <input id="tos_confirm_cancel" name="tos_confirm_cancel" type="checkbox" value="1">
                                        </div>
    
                                        <div class="col-sm-11 p-0 text-16 text-justify">
                                            <label class="label-inline" for="tos_confirm_cancel">{{ trans('messages.booking_detail.check_box_agree') }} <br><a href="{{ url('/') }}/host_guarantee" target="_blank" class="font-weight-700">{{ trans('messages.booking_detail.guarantee_term_condition') }}</a> <br><a href="{{ url('/') }}/guest_refund" target="_blank" class="font-weight-700">{{ trans('messages.booking_detail.refund_policy_term') }}</a>, {{ trans('messages.booking_detail.and') }} and <a href="{{ url('/') }}/terms_of_service" target="_blank" class="font-weight-700">{{ trans('messages.booking_detail.term_of_service') }}</a>.</label>
                                        </div>
                                    </div>  
                                </div>
                                
                                <div class="col-md-12 text-right mt-4">
                                    <input type="hidden" name="decision" value="accept">

                                    <button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-2 pb-2 pl-5 pr-5 mt-4 mr-2" id="cancel_submit" name="commit"> <i class="spinner fa fa-spinner fa-spin d-none" id="cancel_spinner" ></i>
                                    	<span id="cancel_btn-text">{{trans('Cancel')}}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{ url('public/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
        $(document).on('change', '#trip_select', function(){

            $("#my-trip-form").trigger("submit"); 
              
        });
    </script>
<script>
	$(document).on('click','#accept_submit',function(){
		if($("#tos_confirm").prop('checked') == true){
				return true;           
		}else{
			alert("{{ __('messages.jquery_validation.accept_terms_conditions') }}");
			return false;
		}
	});

	$(document).on('click','#cancel_submit',function(){
		if($("#tos_confirm_cancel").prop('checked') == true){
				return true;           
		}else{
			alert("{{ __('messages.jquery_validation.accept_terms_conditions') }}");
			return false;
		}
	});

	$(document).on('click','#dispute_btn',function(){
		var bookingg_id = $(this).data('bookingg_id');

		$('#bookingg_id').val(bookingg_id);
	});
	$(document).on('click','#cancel_trip_btn',function(){
		var bookingg_id = $(this).data('booking_cancel_id');

		$('#booking_cancel_id').val(bookingg_id);
	});
</script>

<script type="text/javascript">
	$(document).ready(function () {
		$('#dispute_reservation_form').validate({
			rules: {
				tos_confirm: {
					required: true
				},
				dispute_message: {
					required: true
				}
			},
			submitHandler: function(form)
			{
				$("#accept_submit").on("click", function (e)
				{	
					$("#accept_submit").attr("disabled", true);
					e.preventDefault();
				});

				$("#accept_spinner").removeClass('d-none');
				$("#accept_btn-text").text("{{trans('Dispute')}} ..");
				return true;

			},
			messages: {
				tos_confirm: {
					required:  "{{ __('messages.jquery_validation.required') }}",
				},
				dispute_message: {
					required:  "{{ __('messages.jquery_validation.required') }}",
				}
			}
		});


		$('#cancel_reservation_form').validate({
			rules: {
				tos_confirm_cancel: {
					required: true
				},
				cancel_message: {
					required: true
				}
			},
			submitHandler: function(form)
			{
				$("#cancel_submit").on("click", function (e)
				{	
					$("#cancel_submit").attr("disabled", true);
					e.preventDefault();
				});

				$("#cancel_spinner").removeClass('d-none');
				$("#cancel_btn-text").text("{{trans('Cancel')}} ..");
				return true;

			},
			messages: {
				tos_confirm_cancel: {
					required:  "{{ __('messages.jquery_validation.required') }}",
				},
				cancel_message: {
					required:  "{{ __('messages.jquery_validation.required') }}",
				}
			}
		});
	});
</script>
@endpush