<?php $this->load->view('front/layout/header') ?>

<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3" id="main_content">
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger">
			<p><?php echo lang($this->session->flashdata('error')); ?></p>
		</div>
	<?php endif ?>
	<form role="form" method="post" action="<?php echo site_url('home/login') ?>">
		<div class="form-group">
			<label for="username">Nombre de Usuario</label>
			<input type="text" class="form-control" autofocus required id="username" placeholder="Nombre" name="username" value="<?php echo Form\set_value('username'); ?>" minlength="4" maxlength="24">
		</div>

		<div class="form-group">
			<label for="password">Clave</label>
			<input type="password" class="form-control" required maxlength="16" minlength="4" id="password" placeholder="******" name="password">
		</div>
		
		<button type="submit" class="btn btn-primary">Iniciar Sesi&oacute;n</button>
		
		
	</form>
</div> <!-- /#main_content -->
<script>
	$("form").validate();
</script>

<?php $this->load->view('front/layout/footer') ?>