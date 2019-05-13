<!DOCTYPE html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
  <?php foreach($datas as $data) : ?>
  <form action="<?php echo ACCESS_ROOT; ?>" method="POST">
      <ul>
        <li><span>会社名：</span><span><?php echo $data["companies_company"]; ?></span></li>
        <li><span>部署：</span><span><?php echo $data["customers_depart"]; ?></span></li>
        <li><span>名前：</span><span><?php echo $data["customers_name"]; ?></span><span>様</span></li>
        <li><span>名前ルビ：</span><span><?php echo $data["customers_name_ruby"]; ?></span><span>様</span></li>
        <li>
          <span>分類：</span><span><?php echo $data["customers_classification"]; ?></span>
        </li>
        <li>
          <span>担当者：</span>
          <select name="employee_id">
            <?php foreach($employees as $employee) : ?>
            <option value="<?php echo $employee["id"]; ?>"<?php if($data["employee_id"] == $employee["id"]){ echo "selected";} ?>><?php echo $employee["name"]; ?></option>
            <?php endforeach; ?>
          </select>
        </li>
        <li><span>電話番号：</span><span><?php echo $data["customers_tel"]; ?></span></li>
        <li>
          <span>メモ</span>
          <span><?php echo $data["customers_memo"]; ?></span>
        </li>
      </ul>
      <input type="hidden" name="customer_id" value="<?php echo $data["customer_id"]; ?>">
      <input type="hidden" name="employee_customer_id" value="<?php echo $data["employee_customer_id"]; ?>">
      <button type="submit">更新</button>
    </form>
  <?php endforeach ; ?>
    <footer>
      <ul>
        <li>
        <form action="/edit/customer/" method="GET">
          <button type="submit">戻る</button>
          <input type="hidden" name="employee_customer_id" value="<?php echo $data["employee_customer_id"]; ?>">
        </form>
        </li>
<!--        <li>
        <form action="/edit/customer/change/?employee_customer_id=<?php //echo $data["employee_customer_id"] ?>" method="POST">
          <button type="submit">担当者変更</button>
          <input type="hidden" name="employee_customer_id" value="<?php //echo $data["employee_customer_id"]; ?>">
        </form>
        </li>-->
      </ul>
    </footer> 
  </body>
</html>