<!DOCTYPE html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
  <?php foreach($datas as $data) : ?>
    <form action="<?php echo ACCESS_ROOT; ?>" method="POST">
      <ul>
        <?php //foreach($datas as $data) : ?>
        <li><span>名前：</span><input type="text" name="name" value="<?php echo $data["name"]; ?>"></li>
        <li><span>名前ルビ：</span><input type="text" name="name_ruby" value="<?php echo $data["name_ruby"]; ?>"></li>
        <li>
          <span>勤務オフィス</span>
          <select name="office">
            <?php foreach (OFFICES as $office_id => $office) : ?>
            <option value="<?php echo $office_id; ?>"<?php if($data["office"] == $office_id){ echo "selected";} ?>><?php echo $office["word"]; ?></option>
            <?php endforeach; ?>
          </select>
        </li>
        <li>
          <span>部署：</span>
          <select name="depart_id">
            <?php foreach($departs as $depart) : ?>
            <option value="<?php echo $depart["departs_id"]; ?>"<?php if($data["departs_id"] == $depart["departs_id"]){ echo "selected";} ?>><?php echo $depart["depart"]; ?></option>
            <?php endforeach; ?>
          </select>
        </li>
        <li>
          <span>雇用形態（派遣かどうか）：</span>
          <label><input type="checkbox" name="dispatch_flag" value="1" <?php if($data["dispatch_flag"] == 1){echo "checked=checked";} ?>>派遣</label>
        </li>
        <li>
          <span>メモ</span>
          <textarea name="memo"><?php echo $data["memo"]; ?></textarea>
        </li>
        <li><span>メールアドレス</span><input type="text" name="mail_address" value="<?php echo $data["mail_address"]; ?>"></li>
        <li><span>転送先メールアドレス</span><input type="text" name="individual_mail_address" value="<?php echo $data["individual_mail_address"]; ?>"></li>
        <li><span>slack:</span><input type="text" name="slack_account" value="<?php echo $data["slack_account"]; ?>"></li>
        <input type="hidden" name="employees_id" value="<?php echo $data["employees_id"]; ?>">
        <?php //endforeach ; ?>
      </ul>
      <button type="submit">更新</button>
    </form>
  <?php endforeach; ?>
    <footer>
      <ul>
        <li>
        <form action="/detail/employee/" method="GET">
          <button type="submit">戻る</button>
          <input type="hidden" name="employees_id" value="<?php echo $data["employees_id"]; ?>">
        </form>
        </li>
        <li>
        <form action="/edit/employee/retire/" method="GET">
          <button type="submit">
            退職<input type="hidden" name="employees_id" value="<?php echo $data["employees_id"]; ?>">
          </button>
        </form>
        </li>
      </ul>
    </footer>
  </body>
</html>