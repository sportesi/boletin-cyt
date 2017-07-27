<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
    <li data-target="#carousel-example-generic" data-slide-to="4"></li>
  </ol>

  <?php 
    $query = "SELECT N.id, N.title, N.link_1, N.link_2, N.link_3, SN.total, N.image_url FROM news N, (SELECT S.news_id, COUNT(*) total FROM (SELECT * FROM statistic ORDER BY date DESC) S GROUP BY S.news_id) SN WHERE N.id = SN.news_id ORDER BY N.date DESC LIMIT 5";
    $rs = $dbSetting->ExecuteQuery($query);
    $firstRow = true;
  ?>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <?php while ($row = mysql_fetch_assoc($rs)) { ?>
      <div class="item <?php echo $firstRow ? 'active' : '' ?>">
        <a href="<?php echo $row['link_1'] ?>" target="_blank">
          <img src="<?php echo $row['image_url'] ?>">
        </a>
        <div class="carousel-caption">
          <?php echo $row['title'] ?>
        </div>
      </div>
    <?php $firstRow = false; ?>
    <?php } ?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Anterior</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Siguiente</span>
  </a>
</div>