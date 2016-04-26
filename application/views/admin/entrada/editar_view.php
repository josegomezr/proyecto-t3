<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">

    <form method="post">
        <div class="row clearfix">
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label class="control-label" for="cedula_chofer">Chofer</label>
                    <input class="form-control" type="text" disabled id="cedula_chofer" value="<?php echo $chofer->nombre_chofer ?> <?php echo $chofer->apellido_chofer ?>">
                </div>
            </div>

            <?php if (isset($acompaniante)): ?>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="cedula_acompaniante">Chofer</label>
                        <input class="form-control" type="text" disabled id="cedula_acompaniante" value="<?php echo $acompaniante->nombre_chofer ?> <?php echo $acompaniante->apellido_chofer ?>">
                    </div>
                </div>
            <?php endif ?>
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label class="control-label" for="id_recorrido">Recorrido</label>
                    <input class="form-control" type="text" disabled id="id_recorrido" value="<?php echo $recorrido->nombre_recorrido ?>">
                </div>
            </div>
        
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label class="control-label" for="placa_unidad">Unidades</label>
                    <input class="form-control" type="text" disabled id="placa_unidad" value="<?php echo $unidad->modelo_unidad ?>(<?php echo $unidad->placa_unidad ?>)">
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label class="control-label" for="observacion">Observaci&oacute;n</label>
                    <textarea name="observacion" id="observacion" class="form-control" rows="5"><?php echo $entrada->observacion_entrada ?></textarea>
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