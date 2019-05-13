<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="/css/employeedetailstyle.css">
  </head>
  <body>
    <?php include(VIEW_ROOT . 'common/header.php'); ?>
    <div>
      <?php foreach ($datas as $data) : ?>
      <span><?php echo $data["name_ruby"]; ?></span>
      <h3>
        <?php echo $data["name"]; ?>
        <?php if($data["dispatch_flag"] == 1){ echo "<span>(派遣)</span>";} ?>
      </h3>
      <ul>
        <li>
        <?php foreach(OFFICES as $office_id => $office) : ?>
        <?php if($data["office"] == $office_id) {echo $office["word"];} ?>
        <?php endforeach; ?>
        </li>
        <li><?php echo $data["depart"]; ?></li>
        <?php if($data["memo"] != ""){ echo "<li>" . $data["memo"] . "</li>";} ?>
      </ul>
      <nav>
        <ul>
          <li class="nav_menu">
            <a href="/list/"><button type="button">戻る<button></a>
          </li>
          <li class="nav_menu">
            <form action="/edit/employee/" method="GET">
              <button type="submit">
                情報更新<input type="hidden" name="employees_id" value="<?php echo $data["employees_id"]; ?>"> 
              </button>
            </form>
          </li>
        </ul>
      </nav>
      <?php endforeach; ?>
    </div>
  </body>
</html>