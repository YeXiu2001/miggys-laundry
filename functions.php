<?php

function check_login($con)
{

	if(isset($_SESSION['username'],$_SESSION['password']))
	{
	

		
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];
		$query = "select * from admin_accounts WHERE username = '$username' AND password = '$password'";

		$result = pg_query($con,$query);
		if($result && pg_num_rows($result) > 0)
		{

			$user_data = pg_fetch_assoc($result);
			return $user_data;
		}
	
	
  }

	//redirect to login
	header("Location: login.php");
	die;

}
//for total sales
$tot_sales = "SELECT public.tot_sales()";
$tot_sales_run = pg_query($con, $tot_sales);
$tot_sales_res = pg_fetch_array($tot_sales_run);

//for total expenses
$tot_exp = "SELECT public.tot_exp()";
$tot_exp_run = pg_query($con, $tot_exp);
$tot_exp_res = pg_fetch_array($tot_exp_run);
	
//for total customers
$tot_cus = "SELECT public.tot_cus()";
$tot_cus_run = pg_query($con, $tot_cus);
$tot_cus_res = pg_fetch_array($tot_cus_run);

$profit = $tot_sales_res[0] - $tot_exp_res[0];


//for  modal save to summary
$trans_tomodal = "SELECT public.sales_summ()";
$trans_tomodal_run = pg_query($con,$trans_tomodal);
$trans_tomodal_res = pg_fetch_array($trans_tomodal_run);

$exp_tomodal = "SELECT public.ex_summ()";
$exp_tomodal_run = pg_query($con,$exp_tomodal);
$exp_tomodal_res = pg_fetch_array($exp_tomodal_run);

$profit_tomodal = $trans_tomodal_res[0] - $exp_tomodal_res[0];

//for line chart
$chart_que = "SELECT
EXTRACT(MONTH FROM date) as sum_date,
SUM(sales) as sales,
SUM(expenses) as expenses,
SUM(profit) as profit FROM summary
GROUP BY sum_date
ORDER BY sum_date";

$chart = pg_query($con, $chart_que);
$i=0;
while($data=pg_fetch_assoc($chart)) {
$month[]= date("F", mktime(0, 0, 0, $data['sum_date'], 10));
$sum_sales[] = $data['sales'];
$sum_exp[] = $data['expenses'];
$sum_profit[] = $data['profit'];
	$i++;
}

//for donut
$nrsq = "SELECT COUNT(laundry_id = 10) AS serv_avail,
CONCAT(lts.service_type,' ',lts.laundry_type) AS services
FROM transactions AS t, laundry_type_services AS lts
WHERE t.service_id = lts.laundry_id AND laundry_id = 10
GROUP BY laundry_id";
$nr_shirts = pg_query($con, $nrsq);

$i=0;
while($data=pg_fetch_assoc($nr_shirts)) {
$reps_nrs = $data['serv_avail'];
$services_nrs = $data['services'];
$i++;
}

$nrjq = "SELECT COUNT(laundry_id = 11) AS serv_avail,
CONCAT(lts.service_type,' ',lts.laundry_type) AS services
FROM transactions AS t, laundry_type_services AS lts
WHERE t.service_id = lts.laundry_id AND laundry_id = 11
GROUP BY laundry_id";
$nr_jeans  = pg_query($con, $nrjq);

$i=0;
while($data=pg_fetch_assoc($nr_jeans)) {
	$rep_nrj = $data['serv_avail'];
	$nrj = $data['services'];$i++;
	}

$nrcq = "SELECT COUNT(laundry_id = 12) AS serv_avail,
CONCAT(lts.service_type,' ',lts.laundry_type) AS services
FROM transactions AS t, laundry_type_services AS lts
WHERE t.service_id = lts.laundry_id AND laundry_id = 12
GROUP BY laundry_id";
$nr_comf  = pg_query($con, $nrcq);

$i=0;
while($data=pg_fetch_assoc($nr_comf)) {
  $rep_nrc = $data['serv_avail'];
  $nrc = $data['services'];$i++;
  }

$rcomfq =  "SELECT COUNT(laundry_id = 8) AS serv_avail,
CONCAT(lts.service_type,' ',lts.laundry_type) AS services
FROM transactions AS t, laundry_type_services AS lts
WHERE t.service_id = lts.laundry_id AND laundry_id = 8
GROUP BY laundry_id";
$r_comf = pg_query($con, $rcomfq);

$i=0;
while($data=pg_fetch_assoc($r_comf)) {
  $rep_rc = $data['serv_avail'];
  $rc = $data['services'];$i++;
  }

$rj1 = "SELECT COUNT(laundry_id = 9) AS serv_avail,
CONCAT(lts.service_type,' ',lts.laundry_type) AS services
FROM transactions AS t, laundry_type_services AS lts
WHERE t.service_id = lts.laundry_id AND laundry_id = 9
GROUP BY laundry_id";
$r_j  =pg_query($con, $rj1);

$i=0;
while($data=pg_fetch_assoc($r_j)) {
  $rep_rj = $data['serv_avail'];
  $rj = $data['services'];$i++;
  }

$rsq = "SELECT COUNT(laundry_id = 7) AS serv_avail,
CONCAT(lts.service_type,' ',lts.laundry_type) AS services
FROM transactions AS t, laundry_type_services AS lts
WHERE t.service_id = lts.laundry_id AND laundry_id = 7
GROUP BY laundry_id";
$r_s  = pg_query($con, $rsq);

$i=0;
while($data=pg_fetch_assoc($r_s)) {
  $rep_rs = $data['serv_avail'];
  $rs = $data['services'];$i++;
  }

//for transaction tab
$trans_query = "SELECT t.transaction_id, 
t.trans_date AS tdate
,CONCAT(c.first_name,' ', c.last_name) AS customer_name
,CONCAT(a.first_name,' ', a.last_name) AS Staff
,CONCAT(service_type,' ', laundry_type) AS Service
,price
,t.weight
,t.total_amount
,payment_status
,claim_status
,laundry_status
FROM transactions AS t, customers AS c, admin_accounts AS a,laundry_type_services as lts
WHERE t.customer_id = c.customer_id AND a.id = t.admin_id AND lts.laundry_id = t.service_id
ORDER BY transaction_id DESC";

$trans_result= pg_query($con, $trans_query);

  //for expenses tab and expenses summary 
  $ex_query = "SELECT * FROM expenses ORDER BY ex_date DESC";
  $ex_result = pg_query($con, $ex_query);

  //for  recent customers
  $recent_cus  = "SELECT DATE(t.trans_date) AS cus_date
  ,CONCAT(c.first_name,' ',c.last_name) AS Customer
  ,t.total_amount AS Payment
  FROM transactions AS t, customers AS c
  WHERE t.customer_id  = c.customer_id ORDER BY trans_date DESC";
  $recent_cusrun =  pg_query($con,$recent_cus);


//for customer dropdown and customer tab datatable
$cus_query = "SELECT * FROM customers ORDER BY first_name";
$cus_result = pg_query($con,$cus_query);
 
//for services tab
$serv_query="SELECT * FROM laundry_type_services ORDER BY laundry_id DESC";   
$serv_result = pg_query($con, $serv_query);

//for active staffs
$act_que = "SELECT * FROM admin_accounts WHERE status = 'yes'";
$act_run = pg_query($con, $act_que);

//for staff waiting approval
$approval_query = "SELECT * FROM admin_accounts WHERE status = 'no' ";
$approval_result = pg_query($con, $approval_query);

//for order tab
$order_query = "SELECT t.transaction_id, 
t.trans_date AS tdate
,CONCAT(c.first_name,' ', c.last_name) AS customer_name
,CONCAT(a.first_name,' ', a.last_name) AS Staff
,CONCAT(service_type,' ', laundry_type) AS Service
,price
,t.weight
,t.total_amount
,payment_status
,claim_status
,laundry_status
FROM transactions AS t, customers AS c, admin_accounts AS a,laundry_type_services as lts
WHERE t.customer_id = c.customer_id AND a.id = t.admin_id AND lts.laundry_id = t.service_id
ORDER BY transaction_id DESC
LIMIT 3";
$order_result = pg_query($con, $order_query);


?>