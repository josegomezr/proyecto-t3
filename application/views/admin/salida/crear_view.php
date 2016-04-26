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
                        <label class="control-label required-mark" for="cedula_chofer">Chofer</label>
                        <select name="cedula_chofer" id="cedula_chofer" autofocus class="form-control" required>
                            <option value="">Seleccione</option>
                            <?php foreach ($choferes as $chofer): ?>
                                <option value="<?php echo $chofer->cedula_chofer ?>"><?php echo $chofer->nombre_chofer ?> <?php echo $chofer->apellido_chofer ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <?php if ($auth->nivel < 3): ?>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="cedula_acompaniante">Acompa&ntilde;ante</label>
                        <select name="cedula_acompaniante" id="cedula_acompaniante" class="form-control" data-msg-distinto="El acompa&ntilde;ante debe ser distinto del chofer.">
                            <option value="">Seleccione</option>
                            <?php foreach ($choferes as $chofer): ?>
                                <option value="<?php echo $chofer->cedula_chofer ?>"><?php echo $chofer->nombre_chofer ?> <?php echo $chofer->apellido_chofer ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <?php endif ?>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class="control-label required-mark" for="id_recorrido">Recorridos</label>
                        <select name="id_recorrido" id="id_recorrido" autofocus class="form-control" required>
                            <option value="">Seleccione</option>
                            <?php foreach ($recorridos as $recorrido): ?>
                                <option value="<?php echo $recorrido->id_recorrido ?>"><?php echo $recorrido->nombre_recorrido ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class="control-label required-mark" for="placa_unidad">Unidades</label>
                        <select name="placa_unidad" id="placa_unidad" autofocus class="form-control" required>
                            <option value="">Seleccione</option>
                            <?php foreach ($unidades as $unidad): ?>
                                <option value="<?php echo $unidad->placa_unidad ?>"><?php echo $unidad->modelo_unidad ?>(<?php echo $unidad->placa_unidad ?>)</option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class="control-label" id="observacion">Observaciones</label>
                        <textarea class="form-control no-resize" resize="no" rows="5" maxlength="300" requiered autofocus name="observacion" id="observacion"></textarea>
                    </div>
                </div>
            </div>
            

            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                <button type="reset" class="btn btn-sm btn-default">Limpiar</button>
            </div>
        </form>

<div class="clearfix"></div>
</div> <!-- /#main_content -->
</div> <!-- /.row -->
<script>
jQuery(function($) {
    $("form").validate({
        rules: {
            cedula_acompaniante: {
                distinto: {
                    param : function () {
                        return $("#cedula_chofer").val();
                    }
                }
            }
        }
    });
});
</script>
<?php $this->load->view('admin/layout/footer') ?>