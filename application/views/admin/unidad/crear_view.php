<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">

        <form method="post">

            <div class="alert alert-info">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <p>Los campos marcados con <code><span class="required-mark"></span></code> son <strong>Obligatorios</strong></p>
            </div>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <p><?php echo lang($this->session->flashdata('error')); ?></p>
                </div>
            <?php endif ?>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group <?php echo isset($this->session->flashdata('form:errors')['placa']) ? 'has-error' : ''?>">
                        <label class="control-label required-mark " for="placa">Placa</label>
                        <input type="text" name="placa" id="placa" minlength="7" maxlength="7" autofocus class="form-control" required value="<?php echo Form\set_value('placa') ?>" data-rule-placa="true">
                        <p class="help-block"><?php echo isset($this->session->flashdata('form:errors')['placa']) ? lang($this->session->flashdata('form:errors')['placa']) : '' ?></p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">    
                    <div class="form-group <?php echo isset($this->session->flashdata('form:errors')['modelo']) ? 'has-error' : ''?>">
                        <label class="control-label required-mark" for="modelo">Descripci&oacute;n</label>
                        <input type="text" name="modelo" id="modelo" value="<?php echo Form\set_value('modelo') ?>" autofocus class="form-control" required minlength="4" maxlength="45">
                        <p class="help-block"><?php echo isset($this->session->flashdata('form:errors')['modelo']) ? lang($this->session->flashdata('form:errors')['modelo']) : '' ?></p>
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