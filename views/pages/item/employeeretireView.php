<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php foreach ($responsible_datas as $responsible_data) : ?>
        <?php //if($customer["customers_id"] != "") : ?>
            <span>下記のクライアントを社員に引き継ぎ、<?php echo $responsible_data["employees_name"]; ?>さんを退職に変更します。よろしいですか？</span>
            <form action="<?php echo ACCESS_ROOT; ?>" method="POST">
            <input type="hidden" value="<?php echo count($customers)?>" name="data_count">
            <ul>
            <?php //foreach ($customers as $customer) : ?>
            <?php for($i=0;$i<count($customers);$i++) : ?>
                <li>
                    <?php echo $customers[$i]["companies_company"] . ' ' . $customers[$i]["customers_depart"]; ?>
                    <?php if($customers[$i]["customers_name"] != '') {echo $customers[$i]["customers_name"];} else {echo $customers[$i]["customers_name_ruby"];} ?>
                    <input type="hidden" name="customer_id_<?php echo $i ?>" value="<?php echo $customers[$i]["customers_id"]; ?>">
                    <span>様</span>
                    <select name="employee_id_<?php echo $i ?>">
                        <option value="<?php echo NULL; ?>" selected>引継ぎ担当者不明</option>
                        <?php foreach($employees as $employee) : ?>
                        <option value="<?php echo $employee["id"]; ?>"<?php //if($responsible_data["employees_id"] == $employee["id"]){ echo "selected";} ?>><?php echo $employee["name"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                <li>
            <?php endfor; ?>

            <?php //endforeach; ?>
            </ul>
            <button type="submit" value="<?php echo $responsible_data["employees_id"]; ?>" name="employees_id">はい</button>
            </form>
            <form action="/edit/employee/" method="GET">
            <button type="submit" value="<?php echo $responsible_data["employees_id"]; ?>" name="employees_id">戻る</button>
            </form>
        <?php //endif; ?>
        <?php endforeach; ?>
    </body>
</html>