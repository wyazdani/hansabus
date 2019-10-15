<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="v_driver_name"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="ft-x blue-grey darken-4"></i>
        </button>
    </div>
    <div class="modal-body row">
        <div class="col-md-12">
            <dl>
                <dt >{{__('offer.customer_name')}}:</dt>
                <dd >{!! !empty($inquiry->name)?$inquiry->name:'None' !!}</dd>

                <dt >{{__('offer.email')}}:</dt>
                <dd >{!! !empty($inquiry->email)?$inquiry->email:'None' !!}</dd>

                <dt >{{__('offer.from_address')}}:</dt>
                <dd >{!! !empty($inquiry->inquiryaddresses[0]->from_address)?$inquiry->inquiryaddresses[0]->from_address:'None' !!}</dd>


                <dt >{{__('offer.to_address')}}:</dt>
                <dd >{!! !empty($inquiry->inquiryaddresses[0]->to_address)?$inquiry->inquiryaddresses[0]->to_address:'None' !!}</dd>

                <dt>{{__('offer.departure_time')}}:</dt>
                <dd >{!! !empty($inquiry->inquiryaddresses[0]->time)?$inquiry->inquiryaddresses[0]->time:'None' !!}</dd>



                <dt>{{__('offer.arrival_time')}}:</dt>
                <dd >{!! !empty($inquiry->inquiryaddresses[1])?$inquiry->inquiryaddresses[1]->time:'None' !!}</dd>

                <dt >{{__('offer.seats')}}:</dt>
                <dd >{!! !empty($inquiry->seats)?$inquiry->seats:'None' !!}</dd>


                <div class="col-md-6">
                    <label>{{__('offer.description')}}</label>
                    <p>{!! $inquiry->description !!}</p>
                </div>

            </dl>
        </div>
    </div>
</div>