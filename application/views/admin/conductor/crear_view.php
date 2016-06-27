<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <p><?php echo lang($this->session->flashdata('error')); ?></p>
        </div>
    <?php endif ?>

    <form method="post">
        <div class="row clearfix">
            <div class="col-xs-12">
                <div class="alert alert-info">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <p>Los campos marcados con <code><span class="required-mark"></span></code> son <strong>Obligatorios</strong></p>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-6">
                <div class="form-group <?php echo Form\has_error('cedula') ? 'has-error' :'' ?>">
                    <label class="control-label required-mark" for="cedula">Cedula</label>
                    <input type="text" name="cedula" id="cedula" maxlength="10"placeholder="Ejemplo: V-00000000 o E-00000000" class="form-control" value="<?php echo Form\set_value('cedula') ?>" autofocus required data-rule-cedula="true">
                    <p class="help-block"><?php echo lang(Form\get_error('cedula')) ?></p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group <?php echo Form\has_error('nombre') ? 'has-error' :'' ?>">
                    <label class="control-label required-mark" for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="" class="form-control" minlength="3" required value="<?php echo Form\set_value('nombre') ?>">
                    <p class="help-block"><?php echo lang(Form\get_error('nombre')) ?></p>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-6">
                <div class="form-group <?php echo Form\has_error('apellido') ? 'has-error' :'' ?>">
                    <label class="control-label required-mark" for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="" class="form-control" minlength="3" required value="<?php echo Form\set_value('apellido') ?>">
                    <p class="help-block"><?php echo lang(Form\get_error('apellido')) ?></p>
                </div>
            </div>
        </div>

        <label class="checkbox">
        	<label for="temporal">
            	<input type="checkbox" name="temporal" id="temporal" <?php echo Form\set_value('temporal') ? 'checked="checked"' : '' ?>>
        		¿Es Temporal?
        	</label>
        </label>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Guardar</button>

            <button type="reset" class="btn btn-default">Limpiar</button>
        </div>
    </form>
</div> <!-- /#main_content -->
</div> <!-- /.row -->
<script>
jQuery(function($) {
    $("form").validate();
});
</script>
<?php $this->load->view('admin/layout/footer') ?>