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