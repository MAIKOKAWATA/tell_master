<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title></title>
    <style>

/* ラジオボタンを全て消す */
input[name="tab_item"] {
display: none;
}
/* 選択されているタブのコンテンツのみを表示 */
#sample01:checked ~ #sample01_content,
#sample02:checked ~ #sample02_content{
display: block;
}
/* 選択されているタブのスタイルを変える */
div.tabs-sample input:checked + .tab_item {
background-color: #000;
color: #fff;
}
/* タブ切り替え全体のスタイル（任意） */
div.tabs-sample {
text-align:center;
}
/* タブのスタイル（任意） */
.tab_item {
padding:10px 45px;
border: solid #000 1px;
background-color: #fff;
font-size: 18px;
text-align: center;
line-height:1em;
color: #333;
display:inline-block;
font-weight: bold;
transition: all 0.2s ease;
margin:0;
}
.tab_item:hover {
opacity: 0.75;
}
/* タブ切り替えの中身のスタイル（任意） */
.tab_content {
display: none; /* ←のみ必ず必要 */
border-top:solid #ccc 1px;
margin:50px 0 0;
padding:25px;
}

    </style>
  </head>
  <body>
    <div class="tabs-sample">
      <!-- ↓切り替え用タブ（ラジオボタン） -->
      <input id="sample01" type="radio" name="tab_item" checked>
        <label class="tab_item" for="sample01">社員登録</label>
      <input id="sample02" type="radio" name="tab_item">
        <label class="tab_item" for="sample02">クライアント登録</label>
      <!-- ↓切り替わり要素（sample01） -->
        <div class="tab_content" id="sample01_content">
        <!-- ↓切り替わり要素（sample01）の内容が入ります -->
        <form action="<?php echo ACCESS_ROOT; ?>" method="POST">
          <ul>
            <li>
              <span>名前：</span><input type="text" name="name" value="">
            </li>
            <li>
              <span>名前ルビ：</span><input type="text" name="name_ruby" value="">
            </li>
            <li>
              <span>勤務オフィス：</span>
                <select name="office">
                  <?php foreach (OFFICES as $office_id => $office) : ?>
                  <option value="<?php echo $office_id; ?>"><?php echo $office["word"]; ?></option>
                  <?php endforeach; ?>
                </select>
            </li>
            <li>
              <span>部署：</span>
                <select name="depart_id">
                  <option value="">関連会社名または部署名を選択</option>
                  <?php foreach($departs as $depart) : ?>
                  <option value="<?php echo $depart["departs_id"]; ?>"><?php echo $depart["depart"]; ?></option>
                  <?php endforeach; ?>
                </select>
            </li>
            <li>
                <span>雇用形態（派遣かどうか）：</span>
                <label><input type="checkbox" name="dispatch_flag" value="1">派遣</label>
            </li>
            <li>
              <span>メールアドレス：</span><input type="text" name="mail_address" value="">
              <span>@</span>
              <select name="mail_domain">
                <option value="petabit.co.jp">petabit.co.jp</option>
                <option value="pr.petabit.co.jp">pr.petabit.co.jp</option>
                <option value="marketing.petabit.co.jp">marketing.petabit.co.jp</option>
                <option value="10-15.petabit.co.jp">10-15.petabit.co.jp</option>
                <option value="bottom-up.jp">bottom-up.jp</option>
                <option value="petabit-global.com">petabit-global.com</option>
              </select>
            </li>
            <li>
              <span>転送用メールアドレス：</span><input type="text" name="individual_mail_address" value="">
            </li>
            <li>
              <span>slack：</span><span>@</span><input type="text" name="slack_account" value="">
            </li>
            <li>
              <span>メモ：</span><textarea name="memo" value=""></textarea>
            </li>
            <li>
              <button type="submit">登録する</button>
            </li>
            <input type="hidden" name="employee">
          </ul>
        </form>
        </div>
        <!-- ↓切り替わり要素（sample02） -->
        <div class="tab_content" id="sample02_content">
        <!-- ↓切り替わり要素（sample02）の内容が入ります -->
        <form action="<?php echo ACCESS_ROOT; ?>" method="POST">
          <ul>
            <li>
              <span>会社名：</span><input type="text" name="company" value="">
            </li>
            <li>
              <span>会社名ルビ：</span><input type="text" name="company_ruby" value="">
            </li>
            <li>
              <span>部署：</span><input type="text" name="depart" value="">
            </li>
            <li>
              <span>お名前：</span><input type="text" name="name" value="">
            </li>
            <li>
              <span>お名前ルビ：</span><input type="text" name="name_ruby" value="">
            </li>
            <li>
              <span>電話番号：</span><input type="text" name="tel" value="">
            </li>
            <li>
              <span>分類：</span>
              <select name="classification">
                <?php foreach (CUSTOMERS as $customers_classification => $customer) : ?>
                <option value="<?php echo $customers_classification; ?>"><?php echo $customer; ?></option>
                <?php endforeach; ?>
              </select>
            </li>
            <li>
              <span>担当者：</span>
              <select name="employee_id">
                <?php foreach($employees as $employee) : ?>
                <option value="<?php echo $employee["id"]; ?>"><?php echo $employee["name"]; ?></option>
                <?php endforeach; ?>
              </select>
            </li>
            <li>
              <span>メモ：</span><textarea name="memo" value=""></textarea>
            </li>
            <li>
              <button type="submit">登録する</button>
            </li>
            <input type="hidden" name="customer">
          </ul>
        </form>
        </div>
    </div>
    <ul>
      <li>
        <a href="/list/"><button type="button">戻る</button></a>
      </li>
    </ul>
  </body>
</html>