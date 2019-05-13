<?php

include('../../../config/base.php');
include('../../../config/database.php');
include('../../../config/values.php');

function employeedata() {
  $dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);
  $sql = "SELECT
          employees.id AS employees_id
          , employees.name
          , employees.name_ruby
          , employees.office
          , employees.depart_id
          , employees.dispatch_flag
          , employees.memo
          , departs.id AS departs_id
          , departs.depart
          , departs.role
          FROM
          employees
          LEFT JOIN departs
          ON employees.depart_id = departs.id
          WHERE employees.id = :employees_id";
          $stmt = $dbh->prepare($sql);
          $stmt->execute([':employees_id' => $_GET["employees_id"]]);
          return $stmt->fetchAll();
}

$datas = employeedata();

include(PAGE_ROOT . 'item/employeedetailView.php');