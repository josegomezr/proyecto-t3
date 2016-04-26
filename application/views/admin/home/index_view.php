<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
	<?php if ($this->session->flashdata('info')): ?>
		<div class="alert alert-success">
			<p><?php echo lang($this->session->flashdata('info')) ?></p>
		</div>
	<?php endif ?>
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger">
			<p><?php echo lang($this->session->flashdata('error')) ?></p>
		</div>
	<?php endif ?>
	<h1>Bienvenido <?php echo $auth->nombre; ?></h1>
</div> <!-- /#main_content -->
</div> <!-- /.row -->

<?php $this->load->view('admin/layout/footer') ?>