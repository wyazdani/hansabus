
<form method="post" action="{!! route('tour-invoice.send_mail') !!}">
    @csrf
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{__('tour_invoice.invoice_email')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="ft-x blue-grey darken-4"></i>
            </button>
        </div>
        <div class="modal-body row">
            <input type="hidden" name="invoice_id" value="{!! $invoice->id !!}">
            <div class="col-md-6">
                <label>{{__('tour_invoice.subject')}}</label>
                <input required type="text" name="subject"
                       class="{{($errors->has('subject')) ?'error_input form-control ':'form-control '}}">
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <label>{{__('tour_invoice.body')}}</label>
                <textarea required rows="5" type="text" name="body" class="{{($errors->has('body')) ?'error_input form-control':'form-control'}}"></textarea>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-labeled btn-xxs btn-success"> Send Mail</button>
        </div>
    </div>
</form>

