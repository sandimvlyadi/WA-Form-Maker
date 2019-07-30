<?php

$bhs = array(
	'h1' => 'Reception Number',
	'add_new' => 'Add Number',
	'search' => 'Search',
	'name' => 'Name',
	'title' => 'Title',
	'number' => 'Number',
	'picture' => 'Picture',
	'change' => 'Change',
	'cancel' => 'Cancel',
	'add' => 'Add'
);

$lang = get_locale();
if ($lang == 'id_ID') {
	$bhs = array(
		'h1' => 'Daftar Nomor WA Penerima',
		'add_new' => 'Tambah Nomor',
		'search' => 'Cari',
		'name' => 'Nama',
		'title' => 'Judul',
		'number' => 'Nomor WA',
		'picture' => 'Gambar',
		'change' => 'Ubah',
		'cancel' => 'Batal',
		'add' => 'Tambah'
	);
}
?>
<div class="wrap">
	<h1><?php echo $bhs['h1']; ?></h1>
	<div class="row mt-3 wafm-reception-numbers">
		<div class="col-6 d-flex align-items-center">
			<button name="btn_add" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#btnAddNumberModal"><i class="fa fa-plus"></i> <?php echo $bhs['add_new']; ?></button>
		</div>
		<div class="col-6">
			<div class="form-inline float-right">
				<div class="form-group">
					<label><?php echo $bhs['search']; ?>: </label>
					<input type="text" name="search" class="form-control ml-1">
				</div>
			</div>
		</div>
		<div class="col-12 mt-3">
			<div class="table-responsive">
				<table id="dataTable" class="table table-striped table-bordered table-hover table-sm">
					<thead>
						<th>No.</th>
						<th><?php echo $bhs['name']; ?></th>
						<th><?php echo $bhs['number']; ?></th>
						<th><?php echo $bhs['picture']; ?></th>
						<th style="width: 75px;"></th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal Add Field -->
<div class="modal fade" id="btnAddNumberModal" role="dialog" aria-labelledby="btnAddNumberTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="btnAddNumberLongTitle"><?php echo $bhs['add_new']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formData">
        	<div class="form-group">
	        	<label><?php echo $bhs['name']; ?>: </label>
	        	<input type="text" name="name" placeholder="Reception Name" class="form-control" required>
	        </div>
	        <div class="form-group">
	        	<label><?php echo $bhs['number']; ?>: </label>
	        	<input type="text" name="number" placeholder="Reception Number" class="form-control" required>
	        </div>
	        <div class="form-group">
	        	<label><?php echo $bhs['picture']; ?>: </label>
	        	<img name="picture" class="img-responsive display-picture">
            <p class="img-p"><i class="fa fa-camera"></i> <?php echo $bhs['change']; ?></p>
	        	<input type="file" name="picture" style="display: none;" accept="image/*">
	        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $bhs['cancel']; ?></button>
        <button name="btn_save" type="button" class="btn btn-primary"><?php echo $bhs['add']; ?></button>
      </div>
    </div>
  </div>
</div>