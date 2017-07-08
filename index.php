<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once __ROOT__ . '/common/session/Session.php';
require_once __ROOT__ . '/common/DataAccess/DBSecurityConnections.php';

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=8"/>
  <meta name="description"
  content="Electromagnetismo y Estado Solido Universidad Abierta Internacional, EES UAI Joaquin Abraham Wessolowski, oftware, Seguridad Informatica, Salud , Robótica e Inteligenia Artificial,Politicas y Ética, Periféricos y Auxiliares, Otros, Nanotecnologia, Matematica y Lógica, IT & Infraestuctura Informatica, Fuentes RRS varias, Fisica y Quimica, Comunicaciones, Computación Cuantica, Circuitos Integrados, Almacenamiento y Memorias "/>
  <meta name="keywords"
  content="Software, Seguridad Informatica, Salud , Robótica e Inteligenia Artificial,Politicas y Ética, Periféricos y Auxiliares, Otros, Nanotecnologia, Matematica y Lógica, IT & Infraestuctura Informatica, Fuentes RRS varias, Fisica y Quimica, Comunicaciones, Computación Cuantica, Circuitos Integrados, Almacenamiento y Memorias "/>

  <title>EES - UAI - BOLETIN</title>

  <script type="text/javascript" language="JavaScript" src="/node_modules/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="/node_modules/bootstrap/dist/js/bootstrap.min.js" > </script>
  <script type="text/javascript" language="JavaScript" src="/scripts/home/home.js"></script>
  <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/node_modules/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="style/css/general.css" media="screen"/>
</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="page-header">
          <?php require_once 'controls/menu/menu_nav.php'; ?>
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
            <div class="row">
              <div class="col-md-9">
                <h3><?php echo $sectionName; ?></h3>
              </div>
              <div class="col-md-3" style="padding-right: 0;">
                <img src="/style/images/uai-vertical.png" style="width: 100%;" id="Logo UAI"/><br/>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div id="news">
          <?php require_once 'news/index_view.php'; ?>
        </div>
        <?php require_once 'controls/php-pagination/widget.php'; ?>
      </div>
      <div class="col-md-3 text-center">
        <div class="panel panel-info">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <?php require_once 'controls/search/widget.php'; ?>
              </div>
              <div class="col-md-12">
                <a href="/files/criterios_para_publicar.doc" class="btn btn-primary"> Criterios para publicar </a>
              </div>
              <div class="col-md-12">
                <div><h2><strong>Categorias</strong></h2></div>
                <div id="categories" class="text-left"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
