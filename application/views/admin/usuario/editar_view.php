<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">

    <form method="post">
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-6">
                <div class="form-group <?php echo Form\has_error('login_usuario') ? 'has-error' :'' ?>">
                    <label class="control-label" for="login_usuario">Nombre de usuario</label>
                    <input type="text" name="login_usuario" id="login_usuario" disabled class="form-control" required value="<?php echo Form\set_value('login_usuario', $usuario->login_usuario) ?>">
                    <p class="help-block"><?php echo lang(Form\get_error('login_usuario')) ?></p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group <?php echo Form\has_error('nivel_usuario') ? 'has-error' :'' ?>">
                    <label class="control-label required-mark" for="nivel_usuario">Nivel</label>
                    <select name="nivel_usuario" id="nivel_usuario" class="form-control">
                        <?php foreach ($niveles_usuario as $id => $value): ?>
                            <option value="<?php echo $id ?>" <?php echo $id == $usuario->nivel_usuario ? 'selected="selected"' : '' ?>><?php echo $value ?></option>
                        <?php endforeach ?>
                    </select>
                    <p class="help-block"><?php echo lang(Form\get_error('nivel_usuario')) ?></p>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-6">
                <div class="form-group <?php echo Form\has_error('password') ? 'has-error' :'' ?>">
                    <label class="control-label" for="password">Contrase&ntilde;a</label>
                    <input type="password" name="password" id="password" class="form-control" required value="">
                    <p class="help-block"><?php echo lang(Form\get_error('password')) ?></p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group <?php echo Form\has_error('password_repeat') ? 'has-error' :'' ?>">
                    <label class="control-label" for="password_repeat">Repita la Contrase&ntilde;a</label>
                    <input type="password" name="password_repeat" id="password_repeat" class="form-control" required value="">
                    <p class="help-block"><?php echo lang(Form\get_error('password_repeat')) ?></p>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-default">Limpiar</button>
        </div>
    </form>
</div> <!-- /#main_content -->
</div> <!-- /.row -->
<script>
    $("#login_usuario").focus();
</script>
<?php $this->load->view('admin/layout/footer') ?>