<?php

//employeesテーブルのofficeの値
define('OFFICES', [0 => ['image' => 'none.png', 'word' => '勤務オフィス不明'],1 => ['image' => 'kobe.png', 'word' => '神戸オフィス勤務'],2=> ['image' => 'kyoto.png', 'word' => '京都オフィス勤務'],3=> ['image' => 'tokyo.png', 'word' => '東京オフィス勤務']]);

//customersテーブルのclassificationsの値
define('CUSTOMERS', [0 => '不明', 1 => '元取引先', 2 => '取引先', 3 => '営業電話', 4 => '悪質営業']);

//departsテーブルの分類以外の値が入っている値
define('DEPART_MIN', 8);
define('DEPART_MAX', 28);