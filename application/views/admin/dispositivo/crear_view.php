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
                    <div class="form-group">
                        <label class="control-label required-mark " for="id_dispositivo">Dispositivo</label>
                        <input class="form-control" type="text" readonly id="id_dispositivo" value="<?php echo rand() % 1000 ?>" name="id_dispositivo">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class="control-label required-mark " for="placa_unidad">Unidad</label>
                        <select name="placa_unidad" required class="form-control" id="placa_unidad">
                            <option value="">Seleccione Unidad</option>
                            <?php foreach ($unidades as $unidad): ?>
                                <option value="<?php echo $unidad->placa_unidad ?>"><?php echo $unidad->modelo_unidad ?> (<?php echo $unidad->placa_unidad ?>)</option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class="control-label required-mark " for="id_recorrido">Recorrido</label>
                        <select name="id_recorrido" required class="form-control" id="id_recorrido">
                            <option value="">Seleccione Recorrido</option>
                            <?php foreach ($recorridos as $recorrido): ?>
                                <option value="<?php echo $recorrido->id_recorrido ?>"><?php echo $recorrido->nombre_recorrido ?></option>
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