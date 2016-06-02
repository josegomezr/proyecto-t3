<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">

    <form method="post">
        <div class="row clearfix">
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label class="control-label" for="id_conductor">Conductor</label>
                    <select name="id_conductor" id="id_conductor" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach ($conductores as $conductor): ?>
                            <option value="<?php echo $conductor->id_conductor ?>" <?php echo ($conductor->id_conductor == $salida->id_conductor) ? 'selected="selected"' : '' ?>><?php echo $conductor->nombre_conductor ?> <?php echo $conductor->apellido_conductor ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <?php if ($auth->nivel < 3): ?>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="id_acompaniante">Acompa&ntilde;ante</label>
                    <select name="id_acompaniante" id="id_acompaniante" class="form-control" data-msg-distinto="El acompa&ntilde;ante debe ser distinto del conductor.">
                        <option value="">Seleccione</option>
                        <?php foreach ($conductores as $conductor): ?>
                            <option value="<?php echo $conductor->id_conductor ?>" <?php echo ($conductor->id_conductor == $salida->id_acompaniante) ? 'selected="selected"' : '' ?>><?php echo $conductor->nombre_conductor ?> <?php echo $conductor->apellido_conductor ?></option>
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
                    <label class="control-label" for="id_unidad">Unidades</label>
                    <select name="id_unidad" id="id_unidad" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach ($unidades as $unidad): ?>
                            <option value="<?php echo $unidad->id_unidad ?>" <?php echo ($unidad->id_unidad == $salida->id_unidad) ? 'selected="selected"' : '' ?>> <?php echo $unidad->modelo_unidad ?>(<?php echo $unidad->placa_unidad ?>)</option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="id_tipo_incidencia">Tipo</label>
                    <select name="id_tipo_incidencia" id="id_tipo_incidencia" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach ($tipos_incidencia as $tipo_incidencia): ?>
                            <option value="<?php echo $tipo_incidencia->id_tipo_incidencia ?>" <?php echo $salida->id_tipo_incidencia == $tipo_incidencia->id_tipo_incidencia ? 'selected="selected"' : '' ?>><?php echo $tipo_incidencia->descripcion_tipo_incidencia ?></option>
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
                            <option data-parent="<?php echo $incidencia->id_tipo_incidencia ?>" value="<?php echo $incidencia->id_incidencia ?>" <?php echo $salida->id_incidencia == $incidencia->id_incidencia ? 'selected="selected"' : '' ?>><?php echo $incidencia->descripcion_incidencia ?></option>
                        <?php endforeach ?>
                    </select>
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