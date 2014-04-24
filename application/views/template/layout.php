<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Kendali Pintu | Dimas Rullyan Danu</title>
<link rel="shortcut icon" href="<?php echo base_url()?>assets/images/favicon.png" type="image/x-icon">
<link rel="icon" href="<?php echo base_url()?>assets/images/favicon.png" type="image/x-icon">

<!-- CSS -->
<link href="<?php echo base_url()?>assets/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/css/bootstrap-switch.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/css/sb-admin.css" rel="stylesheet">

<!-- Javascript -->
<script src="<?php echo base_url()?>assets/js/jquery.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url()?>assets/js/sb-admin.js"></script>

</head>
<body>
	<div id="wrapper">
		<?php 
			if($this->uri->segment(1) != 'login'){ 
				$this->load->view('template/topbar');
				$this->load->view('template/sidebar');
			}
		?>
		<?php
			switch($this->uri->segment(1)){
				case 'users':
					$header = 'Pengguna';
					$icon = 'users';
					break;
				case 'logs':
					$header = 'Log';
					$icon = 'list';
					break;
				case 'admins':
					$header = 'Admin';
					$icon = 'user';
					break;
				case 'about':
					$header = 'About';
					$icon = 'tasks';
					break;
				default:
					$header = 'Beranda';
					$icon = 'home';
					break;
			}
			
			if($this->uri->segment(1) != 'login'){
		?>
		<div id="page-wrapper">
			<div class="row">
				<div class="col-sm-12">
					<h3 class="page-header">
						<i class="fa fa-<?php echo $icon?> fa-fw"></i> <?php echo $header?></h3>
				</div>
			</div>
			<?php 
				} 
				$this->load->view($content, $contentData)
			?>
		</div>
    </div>
</body>