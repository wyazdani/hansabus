<div class="card-block">
    <label for="Attachments">{{__('tour.attachments')}}</label><br>
    <form action="{{ url('file-upload') }}" class="dropzone dropzone-area dropzone_multiple" id="dpz-multiple-files"
          method="POST" enctype="multipart/form-data" style="height: 100px;">
        <div class="form-group">
            <input type="hidden" name="temp_key" value="{{ $randomKey }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="acceptedFile" value="image/*,application/pdf,.psd">
            <div class=" vcenter" data-dz-message>
                <div class="dz-message ">
                    {{__('messages.drag')}} <a href="javascript:;" style="color: #00C763">{{__('messages.upload')}}</a><br>
                    <span class="note needsclick"><small>{{__('messages.allowed_extentions')}}</small><br>&nbsp;</span>
                </div>
            </div>
        </div>
    </form>
</div>