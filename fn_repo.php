<?php

    //for customer dropdown
	$cus_query = "SELECT * FROM customers ORDER BY first_name";
	$cus_result = pg_query($con,$cus_query);

		//for services
		$serv_query="SELECT * FROM laundry_type_services ORDER BY laundry_id DESC";   
		$serv_result = pg_query($con, $serv_query);

		//for order tab
	$order_query = "SELECT t.transaction_id, t.trans_date
	,CONCAT(c.first_name,' ', c.last_name) AS customer_name
	,CONCAT(a.first_name,' ', a.last_name) AS Staff
	,CONCAT(service_type,' ', laundry_type) AS Service
	,price AS 'amount/kg'
	,t.weight,t.total_amount,payment_status,claim_status,laundry_status
	FROM transactions AS t, customers AS c, admin_accounts AS a,laundry_type_services as lts
	WHERE t.customer_id = c.customer_id AND a.id = t.admin_id AND lts.laundry_id = t.service_id
	ORDER BY transaction_id DESC
	LIMIT 3";
	$order_result = pg_query($con, $order_query);



	//for transaction tab
	$trans_query = "SELECT t.transaction_id, t.trans_date
	,CONCAT(c.first_name,' ', c.last_name) AS customer_name
	,CONCAT(a.first_name,' ', a.last_name) AS Staff
	,CONCAT(service_type,' ', laundry_type) AS Service
	,price AS 'amount/kg'
	,t.weight,t.total_amount,payment_status,claim_status,laundry_status
	FROM transactions AS t, customers AS c, admin_accounts AS a,laundry_type_services as lts
	WHERE t.customer_id = c.customer_id AND a.id = t.admin_id AND lts.laundry_id = t.service_id
	ORDER BY transaction_id DESC";

	$trans_result = pg_query($con, $trans_query);



 //data for customers
 $cus_count_que = "SELECT COUNT(*) FROM customers";
 $cus_res = pg_query($con, $cus_count_que);
 $cus_count_res = pg_fetch_array($cus_res);

 //data for expenses
 $ex_sum_que = "SELECT SUM(ex_amount) FROM expenses";
 $ex_sum = pg_query($con, $ex_sum_que);
 $ex_sum_res = pg_fetch_array($ex_sum);

 //data for sales
 $sales_sum_que = "SELECT SUM(total_amount) FROM transactions";
 $sales_sum_run = pg_query($con, $sales_sum_que);
 $sales_sum_res = pg_fetch_array($sales_sum_run);

 $profit = $sales_sum_res[0] - $ex_sum_res[0];



  $sales_que = "SELECT CONCAT(YEAR(trans_date),' ',MONTHNAME(trans_date)) AS trans_date
  ,(total_amount)
  FROM transactions";
  $sales_run = pg_query($con, $sales_que);

  	//for expenses tab and expenses summary 
	$ex_query = "SELECT * FROM expenses ORDER BY ex_date DESC";
	$ex_result = pg_query($con, $ex_query);
 
	//for  transction summary
	$summtrans_que  = "SELECT t.trans_date AS Date
	,CONCAT(c.first_name,' ',c.last_name) AS Customer
	,t.total_amount AS Payment
	FROM transactions AS t, customers AS c
	WHERE t.customer_id  = c.customer_id";

	$summtrans_res = pg_query($con,$summtrans_que);

	//for summary table
	$summary_que = "SELECT * FROM summary ORDER BY date";
	$summary_run = pg_query($con,$summary_que);

	//for  modal save to summary
	$trans_tomodal = "SELECT SUM(total_amount) FROM transactions WHERE DATE(trans_date) = current_date()";
	$trans_tomodal_run = pg_query($con,$trans_tomodal);
	$trans_tomodal_res = pg_fetch_array($trans_tomodal_run);

	$exp_tomodal = "SELECT SUM(ex_amount) FROM expenses WHERE DATE(ex_date) = current_date()";
	$exp_tomodal_run = pg_query($con,$exp_tomodal);
	$exp_tomodal_res = pg_fetch_array($exp_tomodal_run);

	$profit_tomodal = $trans_tomodal_res[0] - $exp_tomodal_res[0];

		//for  recent customers
		$recent_cus  = "SELECT DATE(t.trans_date) AS cus_date
		,CONCAT(c.first_name,' ',c.last_name) AS Customer
		,t.total_amount AS Payment
		FROM transactions AS t, customers AS c
		WHERE t.customer_id  = c.customer_id ORDER BY trans_date DESC";
		$recent_cusrun =  pg_query($con,$recent_cus);

	//for line chart
	$chart = $con->query("SELECT MONTHNAME(date) AS  sum_date,SUM(sales) as sales,SUM(expenses) as expenses,SUM(profit) as profit FROM summary 
	GROUP BY MONTHNAME(date) ORDER BY date");

foreach($chart as $data){
	$month[] = $data['sum_date'];
	$sum_sales[] = $data['sales'];
	$sum_exp[] = $data['expenses'];
	$sum_profit[] = $data['profit'];
}
//for donut
$nr_shirts  = $con->query("SELECT 
COUNT(CONCAT(service_type,' ', laundry_type)) AS serv_avail,
CONCAT(lts.service_type,' ', lts.laundry_type) AS services
FROM transactions as t, laundry_type_services as lts
WHERE t.service_id = lts.laundry_id AND laundry_id = 10");

$nr_jeans  = $con->query("SELECT 
COUNT(CONCAT(service_type,' ', laundry_type)) AS serv_avail,
CONCAT(lts.service_type,' ', lts.laundry_type) AS services
FROM transactions as t, laundry_type_services as lts
WHERE t.service_id = lts.laundry_id AND laundry_id = 11");

$nr_comf  = $con->query("SELECT 
COUNT(CONCAT(service_type,' ', laundry_type)) AS serv_avail,
CONCAT(lts.service_type,' ', lts.laundry_type) AS services
FROM transactions as t, laundry_type_services as lts
WHERE t.service_id = lts.laundry_id AND laundry_id = 12");

$r_comf  = $con->query("SELECT 
COUNT(CONCAT(service_type,' ', laundry_type)) AS serv_avail,
CONCAT(lts.service_type,' ', lts.laundry_type) AS services
FROM transactions as t, laundry_type_services as lts
WHERE t.service_id = lts.laundry_id AND laundry_id = 8");

$r_j  = $con->query("SELECT 
COUNT(CONCAT(service_type,' ', laundry_type)) AS serv_avail,
CONCAT(lts.service_type,' ', lts.laundry_type) AS services
FROM transactions as t, laundry_type_services as lts
WHERE t.service_id = lts.laundry_id AND laundry_id = 9");

$r_s  = $con->query("SELECT 
COUNT(CONCAT(service_type,' ', laundry_type)) AS serv_avail,
CONCAT(lts.service_type,' ', lts.laundry_type) AS services
FROM transactions as t, laundry_type_services as lts
WHERE t.service_id = lts.laundry_id AND t.service_id = 7");

foreach($nr_shirts as $data){
$reps_nrs = $data['serv_avail'];
$services_nrs = $data['services'];
}
foreach($nr_jeans as $data){
	$rep_nrj = $data['serv_avail'];
	$nrj = $data['services'];
	}
	foreach($nr_comf as $data){
		$rep_nrc = $data['serv_avail'];
		$nrc = $data['services'];
		}
		foreach($r_comf as $data){
			$rep_rc = $data['serv_avail'];
			$rc = $data['services'];
			}
			foreach($r_j as $data){
				$rep_rj = $data['serv_avail'];
				$rj = $data['services'];
				}
				foreach($r_s as $data){
					$rep_rs = $data['serv_avail'];
					$rs = $data['services'];
					}
		//for active staffs
		$act_que = "SELECT * FROM admin_accounts WHERE status = 'yes'";
		$act_run = pg_query($con, $act_que);

		//for staff waiting approval
		$approval_query = "SELECT * FROM admin_accounts WHERE status = 'no' ";
		$approval_result = pg_query($con, $approval_query);
	

?>