<?php

include('../../config/all.php');

$dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);

//if($_SERVER["REQUEST_METHOD"] == "POST"){
  //var_dump($_POST);exit;
//}

if(isset($_POST["dispatch_flag"])){
  $dispatch_flag = 1;
} else {
  $dispatch_flag = 0;
}

function listdepartdata($dbh){
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

function listemployeedata($dbh) {
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

function insertemployee($dbh){
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

function listcompanies($dbh){
  $sql = "SELECT `id` FROM `companies` WHERE `company`=':company'";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([':company' => $_POST["company"]]);
  return $stmt->fetch();
} 

function insertcompany($dbh){
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

function insertcustomer($dbh){
  $sql = "INSERT IGNORE INTO
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
          SELECT
          `id`,
          :depart,
          :customer_name,
          :name_ruby,
          :tel,
          :classification,
          :memo,
          :created_at,
          :updated_at,
          :deleted_at
          FROM
          `companies`
          WHERE `company` = :company";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([':company' => $_POST["company"],
                  ':depart' => $_POST["depart"],
                  ':customer_name' => $_POST["name"],
                  ':name_ruby' => $_POST["name_ruby"],
                  ':tel' => $_POST["tel"],
                  ':classification' => $_POST["classification"],
                  ':memo' => $_POST["memo"],
                  ':created_at' => date("Y/m/d H:i:s"),
                  ':updated_at' => NULL,                  
                  ':deleted_at' => NULL
                  ]);  
}

function listcustomers($dbh){
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

function insertemployee_customer($dbh){
/*  $sql = "INSERT INTO
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
          :deleted_at)";*/
    $sql = "INSERT INTO
            `employee_customer`
            (`employee_id`,
            `customer_id`, 
            `created_at`, 
            `updated_at`, 
            `deleted_at`)
            SELECT
            :employee_id,
            `id`,
            :created_at,
            :updated_at,
            :deleted_at
            FROM
            customers
            WHERE
            company_id = 
            AND
            depart = 
            AND
            name =
            AND
            name_ruby = ";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([
        ':employee_id' => $_POST["employee_id"],
        ':customer_id' => $customer_id,//ここもinsertcustomer()と同じ容量でいける
        ':created_at' => date("Y/m/d H:i:s"),
        ':updated_at' => NULL,
        ':deleted_at' => NULL
        ]);
}

$departs = listdepartdata($dbh);
$employees = listemployeedata($dbh);
//----------------------------------------------------------------


if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST["employee"])){
    insertemployee($dbh);
  }
  /*
  if(isset($_POST["customer"])){
    if($company_id != ""){
      insertcompany($dbh);
    }
    if($customer_id != ""){
      insertcustomer($dbh);
    }
    $company_id = listcompanies($dbh);
    $customer_id = listcustomers($dbh);
    insertemployee_customer($dbh);
  }
  */

  insertcompany($dbh);
  insertcustomer($dbh);
}
include(PAGE_ROOT . 'item/insertView.php');
