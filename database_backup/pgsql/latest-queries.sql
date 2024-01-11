SELECT SUM(expenses) FROM summary;
SELECT SUM(total_amount) FROM transactions WHERE DATE(trans_date) = current_date;
SELECT * FROM summary ORDER BY date DESC;

SELECT t.trans_date AS Date
                                    ,CONCAT(c.first_name,' ',c.last_name) AS Customer
                                    ,t.total_amount AS Payment
                                    FROM transactions AS t, customers AS c
                                    WHERE t.customer_id  = c.customer_id ORDER BY trans_date DESC;
									
SELECT t.trans_date AS Date
,CONCAT(c.first_name,' ',c.last_name) AS Customer
,t.total_amount
FROM transactions AS t, customers AS c
WHERE t.customer_id = c.customer_id AND t.trans_date::TIMESTAMP::DATE BETWEEN '2022-01-01' AND '2023-01-30';

SELECT
EXTRACT(MONTH FROM date) as sum_date,
TO_CHAR(date, 'Month'),
SUM(sales) as sales,
SUM(expenses) as expenses,
SUM(profit) as profit FROM summary
GROUP BY sum_date
ORDER BY sum_date;



SELECT t.transaction_id, t.trans_date
,CONCAT(c.first_name,' ', c.last_name) AS customer_name
,CONCAT(a.first_name,' ', a.last_name) AS Staff
,CONCAT(service_type,' ', laundry_type) AS Service
,price AS amount_kg
,t.weight,t.total_amount,payment_status,claim_status,laundry_status
FROM transactions AS t, customers AS c, admin_accounts AS a,laundry_type_services as lts
WHERE t.customer_id = c.customer_id AND a.id = t.admin_id AND lts.laundry_id = t.service_id
ORDER BY transaction_id DESC;

SELECT COUNT(laundry_id = 7),CONCAT(lts.service_type,' ',lts.laundry_type) AS service
FROM transactions AS t, laundry_type_services AS lts
WHERE t.service_id = lts.laundry_id AND laundry_id = 7
GROUP BY laundry_id;

SELECT * FROM customers ORDER BY first_name;

SELECT * FROM admin_accounts WHERE status = 'yes';\

SELECT * FROM summary ORDER BY date ASC;
SELECT SUM(expenses) FROM summary;

SELECT * FROM expenses;
SELECT * FROM laundry_type_services;

	SELECT t.transaction_id, t.trans_date
					,CONCAT(c.first_name,' ', c.last_name) AS customer_name
					,CONCAT(a.first_name,' ', a.last_name) AS Staff
					,CONCAT(service_type,' ', laundry_type) AS Service
					,price
					,t.weight,t.total_amount,payment_status,claim_status,laundry_status
					FROM transactions AS t, customers AS c, admin_accounts AS a,laundry_type_services as lts
					WHERE t.customer_id = c.customer_id AND a.id = t.admin_id AND lts.laundry_id = t.service_id AND transaction_id = 2;
					
					show data_directory;