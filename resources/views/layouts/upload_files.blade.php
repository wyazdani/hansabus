<div class="card">
    <div class="card-body collapse show">
        <div class="card-block">
            <label for="Attachments">{{__('messages.attachments')}}</label>
            <form action="{{ url('file-upload') }}" class="dropzone dropzone-area dropzone_multiple" id="dpz-multiple-files"
                  method="POST" enctype="multipart/form-data" style="height: 100px;">
                <div class="form-group">


                    <input type="hidden" name="temp_key" value="{{ $randomKey }}">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    {{--    <input name="allowedExtensions" type="hidden" value="pdf">--}}
                    <div class="dz-message vcenter" data-dz-message><span>
		{{__('messages.drag_or')}} <a href="javascript:;" style="color: #00C763">{{__('messages.upload')}}</a>
	</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
