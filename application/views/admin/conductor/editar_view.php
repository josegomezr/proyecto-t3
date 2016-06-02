<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">

    <form method="post">
        <div class="form-group">
            <label class="control-label" for="cedula">Cedula</label>
            <input type="text" disabled id="cedula" class="form-control" maxlength="10" value="<?php echo $conductor->cedula_conductor; ?>">
        </div>

        <div class="form-group <?php echo Form\has_error('nombre') ? 'has-error' :'' ?>">
            <label class="control-label" for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" minlength="3" required value="<?php echo Form\set_value('nombre', $conductor->nombre_conductor) ?>">
            <p class="help-block"><?php echo lang(Form\get_error('nombre')) ?></p>
        </div>

        <div class="form-group <?php echo Form\has_error('apellido') ? 'has-error' :'' ?>">
            <label class="control-label" for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control" minlength="3" required value="<?php echo Form\set_value('apellido', $conductor->apellido_conductor) ?>">
            <p class="help-block"><?php echo lang(Form\get_error('apellido')) ?></p>
        </div>

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
    $("#nombre").focus();
});
</script>
<?php $this->load->view('admin/layout/footer') ?>