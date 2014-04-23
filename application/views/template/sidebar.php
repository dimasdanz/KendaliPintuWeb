<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			<li id="dashboard">
				<a href="<?php echo site_url('/')?>"><i class="fa fa-dashboard fa-fw"></i> Beranda</a>
			</li>
			<li id="users">
				<a href="<?php echo site_url('/users')?>"><i class="fa fa-users fa-fw"></i> Pengguna</a>
			</li>
			<li id="logs">
				<a href="<?php echo site_url('/logs')?>"><i class="fa fa-list fa-fw"></i> Catatan</a>
			</li>
			<li id="admins">
				<a href="<?php echo site_url('/admins')?>"><i class="fa fa-user fa-fw"></i> Admin</a>
			</li>
		</ul>
		<div class="sidebar sidebar-footer">
			<div class="row">
				<div class="col-sm-12">
					<div class="text-left">
						<p class="credit">
							<a href="http://twitter.com/Dimasdanz" target="_blank">Dimas Rullyan Danu</a> &copy; 2014
						</p>
						<p class="text-muted credit small">Powered by SB-Admin</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</nav>
<script>
$("#<?php echo $this->uri->segment(1, 'dashboard')?>").addClass("active");
$("#<?php echo $this->uri->segment(1, 'dashboard')?>").addClass("selected");
</script>