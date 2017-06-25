<?php

$category_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "category"));
$user_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "user_id"));
$news_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "id"));
$offset = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "offset"));
$pageperview = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "pageperview"));

$query = "SELECT N.id,N.user_id, CONCAT_WS(',',U.firstname,NULL,U.lastname) 'fullname', C.id 'campus_id', C.name 'campus', U.year 'year_coursed', T.id 'turn_id', T.name 'turn', U.comission 'comission', N.title, N.sub_title, N.summary, N.sub_summary, N.image_url, N.image_comment, N.category_id, Cat.name 'category', N.link_1, N.link_2, N.link_3, N.date FROM news N, user U, category Cat, campus C, turn T WHERE N.category_id = Cat.id AND N.user_id = U.id AND U.campus_id = C.id AND U.turn_id = T.id";

if ($category_id != '') { $query = $query . " AND N.category_id =" . $category_id; }
if ($user_id != '') { $query = $query . " AND N.user_id=" . $user_id; }
if ($news_id != '') { $query = $query . " AND N.id=" . $news_id; }

$query = $query . " ORDER BY N.date DESC";
$query = $query . " LIMIT " . ($offset ?: 0) . " , " . ($pageperview ?: 10) . " ";
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
  <table>
    <tr>
      <td collspan="2" style="width: 2px; background-color: black;"> </td>
      <td>
        <table style="width:100%;" border="0" cellspacing="0" cellpadding="0">
          <td>
            <tr valign="top">
              <td style="width:150px;">
                <img style="width:150px;"
                src="<?php echo $data['image_url']; ?>"
                alt="<?php echo $data['image_comment']; ?>"
                onerror="ChangeImg(this);"/>
              </td>
              <td valign="top">
                <table>
                  <tr><td style="width:700px;"><strong><font size="6"><?php echo $data['title']; ?></font></strong></td></tr>
                  <tr><td style="width:700px;"><font size="4"><?php echo $data['sub_title']; ?></font></td></tr>
                  <tr><td style="width:700px;"><?php echo $data['sub_summary']; ?></td></tr>
                  <tr><td style="width:700px;"><?php echo $data['summary']; ?></td></tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
        <td>
          <table style="width:700px;" border="0" cellspacing="0" cellpadding="0">
            <tr style="background: #dcdad5">
              <td>
                <table border="0"  style="width:700px;" cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="width:20%;"><strong>Links de referencia:</strong> &nbsp;&nbsp;&nbsp;</td>
                    <td style="width:20%;text-align: left;">
                      <a href="/news/preview/preview.php?news_id=<?php echo $data['id']; ?>&link=1" target="_blank">
                        <strong>Nota Completa </strong>&nbsp;&nbsp;&nbsp;
                      </a>
                    </td>
                    <td style="width:20%;text-align: left;">
                      <a href="/news/preview/preview.php?news_id=<?php echo $data['id']; ?>&link=2" target="_blank">
                        <strong>Relacionado</strong> &nbsp;&nbsp;&nbsp;
                      </a>
                    </td>
                    <td style="width:20%;text-align: left;">
                      <a href="/news/preview/preview.php?news_id=<?php echo $data['id']; ?>&link=3" target="_blank">
                        <strong>Formato PDF </strong> &nbsp;&nbsp;&nbsp;
                      </a>
                    </td>
                    <td style="width:100%;"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </td>
        </tr>
        <tr>
          <td>
            <table border="0"  style="width:700px;" cellspacing="0" cellpadding="0">
              <tr style="background: #d0e5b3">
                <td>
                  <strong>Autor:</strong>&nbsp;
                  <a href="user/statistics/index.php?id=<?php echo $data['user_id']; ?>">
                    <?php echo $data['fullname'];  ?>
                  </a> &nbsp; &nbsp; &nbsp;
                </td>
                <td> <strong>Año:</strong>&nbsp; <?php echo $data['year_coursed']; ?> &nbsp; &nbsp; &nbsp;</td>
                <td> <strong>Localización:</strong>&nbsp; <?php echo $data['campus']; ?> &nbsp; &nbsp; &nbsp;</td>
                <td> <strong>Turno:</strong>&nbsp; <?php echo $data['turn']; ?> &nbsp; &nbsp; &nbsp;</td>
                <td ><strong>Comisión:</strong>&nbsp; <?php echo $data['comission']; ?></td>
                <td ><strong>Fecha:</strong>&nbsp; <?php echo $data['date']; ?></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td collspan="2" style="width: 2px; background-color: #D8D8D8;">
    </td>
  </tr>
</table>

<br/>
<br/>
<?php } ?>
