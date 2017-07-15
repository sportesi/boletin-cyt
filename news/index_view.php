<?php

$category_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "category"));
$user_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "user_id"));
$news_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "id"));
$offset = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "offset"));
$pageperview = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "pageperview"));
$search = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "search"));

$query = "SELECT N.id,N.user_id, CONCAT_WS(', ',U.firstname,U.lastname) 'fullname', C.id 'campus_id', C.name 'campus', U.year 'year_coursed', T.id 'turn_id', T.name 'turn', U.comission 'comission', N.title, N.sub_title, N.summary, N.sub_summary, N.image_url, N.image_comment, N.category_id, Cat.name 'category', N.link_1, N.link_2, N.link_3, N.date FROM news N, user U, category Cat, campus C, turn T WHERE N.category_id = Cat.id AND N.user_id = U.id AND U.campus_id = C.id AND U.turn_id = T.id";

if (!empty($category_id)) { $query = $query . " AND N.category_id = " . $category_id; }
if (!empty($user_id)) { $query = $query . " AND N.user_id = " . $user_id; }
if (!empty($news_id)) { $query = $query . " AND N.id = " . $news_id; }
if (!empty($search)) {
  $query = $query . " AND (N.title like '%".$search."%'";
  $query = $query . " OR N.sub_title like '%".$search."%'";
  $query = $query . " OR N.summary like '%".$search."%'";
  $query = $query . " OR N.sub_summary like '%".$search."%')";
}

$query = $query . " ORDER BY N.date DESC";
$query = $query . " LIMIT " . ($offset ?: 0) . " , " . ($pageperview ?: 3) . " ";
$rs = $dbSetting->ExecuteQuery($query);
$result = array();

for ($x = 0, $numrows = mysql_num_rows($rs); $x < $numrows; $x++) {
  $row = mysql_fetch_assoc($rs);

  $result[$x] = array(
    "id" => $row["id"],
    "user_id" => $row["user_id"],
    "fullname" => $row["fullname"],
    "campus_id" => $row["campus_id"],
    "campus" => $row["campus"],
    "year_coursed" => $row["year_coursed"],
    "turn_id" => $row["turn_id"],
    "turn" => $row["turn"],
    "comission" => $row["comission"],
    "title" => $row["title"],
    "sub_title" => $row["sub_title"],
    "summary" => $row["summary"],
    "sub_summary" => $row["sub_summary"],
    "image_url" => $row["image_url"],
    "image_comment" => $row["image_comment"],
    "category_id" => $row["category_id"],
    "category" => $row["category"],
    "link_1" => $row["link_1"],
    "link_2" => $row["link_2"],
    "link_3" => $row["link_3"],
    "date" => $row["date"]
  );
}

?>

<?php foreach ($result as $data) { ?>

  <div class="panel panel-info">
    <div class="panel-body no-padding">
      <div class="col-md-3">
        <img class="img-thumbnail" src="<?php echo $data['image_url']; ?>" onerror="ChangeImg(this);"/>
      </div>
      <div class="col-md-9">
        <div class="panel panel-info">
          <div class="panel-heading">
            <b> <?php echo htmlentities($data['title'], ENT_QUOTES, 'utf-8'); ?> </b>
          </div>
          <div class="panel-body">
            <p>
              <?php echo htmlentities($data['sub_summary'], ENT_QUOTES, 'utf-8'); ?>
            </p>
            <p>
              <?php echo htmlentities($data['summary'], ENT_QUOTES, 'utf-8'); ?>
            </p>
            <div class="text-center">
              <?php if (!empty($data['link_1'])): ?>
                <a href="/news/preview/preview.php?news_id=<?php echo $data['id']; ?>&link=1" class="btn btn-info btn-sm" target="_blank">Nota Completa</a>
              <?php endif; ?>
              <?php if (!empty($data['link_2'])): ?>
                <a href="/news/preview/preview.php?news_id=<?php echo $data['id']; ?>&link=2" class="btn btn-info btn-sm" target="_blank">Relacionado</a>
              <?php endif; ?>
              <?php if (!empty($data['link_3'])): ?>
                <a href="/news/preview/preview.php?news_id=<?php echo $data['id']; ?>&link=3" class="btn btn-info btn-sm" target="_blank">Formato PDF</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="panel-footer">
      <div class="row">
        <div class="col-md-5">
          <strong>Autor:&nbsp;</strong>
          <a href="/user/statistics/index.php?id=<?php echo $data['user_id']; ?>">
            <?php echo htmlentities($data['fullname'], ENT_QUOTES, 'utf-8'); ?>
            (
            <?php echo htmlentities($data['year_coursed'], ENT_QUOTES, 'utf-8'); ?>
            <?php echo htmlentities($data['comission'], ENT_QUOTES, 'utf-8'); ?>
            -
            <?php echo htmlentities($data['turn'], ENT_QUOTES, 'utf-8'); ?>
            )
          </a>
        </div>
        <div class="col-md-3 text-center">
          <strong>Sede:&nbsp;</strong>
          <?php echo htmlentities($data['campus'], ENT_QUOTES, 'utf-8'); ?>
        </div>
        <div class="col-md-4 text-right">
          <strong>Fecha:&nbsp;</strong>
          <?php echo htmlentities($data['date'], ENT_QUOTES, 'utf-8'); ?>
        </div>
      </div>
    </div>
  </div>

<?php } ?>
