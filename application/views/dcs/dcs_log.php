	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-condensed" id="dataTables-dcs_log">
							<thead>
								<tr>
									<th width="5%">No.</th>
									<th>Nama</th>
									<th>Waktu</th>
									<th>Tanggal</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								$no = 1;
								if($dcs_log != NULL){
									foreach ($dcs_log as $row){
							?>
								<tr>
									<td><?=$no?></td>
									<td><?=$row->name?></td>
									<td><?=date('H:i:s', strtotime($row->time))?></td>
									<td><?=date('d F Y', strtotime($row->time))?></td>
								</tr>
							<?php 
									$no++;
									}
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?=base_url()?>assets/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?=base_url()?>assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function(){
		$('#dataTables-dcs_log').dataTable({
			"iDisplayLength": 50,
			
			"oLanguage": {
				"sLengthMenu": "Tampilkan _MENU_ data per halaman",
				"sInfo": "Menampilkan _START_ ke _END_ dari _TOTAL_ records",
				"sInfoEmpty": "Menampilkan 0 ke 0 dari 0 baris",
				"sZeroRecords": "Belum ada data",
				"sSearch": "Pencarian",
				"oPaginate" : {
					"sNext" : "Berikut",
					"sPrevious" : "Sebelum",
					"sFirst": "Halaman Pertama",
					"sLast": "Halaman Terakhir",
					
				}
			},
		<?php 
			if($dcs_log != NULL){
		?>
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
				{ "bSortable": false, "aTargets": [ 0 ] }
			]
		<?php 
			}
		?>
		});
	});
</script>