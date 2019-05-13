<?php

include('../../../config/base.php');
include('../../../config/database.php');
include('../../../config/values.php');

function listemployeedata() {
  $dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);
  $sql = "SELECT
          employees.id AS employees_id
          , employees.name
          , employees.name_ruby
          , employees.office
          , employees.depart_id
          , employees.dispatch_flag
          , employees.memo
          , employees.mail_address
          , employees.individual_mail_address
          , employees.slack_account
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

function listdepartdata(){
  $dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);
  $sql = "SELECT
          departs.id AS departs_id
          , departs.depart
          , departs.old_id
          , departs.deleted_at
          FROM
          departs
          WHERE departs.deleted_at IS NULL
          AND departs.id>7";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  return $stmt->fetchAll();
}
/*
function retiredata(){
  $dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);
  $sql = "UPDATE `employees` SET `retired_at`= :retired_at,`updated_at`= :retired_at WHERE `id` = :employees_id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([':retired_at' => $_GET["retired_at"], ':employees_id' => $_GET["employees_id"]]);
}*/

function updatedata(){
  $dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);
  $sql = "UPDATE 
        `employees`
        SET
        `name`= :employees_name
        ,`name_ruby`= :name_ruby
        ,`office`= :office
        ,`depart_id`= :depart_id
        ,`dispatch_flag`= :dispatch_flag
        ,`memo`= :memo
        ,`mail_address`= :mail_address
        ,`individual_mail_address`= :individual_mail_address
        ,`slack_account`= :slack_account
        ,`updated_at`= :updated_at
        WHERE `id` = :employees_id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([':employees_name' => $_POST["name"],
                  ':name_ruby' => $_POST["name_ruby"],
                  ':office' => $_POST["office"],
                  ':depart_id' => $_POST["depart_id"],
                  ':dispatch_flag' => $_POST["dispatch_flag"],
                  ':memo' => $_POST["memo"],
                  ':mail_address' => $_POST["mail_address"],
                  ':individual_mail_address' => $_POST["individual_mail_address"],
                  ':slack_account' => $_POST["slack_account"],
                  ':updated_at' => date("Y/m/d H:i:s"),
                  ':employees_id' => $_POST["employees_id"]
                  ]);  
}

$datas = listemployeedata();
$departs = listdepartdata();

/*if(isset($_GET["retired_at"]) && $_GET["retired_at"] != ""){
  retiredata();
  header("location:/list/");
}*/

if($_SERVER['REQUEST_METHOD'] == "POST"){
  updatedata();
  header("location:/list/");
}

include(PAGE_ROOT . 'item/employeeeditView.php');