<?php

include('../../config/base.php');
include('../../config/database.php');
include('../../config/values.php');

//if($_SERVER["REQUEST_METHOD"] == "POST"){
  //var_dump($_POST);exit;
//}

if(isset($_POST["dispatch_flag"])){
  $dispatch_flag = 1;
} else {
  $dispatch_flag = 0;
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

function listemployeedata() {
  $dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);
  $sql = "SELECT
         `id`
         ,`name`
         FROM
         `employees`
         WHERE `retired_at` IS NULL";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  return $stmt->fetchAll();
}

//-----------------------------------------------------------------------

function insertemployee(){
  $dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);
  $sql = "INSERT INTO
         `employees`
         (`name`, 
          `name_ruby`, 
          `office`, 
          `depart_id`, 
          `dispatch_flag`, 
          `memo`, 
          `mail_address`, 
          `individual_mail_address`, 
          `slack_account`, 
          `retired_at`, 
          `created_at`, 
          `updated_at`, 
          `deleted_at`) 
          VALUES 
          (:employee_name,
          :name_ruby,
          :office,
          :depart_id,
          :dispatch_flag,
          :memo,
          :mail_address,
          :individual_mail_address,
          :slack_account,
          :retired_at,
          :created_at,
          :updated_at,
          :deleted_at)";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([':employee_name' => $_POST["name"],
                  ':name_ruby' => $_POST["name_ruby"],
                  ':office' => $_POST["office"],
                  ':depart_id' => $_POST["depart_id"],
                  ':dispatch_flag' => $dispatch_flag,
                  ':memo' => $_POST["memo"],
                  ':mail_address' => $_POST["mail_address"] . "@" . $_POST["mail_domain"],
                  ':individual_mail_address' => $_POST["individual_mail_address"],
                  ':slack_account' => "@" . $_POST["slack_account"],
                  ':retired_at' => NULL,
                  ':created_at' => date("Y/m/d H:i:s"),
                  ':updated_at' => NULL,
                  ':deleted_at' => NULL
                  ]);  
}

function listcompanies(){
  $dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);
  $sql = "SELECT `id` FROM `companies` WHERE `company`=':company'";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([':company' => $_POST["company"]]);
  return $stmt->fetch();
} 

function insertcompany(){
  $dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);
  $sql = "INSERT IGNORE INTO
         `companies`
         (`company`, 
          `company_ruby`, 
          `created_at`, 
          `updated_at`, 
          `deleted_at`)
           VALUES 
           (:company,
           :company_ruby,
           :created_at,
           :updated_at,
           :deleted_at)";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([':company' => $_POST["company"],
                  ':company_ruby' => $_POST["company_ruby"],
                  ':created_at' => date("Y/m/d H:i:s"),
                  ':updated_at' => NULL,
                  ':deleted_at' => NULL
  ]);
}

function insertcustomer(){
  $dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);
  $sql = "INSERT INTO
         `customers`
         (`company_id`, 
         `depart`, 
         `name`, 
         `name_ruby`, 
         `tel`, 
         `classification`, 
         `memo`, 
         `created_at`, 
         `updated_at`, 
         `deleted_at`) 
         VALUES 
         (SELECT id FROM `companies` WHERE `company` = :company,
         :depart,
         :customer_name,
         :name_ruby,
         :tel,
         :classification,
         :memo,
         :created_at,
         :updated_at,
         :deleted_at)";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([':company' => $_POST["company"],
                  ':depart' => $_POST["depart"],
                  ':customer_name' => $_POST["customer_name"],
                  ':name_ruby' => $_POST["name_ruby"],
                  ':tel' => $_POST["tel"],
                  ':classification' => $_POST["classification"],
                  ':memo' => $_POST["memo"],
                  ':created_at' => date("Y/m/d H:i:s"),
                  ':updated_at' => NULL,                  
                  ':deleted_at' => NULL
                  ]);  
}

function listcustomers(){
  $dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);
  $sql = "SELECT 
        `id` 
        FROM 
        `customers` 
        WHERE 
        `company_id` = :company_id 
        AND 
        `depart` = :depart 
        AND 
        `name` = :customer_name 
        AND 
        `name_ruby` = :name_ruby ";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([
        ':company_id' => $company_id,
        ':depart' => $_POST["depart"],
        ':customer_name' => $_POST["customer_name"],
        ':name_ruby' => $_POST["name_ruby"]
        ]);
}

function insertemployee_customer(){
  $dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);
  $sql = "INSERT INTO
         `employee_customer`
         (`employee_id`,
          `customer_id`, 
          `created_at`, 
          `updated_at`, 
          `deleted_at`)
           VALUES 
          (:employee_id,
          :customer_id,
          :created_at,
          :updated_at,
          :deleted_at)";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([
        ':employee_id' => $_POST["employee_id"],
        ':customer_id' => $customer_id,
        ':created_at' => date("Y/m/d H:i:s"),
        ':updated_at' => NULL,
        ':deleted_at' => NULL
        ]);
}

$departs = listdepartdata();
$employees = listemployeedata();
//----------------------------------------------------------------



if(isset($_POST["employee"])){
  insertemployee();
}
/*
if(isset($_POST["customer"])){
  if($company_id != ""){
    insertcompany();
  }
  if($customer_id != ""){
    insertcustomer();
  }
  $company_id = listcompanies();
  $customer_id = listcustomers();
  insertemployee_customer();
}
*/

insertcompany();
insertcustomer();
include(PAGE_ROOT . 'item/insertView.php');
