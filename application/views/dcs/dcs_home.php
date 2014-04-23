<div class="row">
	<div class="col-sm-5">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<i class="fa fa-info-circle"></i> Status Pintu
			</div>
			<ul class="list-group dcs_status">
				<li class="list-group-item clearfix"><div class="pull-left">Status</div>
					<div class="pull-right">
						<b id="status"></b>
					</div></li>
				<li class="list-group-item clearfix"><div class="pull-left">Batas Pengulangan Kata Sandi</div>
					<div class="pull-right">
						<b id="password_attempts"></b>
					</div></li>
				<li class="list-group-item clearfix"><div class="pull-left">Kondisi</div>
					<div class="pull-right">
						<b id="condition"></b>
					</div></li>
			</ul>
			<div class="panel-footer clearfix">
				<a href="<?=base_url()?>dcs/setting" class="btn btn-primary pull-right"><i class="fa fa-wrench"></i> Ubah Pengaturan <i class="fa fa-chevron-right"></i></a>
			</div>
		</div>
	</div>
	<div class="col-sm-7">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<i class="fa fa-list"></i> Log Hari Ini
			</div>
			<div class="table-responsive">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th style="width: 5%;">No.</th>
							<th>Nama</th>
							<th>Waktu</th>
						</tr>
					</thead>
					<tbody id="today_log">
					</tbody>
				</table>
			</div>
			<div class="panel-footer clearfix">
				<a href="<?=base_url()?>dcs/log" class="btn btn-primary pull-right"><i class="fa fa-list"></i> Lihat Semua Log <i class="fa fa-chevron-right"></i></a>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		function get_dcs_status(){
			$.getJSON('<?=base_url()?>api/dcs/dcs_status', function(data) {
				console.log(data);
				if(data.status){
					$("#status").html("Aktif");
				}else{
					$("#status").html("Tidak Aktif");
				}
				if(data.condition){
					$("#condition").html("Terkunci");
				}else{
					$("#condition").html("Tidak Terkunci");
				}
				$("#password_attempts").html(data.password_attempts);
				
				setTimeout(get_dcs_status, 1000);
			});
		}
		get_dcs_status();

		function get_today_log(){
			$("#today_log").load('<?=base_url()?>api/dcs/dcs_today_log');
			setTimeout(get_today_log, 1000);
		}
		get_today_log();
	});
</script>