<?php 
$menuItems = ['Awards' => ['Region', 'User', 'Date'], 'Users' => ['Region', 'Date']];

function makeMenu($first, $second, $menuItems) {
  ?>
  <div class="">
    <div class="btn-group">
      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo $first ?> <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <?php foreach($menuItems as $key => $value) {
          if ($key == $first) continue;
          echo '<li><a href="analytics.php?first=' . $key . '">' . $key . '</a></li>';
        }
        ?>
      </ul>
    </div>
    &nbsp;&nbsp;by&nbsp;&nbsp;  
    <div class="btn-group">
      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo $second ?> <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <?php foreach($menuItems[$first] as $value) {
          if ($value == $second) continue;
          echo '<li><a href="analytics.php?first=' . $first . '&second=' . $value . '">' . $value . '</a></li>';
        }
        ?>
      </ul>
    </div>
  </div>
<?php
}
?>
