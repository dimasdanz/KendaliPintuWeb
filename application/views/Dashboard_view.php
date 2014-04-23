<div class="row">
	<div class="col-sm-9">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<i class="fa fa-unlock-alt"></i> Catatan Hari Ini
			</div>
			<div class="table-responsive">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>No.</th>
							<th>Nama</th>
							<th>Keterangan</th>
							<th>Waktu</th>
						</tr>
					</thead>
					<tbody id="today_log_table">
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<i class="fa fa-info-circle"></i> Perangkat
			</div>
			<ul class="list-group dcs_status">
				<li class="list-group-item clearfix"><div class="pull-left">Status</div>
					<div class="pull-right">
						<b id="status_text">N/A</b>
					</div>
				</li>
				<li class="list-group-item">
					<form class="form-inline" role="form" style="height: 20px">
						<input type="checkbox" id="status_switch" data-on="info" data-off="danger" disabled>
					</form>
				</li>
				<li class="list-group-item">
					<form class="form-inline" role="form" style="height: 20px">
						<button class="btn btn-primary" style="width: 100%" type="button" id="open_door_button" disabled>Buka Pintu</button>
					</form>
				</li>
			</ul>
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
				<button type="button" class="btn btn-success" id="confirm_action">Ya</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url()?>assets/js/bootstrap-switch.js"></script>
<script>
function on_checked(){
	$("#status_switch").bind('switch-change', function (e, data) {
		executed = true;
		if (data.value == true) {
			$("#confirm_action").val("activate");
			$("#confirm_str").html('Aktifkan perangkat?');
		}else{
			$("#confirm_action").val("deactivate");
			$("#confirm_str").html('Non-aktifkan perangkat?');
		}
		$('#modal_confirm').modal('show');
	});	
}

function check_arduino(){
	console.log("checking");
	$.getJSON('<?php echo base_url()?>api/arduino/check_arduino', function(data) {
		if(data.response == 'active'){
			$('#status_text').html('Aktif');
			$('#status_switch').prop('disabled', false);
			$('#open_door_button').prop('disabled', false);
			$('#status_switch').bootstrapSwitch('setState', true);
		}else if(data.response == 'inactive'){
			$('#status_text').html('Non-Aktif');
			$('#status_switch').prop('disabled', false);
			$('#open_door_button').prop('disabled', false);
			$('#status_switch').bootstrapSwitch('setState', false);
		}else{
			$('#status_text').html('Offline');
			$('#status_switch').prop('disabled', true);
			$('#open_door_button').prop('disabled', true);
			$('#status_switch').bootstrapSwitch('setState', false);
		}
	});
}

var lastData = new Array(new Object());
function poll_today_log(){
	$.getJSON('<?php echo base_url()?>api/web/today_log', function(data) {
		if(lastData[0].time != data[0].time){
			$("#today_log_table").html("");
			var new_col;
			var no = 1;
			$.each(data, function(i, item){
				new_col += "<tr>";
				new_col += "<td>"+no+"</td>";
				new_col += "<td>"+item.name+"</td>";
				new_col += "<td>"+item.info+"</td>";
				new_col += "<td>"+item.time+"</td>";
				new_col += "</tr>";
				no += 1;
				$("#today_log_table").append(new_col);
				new_col = "";
			});
			lastData[0].time = data[0].time;
		}
	});
	setTimeout(poll_today_log, 10000);
}

$(document).ready(function(){
	var executed = false;
	var open_door = false;
	$("#status_switch").bootstrapSwitch();

	$('#open_door_button').click(function(){
		executed = true;
		$("#confirm_action").val("open_door");
		$("#confirm_str").html('Buka pintu?');
		$('#modal_confirm').modal('show');
	});

	$("#confirm_action").click(function(){
		if($("#confirm_action").val() == 'activate'){
			$.get("<?php echo site_url('/api/arduino/activate')?>");
		}else if ($("#confirm_action").val() == 'deactivate'){
			$.get("<?php echo site_url('/api/arduino/deactivate')?>");
		}else{
			$.get("<?php echo site_url('/api/web/open_door')?>");
		}
		$("#status_switch").unbind('switch-change');
		executed = true;
		setTimeout(check_arduino, 1000);
		$('#modal_confirm').modal('hide');
		setTimeout(on_checked, 500);
	});

	$('#modal_confirm').on('hide.bs.modal', function (e) {
		if(executed){
			executed = false;
		}else{
			$("#status_switch").bootstrapSwitch('toggleState');
		}
	});
	
	check_arduino();
	poll_today_log();
	setTimeout(on_checked, 500);
});
</script>