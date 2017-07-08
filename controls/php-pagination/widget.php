<nav aria-label="...">
  <ul class="pager">
    <?php 
      $parameters = array();
      $offset = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "offset"));
      if (!empty($category_id)) { $parameters['category'] = 'category=' . $category_id; }
      if (!empty($search)) { $parameters['search'] = 'search=' . $search; }
      $parameters['offset'] = 'offset=' . ($offset + 3);
      $next = '/?' . implode('&', $parameters);
      $parameters['offset'] = 'offset=' . ($offset - 3);
      $previous = '/?' . implode('&', $parameters);
      $parameters['offset'] = 'offset=0';
      $first = '/?' . implode('&', $parameters);
    ?>
    <?php if ($offset > 0): ?>
      <li class="previous">
        <a href="<?php echo $first; ?>">
          <i class="fa fa-angle-double-left"></i> Inicio
        </a>
      </li>
    <?php endif ?>
    <li class="previous <?php echo ($offset ?: "disabled") ?>">
      <a href="<?php echo $previous; ?>">
        <i class="fa fa-angle-left"></i> Anterior
      </a>
    </li>
    <li class="next <?php echo (sizeof($result) ?: "disabled") ?>">
      <a href="<?php echo $next; ?>">
        Siguiente <i class="fa fa-angle-right"></i>
      </a>
    </li>
  </ul>
</nav>