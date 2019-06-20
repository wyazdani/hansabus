<div class="card">
    <div class="card-body collapse show">
        <div class="card-block">
            <form action="<?php echo e(url('file-upload')); ?>" class="dropzone dropzone-area dropzone_multiple" id="dpz-multiple-files"
                  method="POST" enctype="multipart/form-data">
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
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/ecoach/resources/views/layouts/upload_files.blade.php ENDPATH**/ ?>