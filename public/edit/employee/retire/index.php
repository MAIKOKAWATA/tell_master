<?php

include('../../../../config/all.php');

$dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);

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

function listemployeesdata($dbh){
    $sql = "SELECT
            employees.id AS employees_id 
            ,employees.name AS employees_name
            FROM
            `employees`
             WHERE employees.id = :employees_id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([':employees_id' => $_GET["employees_id"]]);
    return $stmt->fetchAll();
}

function listcustomersdata($dbh){
    $sql = "SELECT 
            employee_customer.id AS employee_customer_id
            , employee_customer.employee_id
            , employee_customer.customer_id
            , employee_customer.deleted_at
            , employees.id AS employees_id
            , employees.name AS employees_name
            , customers.id AS customers_id
            , customers.company_id AS customers_company_id
            , customers.depart AS customers_depart
            , customers.name AS customers_name
            , customers.name_ruby AS customers_name_ruby
            , companies.id AS companies_id
            , companies.company AS companies_company
            , companies.company_ruby AS companies_company_ruby
            FROM
            employee_customer
            RIGHT JOIN employees
            ON employee_customer.employee_id = employees.id
            LEFT JOIN customers
            ON employee_customer.customer_id = customers.id
            LEFT JOIN companies
            ON customers.company_id = companies.id
            WHERE employee_customer.deleted_at IS NULL
            AND employees.retired_at IS NULL
            AND employees.id = :employees_id
            ORDER BY companies.company_ruby";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([':employees_id' => $_GET["employees_id"]]);
    return $stmt->fetchAll();
}

$employees = listemployeedata($dbh);
$responsible_datas = listemployeesdata($dbh);
$customers = listcustomersdata($dbh);

/**
 * employeesの退職日を更新
 */
function retiredata($dbh){
  $sql = "UPDATE `employees` SET `retired_at`= :retired_at,`updated_at`= :updated_at WHERE `id` = :employees_id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([':retired_at' => date("Y/m/d")
                , ':updated_at' => date("Y/m/d H:i:s")
                , ':employees_id' => $_POST["employees_id"]]);
}

/**
 * employee_customerのうちの
 * 退職者が担当者のものを論理削除
 */
function deleteoldresponsible($dbh){
  $sql = "UPDATE
         `employee_customer`
          SET
           `updated_at` = :updated_at
          ,`deleted_at` = :deleted_at
          WHERE
          `employee_id` = :employees_id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([':updated_at' => date("Y/m/d H:i:s")
                , ':deleted_at' => date("Y/m/d H:i:s")
                , ':employees_id' => $_POST["employees_id"]]);
  return mysqli_affected_rows();
}

/**
 * 担当者以外の情報を保持したまま
 * employee_customerに新たな担当者を挿入
 */
function insertnewresponsible($dbh){
  for($i=0;$i<$_POST["data_count"];$i++){//ここPOSTなのが怖い
    $sql = "INSERT INTO
          `employee_customer`
          (`employee_id`, `customer_id`, `created_at`, `updated_at`, `deleted_at`)
            VALUES (:employee_id, :customer_id, :created_at, :updated_at, :deleted_at)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([':employee_id' => $_POST["employee_id_$i"]
                  , ':customer_id' => $_POST["customer_id_$i"]  
                  , ':created_at' => date("Y/m/d H:i:s")
                  , ':updated_at' => NULL
                  , ':deleted_at' => NULL]);
  }
}



if($_SERVER['REQUEST_METHOD'] == "POST"){
  retiredata($dbh);
  deleteoldresponsible($dbh);
  insertnewresponsible($dbh);
  header("location:/list/");
}

include(PAGE_ROOT . 'item/employeeretireView.php');