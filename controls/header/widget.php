<?php
$categoryIdName = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "category"));
$categoryName = null;
if ($categoryIdName) {
    $catResult = $dbSetting->ExecuteQuery("SELECT name FROM category where id = $categoryIdName");
    $categoryName = "Categoría: " . mysql_fetch_assoc($catResult)['name'];
}
?>
<?php $sectionName = ($categoryName) ?: 'Últimas Noticias'; ?>
<div class="section-header">
    <?php if (filter_input(INPUT_GET, 'register_success') === 'true'): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p>Gracias por registrarte en el <b>Boletín Científico - Tecnológico</b> de la <b>UAI</b></p>
                    <p>Cuando un profesor valide tus datos, vas a poder publicar en este sitio.</p>
                </div>
            </div>
        </div>
    <?php endif ?>
    <?php if (filter_input(INPUT_GET, 'change-password') === 'success'): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p>Tu <b>contraseña</b> ha sido cambiada con éxito</p>
                </div>
            </div>
        </div>
    <?php endif ?>
    <div class="row">
        <div class="col-md-9">
            <h3><?php echo $sectionName; ?></h3>
        </div>
        <div class="col-md-3" style="padding-right: 0;">
            <img src="/style/images/uai-vertical.png" style="width: 100%;" id="Logo UAI"/><br/>
        </div>
    </div>
</div>