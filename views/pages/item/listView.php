<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <?php include(VIEW_ROOT . 'common/header.php'); ?>
        <form> <!--<action="list/index.php" method="post">-->
            <input type="text" name="" value="">
            <input type="submit" value="検索">
        </form>
        <ul>
            <?php foreach ($items as $initial => $pieces) : ?>
            <li class="initial_heading"><?php echo $initial; ?></li>
            <?php foreach ($pieces as $employees_name => $piece) : ?>
            <div class="employees_details">
                <li class="employees_name">
                    <form action="/detail/employee/" method="GET">
                    <button type="submit">
                        <div class="office_img">
                            <?php foreach (OFFICES as $office_id => $office) : ?>
                            <?php if($piece[0]["employees_office"] == $office_id){ echo '<img src="/img/' . $office["image"] . '"alt="' . $office["word"] . '">';} ?>
                            <?php endforeach; ?>
                        </div>
                        <p><?php echo $piece[0]["employees_name_ruby"]; ?></p>
                        <h3><?php echo $employees_name; ?></h3>
                        <input type="hidden" name="employees_id" value="<?php echo $piece[0]["employees_id"]; ?>">
                    </button>
                    </form>
                </li>
            </div>
            <?php foreach ($piece as $debris) : ?>
            <li>
                <form action="/detail/customer/" method="GET">
                <button type="submit">
                    <?php if($debris["customer_id"] != "") { ?>
                    <p>
                        <?php echo $debris["companies_company"]; ?>
                        <br>
                        <span>(</span><?php echo $debris["companies_company_ruby"]; ?><span>)</span>
                        <br>
                        <?php if($debris["customers_name"] != '') {echo $debris["customers_name"] . '(' . $debris["customers_name_ruby"] . ')様';} else if($debris["customers_name"] == '' && $debris["customers_name_ruby"] != '') {echo $debris["customers_name_ruby"] . '様';} ?>
                    </p>
                    <?php } ?>
                    <input type="hidden" name="employee_customer_id" value="<?php echo $debris["employee_customer_id"]; ?>">
                </button>
                </form>
            </li>
            <?php endforeach; ?>
            <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
        <footer>
            <ul>
                <li>
                    <form>
                        <a href="/insert/"><button type="button">新規登録</button></a>
                    </form>
                </li>
            </ul>
        </footer>
    </body>
</html>