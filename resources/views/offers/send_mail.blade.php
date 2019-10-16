
<form method="post" action="{!! route('offers.send_mail') !!}">
    @csrf
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{__('offer.heading.index')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="ft-x blue-grey darken-4"></i>
            </button>
        </div>
        <div class="modal-body row">
            <input type="hidden" value="{!! $inquiry->id !!}" name="inquiry_id">
            <div class="col-md-8">
                <dl>
                    <dt>{{__('offer.customer_name')}}:</dt>
                    <dd >{!! $inquiry->name !!}</dd>
                    <dt>{{__('offer.from')}}:</dt>
                    <dd >{!! $inquiry->inquiryaddresses[0]->from_address !!}</dd>

                    <dt>{{__('offer.to')}}:</dt>
                    <dd >{!! $inquiry->inquiryaddresses[0]->to_address !!}</dd>
                    <dt>{{__('offer.departure')}}:</dt>
                    <dd >{!! !empty($inquiry->inquiryaddresses[0]->time)?date('M j, Y, g:i a',strtotime($inquiry->inquiryaddresses[0]->time)):'' !!}</dd>
                    <dt>{{__('offer.arrival')}}:</dt>
                    <dd>{!! !empty($inquiry->inquiryaddresses[1])?date('M j, Y, g:i a',strtotime($inquiry->inquiryaddresses[1]->time)):'Not Available' !!}</dd>
                    <dt>{{__('offer.type')}}:</dt>
                    <dd >{!! !empty($inquiry->inquiryaddresses[1])?__('offer.two_way'):__('offer.one_way') !!}</dd>
                </dl>
            </div>
            <div class="col-md-6">
                <label>{{__('offer.price')}}</label>
                <input required type="text" name="price" id="price"
                       class="{{($errors->has('price')) ?'error_input form-control has_numeric':'form-control has_numeric'}}">
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <label>{{__('offer.comment')}}</label>
                <textarea required rows="5" type="text" name="comment" id="comment" class="{{($errors->has('comment')) ?'error_input form-control':'form-control'}}"></textarea>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-labeled btn-xxs btn-success"> Send Mail</button>
        </div>
    </div>
</form>

