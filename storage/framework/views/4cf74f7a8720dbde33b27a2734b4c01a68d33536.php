<form action="<?php echo e(url('file-upload')); ?>" class="dropzone custom-dropzone dropzone_multiple" method="POST" enctype="multipart/form-data">
    <div class="form-group">
    <label for="Attachments">Attachments</label>

    <input type="hidden" name="temp_key" value="<?php echo e($randomKey); ?>">
    <input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>">

    <div class="dz-message vcenter" data-dz-message><span>
		drag or <a href="javascript:;" style="color: #00C763">upload</a>
	</span>
    </div>
    </div>
</form>
<br>
<?php /**PATH /var/www/html/ecoach/resources/views/layouts/upload_files.blade.php ENDPATH**/ ?>