<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
    <form method="post">
        <div class="row clearfix"> 
            <div class="col-xs-12 col-sm-6">
        <div class="form-group <?php echo Form\has_error('descripcion_tipo_incidencia') ? 'has-error' :'' ?>">
            <label class="control-label required-mark" for="descripcion_tipo_incidencia">Descripcion de Tipo Incidencia</label>
            <input type="text" name="descripcion_tipo_incidencia" id="descripcion_tipo_incidencia" minlength="5" maxlength="30" class="form-control" autofocus required value="<?php echo Form\set_value('descripcion_tipo_incidencia', $tipo_incidencia->descripcion_tipo_incidencia) ?>">
            <p class="help-block"><?php echo Form\get_error('descripcion_tipo_incidencia') ?></p>
        </div>
            </div>
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
});
</script>
<?php $this->load->view('admin/layout/footer') ?>