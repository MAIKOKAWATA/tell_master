<?php

include('../../../config/all.php');

$dbh = new PDO(DB_CONNECT, DB_USERNAME, DB_PASSWORD);

function customerdata($dbh) {
  $sql = "SELECT 
        employee_customer.id AS employee_customer_id
        , employee_customer.employee_id
        , employee_customer.customer_id
        , employee_customer.deleted_at
        , employees.id AS employees_id
        , employees.name AS employees_name
        , employees.name_ruby AS employees_name_ruby
        , employees.office AS employees_office
        , employees.retired_at
        , customers.id AS customers_id
        , customers.company_id AS customers_company_id
        , customers.depart AS customers_depart
        , customers.name AS customers_name
        , customers.name_ruby AS customers_name_ruby
        , customers.classification AS customers_classification
        , customers.tel AS customers_tel
        , customers.memo AS customers_memo
        , companies.id AS companies_id
        , companies.company AS companies_company
        , companies.company_ruby AS companies_company_ruby
        , companies.company_reading AS companies_company_reading
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
        AND employee_customer.id = :employee_customer_id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([':employee_customer_id' => $_GET["employee_customer_id"]]);
  return $stmt->fetchAll();
}

$datas = customerdata($dbh);

include(PAGE_ROOT . 'item/customerdetailView.php');