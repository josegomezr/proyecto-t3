<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">

    <form method="post">
        <div class="row clearfix">
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label class="control-label" for="cedula_chofer">Chofer</label>
                    <select name="cedula_chofer" id="cedula_chofer" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach ($choferes as $chofer): ?>
                            <option value="<?php echo $chofer->cedula_chofer ?>" <?php echo ($chofer->cedula_chofer == $salida->cedula_chofer) ? 'selected="selected"' : '' ?>><?php echo $chofer->nombre_chofer ?> <?php echo $chofer->apellido_chofer ?></option>
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
                            <option value="<?php echo $chofer->cedula_chofer ?>" <?php echo ($chofer->cedula_chofer == $salida->cedula_acompaniante) ? 'selected="selected"' : '' ?>><?php echo $chofer->nombre_chofer ?> <?php echo $chofer->apellido_chofer ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <?php endif ?>
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label class="control-label" for="id_recorrido">Recorridos</label>
                    <select name="id_recorrido" id="id_recorrido" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach ($recorridos as $recorrido): ?>
                            <option value="<?php echo $recorrido->id_recorrido ?>" <?php echo ($recorrido->id_recorrido == $salida->id_recorrido) ? 'selected="selected"' : '' ?>><?php echo $recorrido->nombre_recorrido ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label class="control-label" for="placa_unidad">Unidades</label>
                    <select name="placa_unidad" id="placa_unidad" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach ($unidades as $unidad): ?>
                            <option value="<?php echo $unidad->placa_unidad ?>" <?php echo ($unidad->placa_unidad == $salida->placa_unidad) ? 'selected="selected"' : '' ?>> <?php echo $unidad->modelo_unidad ?>(<?php echo $unidad->placa_unidad ?>)</option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label class="control-label" for="observacion">Observaci&oacute;n</label>
                    <textarea name="observacion" id="observacion" class="form-control" rows="5"><?php echo $salida->observacion_salida ?></textarea>
                </div>
            </div>
        </div>

            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                <button type="reset" class="btn btn-sm btn-default">Limpiar</button>
            </div>
    </form>
</div> <!-- /#main_content -->
</div> <!-- /.row -->
<script>
    $("#cedula_chofer").focus();
</script>
<?php $this->load->view('admin/layout/footer') ?>