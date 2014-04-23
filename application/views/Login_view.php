<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Please Log In</h3>
				</div>
				<div class="panel-body">
					<?php 
						if($this->session->flashdata('error')){
					?>
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<?=$this->session->flashdata('error')?>
						</div>
				    <?php 
				    	}
				    ?>
					<?=form_open(base_url().'login/validate')?>
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Username" name="username" type="text" autofocus>
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" type="password" value="">
							</div>
							<button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
						</fieldset>
					<?=form_close()?>
				</div>
			</div>
		</div>
	</div>
</div>