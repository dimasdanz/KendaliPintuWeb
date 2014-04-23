	<div class="row">
		<?php 
			if($this->session->flashdata('message')){
		?>
		<div class="col-sm-offset-2">
			<div class="row">
				<div class="col-sm-8">
						<div class="alert alert-<?=$this->session->flashdata('message')[0]?> alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<?=$this->session->flashdata('message')[1]?>
						</div>
				    
		    	</div>
			</div>
		</div>
		<?php 
			}
		?>
	</div>
	<div class="row">
		<?php 
			if($condition == 0){
		?>
			<div class="col-sm-offset-2">
				<div class="row">
					<div class="col-sm-4">
						<div class="panel panel-primary">
							<div class="panel-heading" align="center">
								<i class="fa fa-power-off"></i> Status Perangkat
							</div>
							<div class="panel-body" align="center">
								<form class="form-inline" role="form">
									<input type="checkbox" id="status" checked data-on="success" data-off="danger">
								</form>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="panel panel-primary">
							<div class="panel-heading" align="center">
								<i class="fa fa-Keyboard-o"></i> Percobaan Kata Sandi
							</div>
							<div class="panel-body">
								<form class="form-inline" role="form" method="post" action="<?=base_url()?>dcs/change_attempt">
									<div class="form-group">
										<input type="text" class="form-control" name="password_attempts" value="<?=$password_attempts?>" placeholder="Attempts">
									</div>
									<button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i>&nbsp;</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php 
			}else{
		?>
		<div class="col-sm-offset-2">
			<div class="row">
				<div class="col-sm-8">
					<div class="panel panel-primary">
						<div class="panel-heading" align="center">
							<i class="fa fa-key"></i> Kondisi
						</div>
						<div class="panel-body">
							<p class="text-danger text-center">Perangkat terkunci!</p>
							<a href="<?=base_url()?>dcs/unlock" class="btn btn-warning btn-block btn-lg"><i class="fa fa-unlock"></i> Buka Kunci</a>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		<?php 
			}
		?>
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
            	<?=form_open(base_url().'dcs/change_status')?>
	            	<input type="hidden" name="status" id="status_value">
	                <button type="submit" class="btn btn-success" id="yes">Ya</button>
	                <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url()?>assets/js/bootstrap-switch.js"></script>
<script>
	$(document).ready(function() {
		$("#status").bootstrapSwitch();
		<?php 
			if($status == 1){
		?>
			$('#status').bootstrapSwitch('setState', true);
		<?php 
			}else{
		?>
			$('#status').bootstrapSwitch('setState', false);
		<?php 
			}
		?>
		$('#status').bootstrapSwitch('setOnLabel', 'I');
		$('#status').bootstrapSwitch('setOffLabel', 'O');
		$('#status').on('switch-change', function (e, data) {
			if (data.value == true) {
				$("#status_value").val("on");
				$("#confirm_str").html('Apakah Anda ingin menyalakan perangkat?');
			}else{
				$("#status_value").val("off");
				$("#confirm_str").html('Apakah Anda ingin mematikan perangkat?');
			}
			$('#modal_confirm').modal('show');
		});
		$('#modal_confirm').on('hide.bs.modal', function (e) {
			$('#status').bootstrapSwitch('toggleState');
		});
	});
</script>