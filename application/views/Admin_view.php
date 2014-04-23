	<?php 
		if($this->session->flashdata('success')){
	?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<?=$this->session->flashdata('success')?>
		</div>
    <?php 
    	}
    ?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover" id="dataTables-admin">
							<thead>
								<tr>
									<th width="5%">No.</th>
									<th>Nama</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<?php
								$no = 1;
								if($admin != NULL){
									foreach ($admin as $row){
							?>
							<tbody>
								<tr>
									<td><?=$no?></td>
									<td><?=$row->username?></td>
									<td><button data-toggle="modal" data-target="#modal_edit" class="btn btn-default edit" id="<?=$row->username?>"><i class="fa fa-edit"></i> Ubah</button></td>
								</tr>
							</tbody>
							<?php 
									$no++;
									}
								}
							?>
						</table>
					</div>
				</div>
				<div class="panel-footer clearfix">
					<button class="btn btn-default pull-right" data-toggle="modal" data-target="#modal_add">Tambah Admin Baru</button>
				</div>
			</div>
		</div>
	</div>
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?=form_open(base_url().'admins/insert')?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Form Admin</h4>
				</div>
				<div class="modal-body">
					<?php
						if($this->session->flashdata('error')){
							$username = $this->session->flashdata('error')[0];
							$error = $this->session->flashdata('error')[1];
					?>
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?=$error?>
					</div>
					<?php
						}else{
							$username = "";
						}
					?>
					<div class="form-group">
						<label>Nama Pengguna</label>
						<input class="form-control" placeholder="Nama Pengguna" type="text" name="username" value="<?=$username?>" required>
					</div>
					<div class="form-group">
						<label>Kata Sandi</label>
						<input class="form-control" placeholder="Kata Sandi" type="password" name="password" required>
					</div>
					<div class="form-group">
						<label>Konfirmasi Kata Sandi</label>
						<input class="form-control" placeholder="Konfirmasi Kata Sandi" type="password" name="confirm_password" required>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Tambah Admin Baru</button>
				</div>
			<?=form_close()?>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-left">Edit Admin</h4>
            </div>
            <div class="modal-body">
            	<div class="row">
            		<?php
						if($this->session->flashdata('delete_error')){
					?>
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?=$this->session->flashdata('delete_error')?>
					</div>
					<?php
						}
					?>
            		<div class="col-sm-offset-3">
            		<?=form_open(base_url().'admins/reset_password')?>
	            		<input type="hidden" name="username" id="username">
						<button type="submit" class="btn btn-default"><i class="fa fa-refresh"></i> Reset Kata Sandi</button>
						<a href="#" class="btn btn-danger delete" data-toggle="modal" data-target="#modal_confirm" id="delete"><i class="fa fa-trash-o"></i> Hapus Akun Ini</a>
					<?=form_close()?>										
				</div>
			</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_confirm" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-left">Konfirmasi</h4>
            </div>
            <div class="modal-body">
                <p id="confirm_str"></p>
            </div>
            <div class="modal-footer">
            	<?=form_open(base_url().'admins/delete')?>
	            	<input type="hidden" name="username" id="name" value="asd">
	                <button type="submit" class="btn btn-success" id="yes">Ya</button>
	                <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url()?>assets/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?=base_url()?>assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function(){
		<?php
			if($this->session->flashdata('error')){
		?>
			$('#modal_add').modal('show');
		<?php
			}
		?>
		<?php
			if($this->session->flashdata('delete_error')){
		?>
			$('#modal_edit').modal('show');
		<?php
			}
		?>
		$('#dataTables-admin').dataTable({
			"fnDrawCallback": function ( oSettings ) {
				if ( oSettings.bSorted || oSettings.bFiltered )
				{
					for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
					{
						$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
					}
				}
			},
			"aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0,2 ] }
			],
			"aaSorting": [[ 1, 'asc' ]]
		});

		$(".edit").click(function() {
			var id = this.id;
			var logged_in = '<?=$this->session->userdata('logged_in')?>';
			var username = new String(id);
			$("#delete").removeAttr('disabled');
			if(username == logged_in){
				$("#delete").attr('disabled','disabled');
			}
			$("#username").val(id);
		});
		
		$(".delete").click(function() {
			var name = $("#username").val();
			$("#name").val(name);
			$("#confirm_str").html('Apakan anda yakin ingin menghapus <b>'+name+'</b>?');
		});
	});
</script>
