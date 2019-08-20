<?php
dequeue_external_scripts();

$bhs = array(
	'intro' => 'Activate the Facebook pixel feature from the following list : ',
	'view_content' => 'View Content',
	'add_to_cart' => 'Add To Cart',
	'initiate_checkout' => 'Initiate Checkout',
	'purchase' => 'Purchase',
	'save' => 'Save'
);

$lang = get_locale();
if ($lang == 'id_ID') {
	$bhs = array(
		'intro' => 'Aktifkan fitur facebook pixel dari daftar berikut : ',
		'view_content' => 'Lihat Kontent',
		'add_to_cart' => 'Tambahkan Ke Keranjang',
		'initiate_checkout' => 'Memulai Proses Pembayaran',
		'purchase' => 'Pembelian',
		'save' => 'Simpan'
	);
}

$data = array(
	'view_content' => get_option('wafm_facebook_pixel_view_content'),
	'add_to_cart' => get_option('wafm_facebook_pixel_add_to_cart'),
	'initiate_checkout' => get_option('wafm_facebook_pixel_initiate_checkout'),
	'purchase' => get_option('wafm_facebook_pixel_purchase')
);

?>

<div class="wrap">
	<h1>Facebook Pixel</h1>
	<div class="row mt-3 wafm-facebook-pixel">
		
		<div class="col-12">
			<h5><?php echo $bhs['intro']; ?></h5>
		</div>

		<div class="col-12">
			<div class="form-group">
	      <input type="checkbox" class="form-control" name="view_content" <?php if($data['view_content'] == 'yes') { echo "checked"; } ?>> <?php echo $bhs['view_content']; ?>
	    </div>
		</div>

		<div class="col-12">
			<div class="form-group">
	      <input type="checkbox" class="form-control" name="add_to_cart" <?php if($data['add_to_cart'] == 'yes') { echo "checked"; } ?>> <?php echo $bhs['add_to_cart']; ?>
	    </div>
		</div>

		<div class="col-12">
			<div class="form-group">
	      <input type="checkbox" class="form-control" name="initiate_checkout" <?php if($data['initiate_checkout'] == 'yes') { echo "checked"; } ?>> <?php echo $bhs['initiate_checkout']; ?>
	    </div>
		</div>

		<div class="col-12">
			<div class="form-group">
	      <input type="checkbox" class="form-control" name="purchase" <?php if($data['purchase'] == 'yes') { echo "checked"; } ?>> <?php echo $bhs['purchase']; ?>
	    </div>
		</div>

		<hr>

		<div class="col-12 mt-3">
			<button name="btn_save" class="btn btn-success btn-sm" style="min-width: 150px;"><i class="fa fa-save"></i> <?php echo $bhs['save']; ?></button>
		</div>

	</div>
</div>