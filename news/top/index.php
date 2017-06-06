<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

//Queries
define('__QUERY_GET_MAX_COUNT_OF_LAST_VIEWERS_NEWS__', "SELECT MAX(SN.total) max 
  												   FROM news N, 
  												   		(SELECT S.news_id,
  												   				COUNT(*) total  
  												   		 FROM (SELECT * 
  												   		 	   FROM statistic 
  												   		 	   ORDER BY date DESC) S 
  												   		 	   GROUP BY S.news_id) SN 
  												    WHERE N.id = SN.news_id 
  												    ORDER BY N.date, 
  												    SN.total DESC limit 20");

define('__QUERY_GET_LAST_VIEWERS_NEWS__', "SELECT N.id,
  													N.title,
  													N.link_1,
  													N.link_2,
  													N.link_3,
  													SN.total
  											 FROM news N,
  											 	  (SELECT S.news_id,
  											 	  		  COUNT(*) total
  											 	   FROM (SELECT * 
  											 	   		 FROM statistic 
  											 	   		 ORDER BY date DESC) S 
  											 	   		 GROUP BY S.news_id) SN 
  											 	   	WHERE N.id = SN.news_id 
  											 	   	ORDER BY N.date DESC limit 20");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <?php
    //Get User to used in the title
    $title_description = '';
    $user_name = $session->GetSessionValue('login_user');

    if ($user_name != '') {
        $title_description = ' - Usuario: ' . $user_name;
    }
    echo '<title>EES - UAI - Noticia Tops ' . $title_description . '</title>';
    ?>
    <script type="text/javascript" language="JavaScript" src="/scripts/jquery/jquery.min.js"></script>
    <script type="text/javascript" language="JavaScript" src="/controls/isotope/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" language="JavaScript" src="/controls/isotope/jquery.isotope.min.js"></script>
    <script type="text/javascript" language="JavaScript" src="/controls/menu/ddsmoothmenu.js"></script>
    <script type="text/javascript" language="JavaScript" src="/news/top/script/top_news.js"></script>

    <link rel="stylesheet" type="text/css" href="/style/css/general.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu.css"/>
    <link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu-v.css"/>
    <link rel="stylesheet" type="text/css" href="/controls/isotope/css/style.css"/>

</head>
<body>

<div id="smoothmenu1" class="ddsmoothmenu"></div>

<center>
    <div style=" width: 800px; text-align: left;">

        <h1>Noticias Top</h1>

        <div id="container" class="super-list variable-sizes clearfix ">
            <?php
            try {

                $query = __QUERY_GET_MAX_COUNT_OF_LAST_VIEWERS_NEWS__;
                $rs = $dbSetting->ExecuteQuery($query);

                $row = mysql_fetch_assoc($rs);
                $total_max = $row["max"];

                $total_max = $total_max / 2;

                $query = __QUERY_GET_LAST_VIEWERS_NEWS__;
                $rs = $dbSetting->ExecuteQuery($query);

                for ($x = 0, $numrows = mysql_num_rows($rs); $x < $numrows; $x++) {
                    $row = mysql_fetch_assoc($rs);

                    $str = '';
                    $str = $str . '<div class="element ' . GetCSS() . '  ' . GetWithCSS(strlen($row["title"])) . '  ' . GetHeightCSS($total_max, $row["total"]) . ' ">';
                    $str = $str . '<p class="number">' . $row["total"] . '</p>';
                    $str = $str . '<h2 class="name2"><a style="color:#222" href=' . $row["link_1"] . '>' . $row["title"] . '</a></h2>';
                    $str = $str . '</div>';

                    echo $str;
                }

            } catch (Exception $e) {
                echo $e;
            }


            function GetCSS()
            {
                $CSSArray = array('alkaline-earth', 'actinoid', 'lanthanoid', 'transition', 'metalloid', 'post-transition', 'other', 'halogen', 'noble-gas');

                return $CSSArray[rand(0, 8)];
            }

            function GetWithCSS($length)
            {
                if ($length > 60) {
                    return "width2";
                } else {
                    return "";
                }
            }

            function GetHeightCSS($max, $value)
            {
                if ($max <= $value) {
                    return "height2  width2";
                } else {
                    return "";
                }
            }

            ?>

        </div>

        <div id="sites"></div>

        </section> <!-- #content -->

    </div>
</center>


<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-10081016-2']);
    _gaq.push(['_trackPageview']);

    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();

</script>
</body>
</html>