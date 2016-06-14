<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
    <form method="post">

        <div class="alert alert-info">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <p>Los campos marcados con <code><span class="required-mark"></span></code> son <strong>Obligatorios</strong></p>
        </div>

        <div class="row clearfix"> 
            <div class="col-xs-12 col-sm-6">
                <div class="form-group <?php echo Form\has_error('nombre_recorrido') ? 'has-error' :'' ?>">
                    <label class="control-label required-mark" for="nombre_recorrido">Nombre Recorrido</label>
                    <input type="text" name="nombre_recorrido" id="nombre_recorrido" minlength="5" maxlength="30" class="form-control" autofocus required value="<?php echo Form\set_value('nombre_recorrido') ?>">
                    <p class="help-block"><?php echo Form\get_error('nombre_recorrido') ?></p>
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