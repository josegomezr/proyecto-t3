<div class="row clearfix">
    <!-- sidebar -->
    <!-- cuando se ve en tlfs, abarca todo -->
    <!-- cuando se ve en 640x480, abarca 1/3 -->
    <!-- cuando se ve en >800x600, abarca 1/4 -->
    <div class="col-xs-12 col-sm-4 col-md-3 hidden-xs hidden-print" id="sidebar">
        <div class="panel-group" id="sidebar-panel">
          <div class="panel <?php echo $_controller == "home" ? 'panel-primary' : 'panel-default' ?>">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="<?php echo site_url('admin/home') ?>">
                        <i class="fa fa-home"></i> Inicio
                    </a>
                </h4>
            </div>
          </div>
        <div class="panel <?php echo in_array($_controller, array('salida', 'entrada')) ? 'panel-primary' : 'panel-default' ?>">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#sidebar-panel" href="#salida-collapse">
                            <i class="glyphicon glyphicon-log-out"></i> Salida
                        </a>
                    </h4>
                </div>
                
                <div id="salida-collapse" class="panel-collapse collapse <?php echo in_array($_controller, array('salida', 'entrada')) ? 'in' : '' ?>">
                    <ul class="list-group">
                        <a class="list-group-item <?php echo $_controller == 'salida' && ($_method == '' || $_method == 'index') ? 'active' : '' ?>" href="<?php echo site_url('admin/salida') ?>">Listar</a>
                        <a class="list-group-item <?php echo $_controller == 'salida' && $_method == 'crear' ? 'active' : '' ?>" href="<?php echo site_url('admin/salida/crear') ?>">Registrar Salida</a>
                    </ul>
                </div>
            </div> 
            <?php if ($auth->nivel == 1): ?>
            <div class="panel <?php echo in_array($_controller, array('conductor','dispositivo','unidad','recorrido','usuario', 'tipo_incidencia', 'incidencia')) ? 'panel-primary' : 'panel-default' ?>">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#sidebar-panel" href="#conductor-collapse">
                            <i class="fa fa-cog"></i> Mantenimiento
                        </a>
                    </h4>
                </div>

                <div id="conductor-collapse" class="panel-collapse collapse <?php echo in_array($_controller, array('conductor','dispositivo','unidad','recorrido','usuario', 'tipo_incidencia', 'incidencia')) ? 'in' : '' ?>">
                    
                    <ul class="list-group">
                        <a class="list-group-item <?php echo 
                            $_controller == 'conductor' ? 'active' : '' 
                        ?>" href="<?php echo site_url('admin/conductor') ?>">Conductores</a>
                        <a class="list-group-item <?php echo 
                            $_controller == 'dispositivo' ? 'active' : '' 
                        ?>" href="<?php echo site_url('admin/dispositivo') ?>">Dispositivos</a>
                        <a class="list-group-item <?php echo 
                            $_controller == 'incidencia' ? 'active' : '' 
                        ?>" href="<?php echo site_url('admin/incidencia') ?>">Incidencias</a>

                        <a class="list-group-item <?php echo 
                            $_controller == 'recorrido' ? 'active' : '' 
                        ?>" href="<?php echo site_url('admin/recorrido') ?>">Recorridos</a>
                        
                        <a class="list-group-item <?php echo 
                            $_controller == 'tipo_incidencia' ? 'active' : '' 
                        ?>" href="<?php echo site_url('admin/tipo_incidencia') ?>">Tipos Incidencias</a>

                        <a class="list-group-item <?php echo 
                            $_controller == 'unidad' ? 'active' : '' 
                        ?>" href="<?php echo site_url('admin/unidad') ?>">Unidades</a>
                        <a class="list-group-item <?php echo 
                            $_controller == 'usuario' ? 'active' : '' 
                        ?>" href="<?php echo site_url('admin/usuario') ?>">Usuarios</a>
                    </ul>
                </div>
            </div>
            <?php endif ?>  
            <div class="panel <?php echo $_controller == "reporte" ? 'panel-primary' : 'panel-default' ?>">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#sidebar-panel" href="#reporte-collapse">
                            <i class="fa fa-file-pdf-o"></i> Reportes
                        </a>
                    </h4>
                </div>
                <div id="reporte-collapse" class="panel-collapse collapse <?php echo $_controller == "reporte" ? 'in' : '' ?>">
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            <!-- <li>
                                <a target="_blank" href="<?php echo site_url("admin/home/test_map");?>">DEMO MAPA RUTA</a>
                            </li> -->
                            <li>
                                <a href="<?php echo site_url('admin/reporte/lista_conductores') ?>" target="_blank">Imprimir Listado de Conductores</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/reporte/lista_unidades') ?>" target="_blank">Imprimir Listado de Unidades</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/reporte/lista_recorridos') ?>" target="_blank">Imprimir Listado de Recorridos</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/reporte/lista_salidas') ?>">Listar Salidas</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        
        </div>
    </div> <!-- /#sidebar -->
