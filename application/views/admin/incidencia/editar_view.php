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

            <div class="alert alert-info">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <p>Los campos marcados con <code><span class="required-mark"></span></code> son <strong>Obligatorios</strong></p>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group <?php echo Form\has_error('descripcion_incidencia') ? 'has-error' :'' ?>">
                        <label class="control-label required-mark" for="descripcion_incidencia">Descripcion Incidencia</label>
                        <textarea name="descripcion_incidencia" id="descripcion_incidencia" maxlength="140" class="form-control" autofocus required rows="3"><?php echo Form\set_value('descripcion_incidencia', $incidencia->descripcion_incidencia) ?></textarea>
                        <p class="help-block"><?php echo lang(Form\get_error('descripcion_incidencia')) ?></p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class="control-label required-mark " for="id_tipo_incidencia">Tipo Incidencia</label>
                        <select name="id_tipo_incidencia" required class="form-control" id="id_tipo_incidencia">
                            <option value="">Seleccione Tipo Incidencia</option>
                            <?php foreach ($tipos_incidencias as $tipo_incidencia): ?>
                                <option value="<?php echo $tipo_incidencia->id_tipo_incidencia ?>" <?php echo ($tipo_incidencia->id_tipo_incidencia == $incidencia->id_tipo_incidencia) ? 'selected="selected"' : '' ?>><?php echo $tipo_incidencia->descripcion_tipo_incidencia ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="reset" class="btn btn-default">Limpiar</button>
            </div>
        </form>

<div class="clearfix"></div>
</div> <!-- /#main_content -->
</div> <!-- /.row -->
<script>
jQuery(function($) {
    $("form").validate();
});
</script>
<?php $this->load->view('admin/layout/footer') ?>