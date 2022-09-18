<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-02-23 21:31:28 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '*)
JOIN `company` ON `company`.`company_id` = `company_setting`.`company_id`
...' at line 2 - Invalid query: SELECT `com`
FROM (`company_logo`, `company_setting`.*)
JOIN `company` ON `company`.`company_id` = `company_setting`.`company_id`
WHERE `company_setting`.`company_id` = '2'
ERROR - 2021-02-23 21:31:28 --> Severity: error --> Exception: Call to a member function num_rows() on boolean D:\xamp\htdocs\pipa\application\models\Analyze_model.php 1700
ERROR - 2021-02-23 21:53:58 --> 404 Page Not Found: Asset/images
