<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

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

  <script type="text/javascript" language="JavaScript" src="scripts/jquery/jquery.min.js"></script>
  <script type="text/javascript" language="JavaScript" src="controls/menu/ddsmoothmenu.js"></script>
  <script type="text/javascript" language="JavaScript" src="/scripts/home/home.js"></script>
  <link rel="stylesheet" type="text/css" href="style/css/general.css" media="screen"/>
  <link rel="stylesheet" type="text/css" href="controls/menu/ddsmoothmenu.css"/>
  <link rel="stylesheet" type="text/css" href="controls/menu/ddsmoothmenu-v.css"/>
  <link rel="stylesheet" type="text/css" href="controls/categories/css/categories.css"/>

</head>
<body>
  <div style="position:relative;">
    <div id="smoothmenu1" class="ddsmoothmenu"> </div>
  </div>

  <center>
    <div>
      <table>
        <tr valign="top">
          <td style="width:720px; text-align: left;">
            <h1>BOLETÍN CIENTÍFICIO - TECNOLÓGICO</h1>
            <div id="news" style="width:705px;">
              <?php require_once 'news/index_view.php'; ?>
            </div>
          </td>
          <td style="vertical-align: top; text-align: left;">
            <img src="/style/images/uai-logo.gif" id="Logo UAI"/><br/>
            <img src="/style/images/home_boleting.jpg" id="boleting"/><br/>
            <div style="text-decoration: underline;">
              <a href="/files/criterios_para_publicar.doc">
                <h2 style="padding: 10px; background: lightgrey; border-radius: 5px; box-shadow: 0px 0px 5px grey; ">Criterios para publicar</h2>
              </a>
            </div>
            <div><h2><strong>Categorias</strong></h2></div>
            <div id="categories"></div>
            <br/>
          </td>
        </tr>
        <tr>
          <td>
            <div id="pages_numbers"></div>
          </td>
          <td></td>
        </tr>
      </table>
    </div>
  </center>
</body>
</html>
