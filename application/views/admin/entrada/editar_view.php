<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">

    <form method="post">
        <div class="row clearfix">
            <?php if ($salida->id_conductor): ?>
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label class="control-label" for="cedula_conductor">Chofer</label>
                    <input class="form-control" type="text" disabled id="cedula_conductor" value="<?php echo $chofer->nombre_conductor ?> <?php echo $chofer->apellido_conductor ?>">
                </div>
            </div>
        	<?php else: ?>
            <div class="col-xs-12 col-md-6">
                <div class="form-group has-error">
                    <label>Salida no Notificada</label>
                    <span disabled class="form-control">Creada por dispositivo!</span>
            	</div>
            </div>
			<?php endif ?>
            <?php if (isset($acompaniante)): ?>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="cedula_acompaniante">Chofer</label>
                        <input class="form-control" type="text" disabled id="cedula_acompaniante" value="<?php echo $acompaniante->nombre_conductor ?> <?php echo $acompaniante->apellido_conductor ?>">
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
            <div class="clearfix"></div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="id_tipo_incidencia">Tipo</label>
                    <select name="id_tipo_incidencia" id="id_tipo_incidencia" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach ($tipos_incidencia as $tipo_incidencia): ?>
                            <option value="<?php echo $tipo_incidencia->id_tipo_incidencia ?>" <?php echo $entrada->id_tipo_incidencia == $tipo_incidencia->id_tipo_incidencia ? 'selected="selected"' : '' ?>><?php echo $tipo_incidencia->descripcion_tipo_incidencia ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="id_incidencia">Incidencia</label>
                    <select name="id_incidencia" id="id_incidencia" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach ($incidencias as $incidencia): ?>
                            <option data-parent="<?php echo $incidencia->id_tipo_incidencia ?>" value="<?php echo $incidencia->id_incidencia ?>" <?php echo $entrada->id_incidencia == $incidencia->id_incidencia ? 'selected="selected"' : '' ?>><?php echo $incidencia->descripcion_incidencia ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="form-group">
                    <label class="control-label" for="comentario_entrada_incidencia">Detalles Adicionales</label>
                    <textarea name="comentario_entrada_incidencia" id="comentario_entrada_incidencia" rows="3" class="form-control"><?php echo $entrada->comentario_entrada_incidencia ?></textarea>
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
jQuery(function($) {
    $('#id_incidencia').find('option').slice(1).not(':selected').addClass('hidden');
    $("form").validate({
        rules: {
            id_acompaniante: {
                distinto: {
                    param : function () {
                        return $("#id_conductor").val();
                    }
                }
            }
        }
    });

    $('#id_tipo_incidencia').on('change', function (e) {
        var $incidencia = $('#id_incidencia')
        if (!e.target.value) {
            $incidencia.attr('disabled', 'disabled');
        }else{
            $incidencia.removeAttr('disabled');
        }

        $incidencia
            .val('')
            .find('option[data-parent]')
            .addClass('hidden')
            .filter('[data-parent='+e.target.value+']')
            .removeClass('hidden')


    })
});
</script>
<?php $this->load->view('admin/layout/footer') ?>