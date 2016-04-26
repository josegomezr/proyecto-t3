<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <p><?php echo $this->session->flashdata('error'); ?></p>
    </div>
<?php endif ?>
<form method="post">
        <div class="alert alert-info">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <p>Los campos marcados con <code><span class="required-mark"></span></code> son <strong>Obligatorios</strong></p>
        </div>
        <div class="form-group">
            <label class="control-label" for="placa">Placa</label>
            <input type="text" name="placa" id="placa" maxlength="8" class="form-control" value="<?php echo $unidad->placa_unidad; ?>" disabled>
        </div>
        <div class="form-group">
            <label class="control-label" for="modelo">Descripci&oacute;n</label>
            <input type="text" name="modelo" id="modelo" class="form-control" value="<?php echo $unidad->modelo_unidad;?>" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-default">Limpiar</button>
        </div>
    </form>
</div> <!-- /#main_content -->
</div> <!-- /.row -->
<script>
    $("#modelo").focus();
</script>
<?php $this->load->view('admin/layout/footer') ?>