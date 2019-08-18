<?php
	$data = array(
		'email' => get_option('wafm_license_email'),
		'key' 	=> get_option('wafm_license_key')
	);
?>

<div class="wrap">
	<h1>License</h1>
	<div class="row mt-3 wafm-setting">

		<div class="col-6">
			<div class="row">
				<div class="col-12">
					<div class="form-group">
			        	<label>Email: </label>
			        	<input type="email" name="email" placeholder="Email" class="form-control" value="<?php echo $data['email']; ?>" required>
			        </div>
				</div>
				<div class="col-12">
					<div class="form-group">
			        	<label>Key: </label>
			        	<input type="text" name="key" placeholder="Key" class="form-control" value="<?php echo $data['key']; ?>" required>
			        </div>
				</div>
			</div>
		</div>

		<hr>

		<div class="col-12 mt-3">
			<button name="btn_save" class="btn btn-success btn-sm" style="min-width: 150px;"><i class="fa fa-save"></i> Save</button>
		</div>

	</div>
</div>