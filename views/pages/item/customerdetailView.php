<!DOCTYPE html>
  <head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="/css/customerdetailstyle.css">
  </head>
  <body>
    <?php include(VIEW_ROOT . 'common/header.php'); ?>
    <div>
      <?php foreach ($datas as $data) : ?>
      <h3>
        <?php echo $data["companies_company"]; ?>
        <?php if($data["customers_depart"] != '') {echo '<span>' . $data["customers_depart"] . '</span>';} ?>
        <?php if($data["customers_name"] != '') {echo $data["customers_name"] . '(' . $data["customers_name_ruby"] . ')様';} else if($data["customers_name"] == '' && $data["customers_name_ruby"] != '') {echo $data["customers_name_ruby"] . '様';} ?>
      </h3>
      <ul>
        <?php foreach (CUSTOMERS as $customers_classification => $customer) : ?>
          <?php if($data["customers_classification"] == $customers_classification) {echo "<li><span>分類:</span>" . $customer . "</li>";} ?>
        <?php endforeach; ?>
        <?php if($data["customers_tel"] != '') {echo '<li><span>折返先電話番号:</span>' . $data["customers_tel"] . '</li>';} ?>
        <?php if($data["customers_memo"] != '') {echo '<li><span>メモ:</span>' . $data["customers_memo"] . '</li>';} ?>
        <li><span>担当者:</span><?php echo $data["employees_name"]; ?></li>
      </ul>
      <nav>
        <ul>
          <li class="nav_menu">
            <a href="/list/"><button type="button">戻る<button></a>
          </li>
          <li class="nav_menu">
            <form action="/edit/customer/" method="GET">
              <button type="submit">
                情報更新<input type="hidden" name="employee_customer_id" value="<?php echo $data["employee_customer_id"]; ?>"> 
              </button>
            </form>
          </li>
        </ul>
      </nav>      
      <?php endforeach; ?>
    </div>
  </body>
</html>