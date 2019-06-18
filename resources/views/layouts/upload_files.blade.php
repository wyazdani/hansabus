<form action="{{ url('file-upload') }}" class="dropzone custom-dropzone dropzone_multiple" method="POST" enctype="multipart/form-data">
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
<br>
