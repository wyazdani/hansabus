<div class="card">
    <div class="card-body collapse show">
        <div class="card-block">
            <form action="{{ url('file-upload') }}" class="dropzone dropzone-area dropzone_multiple" id="dpz-multiple-files"
                  method="POST" enctype="multipart/form-data" style="height: 100px;">
                <div class="form-group">
                    <label for="Attachments">Attachments</label>

                    <input type="hidden" name="temp_key" value="{{ $randomKey }}">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    {{--    <input name="allowedExtensions" type="hidden" value="pdf">--}}
                    <div class="dz-message vcenter" data-dz-message><span>
		drag or <a href="javascript:;" style="color: #00C763">upload</a>
	</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
