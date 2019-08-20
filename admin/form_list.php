<?php
dequeue_external_scripts();

$bhs = array(
	'h1' => 'Form List',
	'add_new' => 'Add New',
	'search' => 'Search',
	'form_name' => 'Form Name',
	'title' => 'Title',
	'number' => 'Reception Number',
	'button_open' => 'Button Open Text',
	'button_send' => 'Button Send Text',
	'add_field' => 'Add Field',
	'add_select' => 'Add Select',
	'message' => 'Message',
	'save' => 'Save',
	'cancel' => 'Cancel',
	'field_name' => 'Field Name',
	'required' => 'Required',
	'btn_add' => 'Add',
	'select_name' => 'Select Name',
	'option' => 'Option(s)',
	'option_note' => 'Spare option with comma'
);

$lang = get_locale();
if ($lang == 'id_ID') {
	$bhs = array(
		'h1' => 'Daftar Form',
		'add_new' => 'Tambah Baru',
		'search' => 'Cari',
		'form_name' => 'Nama Form',
		'title' => 'Judul',
		'number' => 'Nomor WA Penerima',
		'button_open' => 'Tulisan Tombol Buka',
		'button_send' => 'Tulisan Tombol Kirim',
		'add_field' => 'Tambah Field',
		'add_select' => 'Tambah Select',
		'message' => 'Pesan',
		'save' => 'Simpan',
		'cancel' => 'Batal',
		'field_name' => 'Nama Field',
		'required' => 'Diperlukan',
		'btn_add' => 'Tambah',
		'select_name' => 'Nama Select',
		'option' => 'Pilihan',
		'option_note' => 'Pisahkan pilihan dengan tanda koma'
	);
}
?>
<div class="wrap">
	<h1><?php echo $bhs['h1']; ?></h1>
	<div class="row mt-3 wafm-form-list">
		<div class="col-6 d-flex align-items-center">
			<button name="btn_add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $bhs['add_new']; ?></button>
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
						<th><?php echo $bhs['form_name']; ?></th>
						<th>Shortcode</th>
						<th style="width: 175px;"></th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>

		<div class="col-6 d-flex align-items-center">
			<!-- <button name="btn_back" class="btn btn-danger btn-sm"><i class="fa fa-chevron-left"></i> Back</button> -->
		</div>
		<div class="col-6 d-flex align-items-center">
			<button id="0" name="btn_export" class="btn btn-success btn-sm ml-auto" disabled><i class="fa fa-file-export"></i> Export</button>
		</div>
		<div class="col-12 mt-3">
			<div class="table-responsive">
				<table id="detailTable" class="table table-striped table-bordered table-hover table-sm">
					<thead>
						<th width="10%">No.</th>
						<th width="45%">Field</th>
						<th width="45%">Value</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="row mt-3 card-deck wafm-form-list" style="display: none;">
		<div class="col-12 card">
			<div class="form-group">
				<label><strong><?php echo $bhs['title']; ?>: </strong></label>
				<input type="text" name="title" placeholder="Form List Title" class="form-control">
			</div>
			<div class="form-group">
				<div class="input-group-inline">
        	<input type="radio" name="link-type" class="form-control" value="number" checked> WA Number
        	<input type="radio" name="link-type" class="form-control" value="link"> Redirect Link
        </div>
			</div>
			<div class="form-group">
				<label><strong><?php echo $bhs['number']; ?>: </strong></label>
				<select name="id_number" class="form-control" style="width: 100%"></select>
			</div>
			<div class="form-group" style="display: none;">
				<label><strong>Redirect Link: </strong></label>
				<input type="text" name="group_link" placeholder="Redirect Link" class="form-control">
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label><strong><?php echo $bhs['button_open']; ?>: </strong></label>
						<input type="text" name="button_name" placeholder="Button Open Text" class="form-control">
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label><strong><?php echo $bhs['button_send']; ?>: </strong></label>
						<input type="text" name="button_send" placeholder="Button Send Text" class="form-control">
					</div>
				</div>
			</div>
			<div class="form-group">
				<button name="btn_add_field" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#btnAddFieldModal"><?php echo $bhs['add_field']; ?></button>
				<button name="btn_add_select" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#btnAddSelectModal"><?php echo $bhs['add_select']; ?></button>
			</div>
			<div class="form-group">
				<label><strong><?php echo $bhs['message']; ?>: </strong></label>
				<textarea name="message" class="form-control" rows="13"></textarea>
			</div>
			<hr>
			<div class="row">
				<div class="col-4 col-sm-2">
					<button id="0" name="btn_save" class="btn btn-success btn-sm btn-block"><?php echo $bhs['save']; ?></button>
				</div>
				<div class="col-4 col-sm-2">
					<button name="btn_cancel" class="btn btn-danger btn-sm btn-block"><?php echo $bhs['cancel']; ?></button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Add Field -->
<div class="modal fade" id="btnAddFieldModal" role="dialog" aria-labelledby="btnAddFieldModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="btnAddFieldModalLongTitle"><?php echo $bhs['add_field']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formField">
        	<div class="form-group">
	        	<label><?php echo $bhs['field_name']; ?>: </label>
	        	<input type="text" name="field_name" placeholder="Field Name" class="form-control" required>
	        </div>
	        <label>Icon: </label>
	        <div class="input-group-inline mb-3">
	        	<input type="radio" name="icon" class="form-control" value="fa fa-user" checked> <i class="fa fa-user"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fab fa-whatsapp"> <i class="fab fa-whatsapp"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fa fa-map-marked-alt"> <i class="fa fa-map-marked-alt"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fa fa-cash-register"> <i class="fa fa-cash-register"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fa fa-money-bill-wave"> <i class="fa fa-money-bill-wave"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fa fa-address-card"> <i class="fa fa-address-card"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fa fa-balance-scale"> <i class="fa fa-balance-scale"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fa fa-bell"> <i class="fa fa-bell"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fa fa-book"> <i class="fa fa-book"></i>
	        </div>
	        <div class="form-group">
					  <input type="checkbox" name="required" class="form-control"> <?php echo $bhs['required']; ?>
					</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $bhs['cancel']; ?></button>
        <button name="btn_add_field_save" type="button" class="btn btn-primary"><?php echo $bhs['btn_add']; ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add Select -->
<div class="modal fade" id="btnAddSelectModal" role="dialog" aria-labelledby="btnAddSelectModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="btnAddSelectModalLongTitle"><?php echo $bhs['add_select']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formSelect">
        	<div class="form-group">
	        	<label><?php echo $bhs['select_name']; ?>: </label>
	        	<input type="text" name="select_name" placeholder="Select Name" class="form-control" required>
	        </div>
	        <div class="form-group">
	        	<label><?php echo $bhs['option']; ?>: </label>
	        	<input type="text" name="select_options" placeholder="Option List" class="form-control" required>
	        	<small>*<?php echo $bhs['option_note']; ?></small>
	        </div>
	        <label>Icon: </label>
	        <div class="input-group-inline mb-3">
	        	<input type="radio" name="icon" class="form-control" value="fa fa-user" checked> <i class="fa fa-user"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fab fa-whatsapp"> <i class="fab fa-whatsapp"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fa fa-map-marked-alt"> <i class="fa fa-map-marked-alt"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fa fa-cash-register"> <i class="fa fa-cash-register"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fa fa-money-bill-wave"> <i class="fa fa-money-bill-wave"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fa fa-address-card"> <i class="fa fa-address-card"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fa fa-balance-scale"> <i class="fa fa-balance-scale"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fa fa-bell"> <i class="fa fa-bell"></i>
	        	<input type="radio" name="icon" class="form-control ml-1" value="fa fa-book"> <i class="fa fa-book"></i>
	        </div>
	        <div class="form-group">
					  <input type="checkbox" name="required" class="form-control"> <?php echo $bhs['required']; ?>
					</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $bhs['cancel']; ?></button>
        <button name="btn_add_select_save" type="button" class="btn btn-primary"><?php echo $bhs['btn_add']; ?></button>
      </div>
    </div>
  </div>
</div>