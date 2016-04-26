<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">

    <form method="post">

        <div class="form-group <?php echo Form\has_error('nombre_recorrido') ? 'has-error' :'' ?>">
            <label class="control-label" for="nombre_recorrido">Nombre Recorrido</label>
            <input type="text" name="nombre_recorrido" id="nombre_recorrido" class="form-control" required value="<?php echo Form\set_value('nombre_recorrido', $recorrido->nombre_recorrido) ?>">
            <p class="help-block"><?php echo Form\get_error('nombre_recorrido') ?></p>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-default">Limpiar</button>
        </div>
    </form>
</div> <!-- /#main_content -->
</div> <!-- /.row -->

<script>
    $("#nombre_recorrido").focus();
</script>
<?php $this->load->view('admin/layout/footer') ?>