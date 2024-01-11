/*function trigger for trans_logs*/
CREATE OR REPLACE FUNCTION logs_trans() RETURNS TRIGGER
AS
$func$
	BEGIN
	CASE TG_OP
	WHEN 'INSERT' THEN
		INSERT INTO trans_logs(
			actor_id
			,action
			,trans_date
			 ,customer_id
			,payment_status
			,claim_status
			,laundry_status
										
		)
		VALUES(
				NEW.admin_id
				,'insert'
			  ,NEW.trans_date
			  ,NEW.customer_id
			  ,NEW.payment_status
			  ,NEW.claim_status
			  ,NEW.laundry_status
		);
		
	WHEN 'UPDATE' THEN
		INSERT INTO trans_logs(
			actor_id
			,action
			,trans_date
			 ,customer_id
			,payment_status
			,claim_status
			,laundry_status
										
		)
		VALUES(
				NEW.admin_id
				,'Update'
			  ,OLD.trans_date
			  ,OLD.customer_id
			  ,CONCAT(OLD.payment_status,' to ', NEW.payment_status)
			  ,CONCAT(OLD.claim_status,' to ', NEW.claim_status)
			  ,CONCAT(OLD.laundry_status,' to ', NEW.laundry_status)
		);
		WHEN 'DELETE' THEN
		INSERT INTO trans_logs(
			actor_id
			,action
			,trans_date
			 ,customer_id
			,payment_status
			,claim_status
			,laundry_status
										
		)
		VALUES(
				OLD.admin_id
				,'Delete'
			  ,OLD.trans_date
			  ,OLD.customer_id
			  ,OLD.payment_status
			  ,OLD.claim_status
			  ,OLD.laundry_status
		);
			  
			  RETURN OLD;
		 ELSE
      RAISE EXCEPTION 'invalid trigger';
	  END CASE;
	  
		RETURN NEW;
	END
$func$ LANGUAGE plpgsql;

/*trigger using function*/

CREATE OR REPLACE TRIGGER for_trans_logs
BEFORE INSERT OR UPDATE OR DELETE ON transactions
FOR EACH ROW
EXECUTE PROCEDURE logs_trans();
/*checking*/
SELECT * FROM transactions;
SELECT * FROM trans_logs;
SELECT * FROM customers;
DELETE FROM transactions;
DELETE FROM trans_logs;
INSERT INTO transactions (customer_id,admin_id,service_id,weight,total_amount,payment_status,claim_status,laundry_status)  
VALUES (61,1,12,1,45,'unpaid','pending','on progress');

UPDATE transactions 
SET payment_status='paid', claim_status='unclaimed',laundry_status='done' WHERE transaction_id = 1;

/*function for sales*/
CREATE OR REPLACE function tot_sales()
RETURNS integer AS $total_sales$
DECLARE
total_sales integer;
BEGIN
SELECT SUM(total_amount) INTO total_sales FROM transactions;
RETURN total_sales;
END ;
$total_sales$ LANGUAGE plpgsql;

SELECT public.tot_sales();

/*function for expenses*/
CREATE OR REPLACE function tot_exp()
RETURNS integer AS $total_exp$
DECLARE
total_exp integer;
BEGIN
SELECT SUM(ex_amount) INTO total_exp FROM expenses;
RETURN total_exp;
END ;
$total_exp$ LANGUAGE plpgsql;

SELECT public.tot_exp();

/*function for customers*/
CREATE OR REPLACE function tot_cus()
RETURNS integer AS $total_cus$
DECLARE
total_cus integer;
BEGIN
SELECT COUNT(*) INTO total_cus FROM customers;
RETURN total_cus;
END ;
$total_cus$ LANGUAGE plpgsql;

SELECT public.tot_cus();

/* prac lang */
DROP FUNCTION try();
CREATE OR REPLACE FUNCTION try()
RETURNS TABLE (transaction_id INT, tdate TIMESTAMP, customer_name TEXT, Staff TEXT, Service TEXT, price INTEGER, weight INTEGER, total_amount BIGINT, payment_status character varying(50), claim_status character varying(50), laundry_status character varying(50))
AS $$
BEGIN
RETURN QUERY
SELECT t.transaction_id, 
t.trans_date AS tdate
,CONCAT(c.first_name,' ', c.last_name) AS customer_name
,CONCAT(a.first_name,' ', a.last_name) AS Staff
,CONCAT(service_type,' ', laundry_type) AS Service
,lts.price
,t.weight
,t.total_amount
,t.payment_status
,t.claim_status
,t.laundry_status
FROM transactions AS t, customers AS c, admin_accounts AS a,laundry_type_services as lts
WHERE t.customer_id = c.customer_id AND a.id = t.admin_id AND lts.laundry_id = t.service_id
ORDER BY transaction_id DESC;
END;
$$ LANGUAGE plpgsql;


SELECT * FROM public.try();



/*sum of sales current date*/
CREATE OR REPLACE function sales_summ()
RETURNS integer AS $summsales$
DECLARE
summsales integer;
BEGIN
SELECT SUM(total_amount) INTO summsales FROM transactions WHERE DATE(trans_date) = current_date;
RETURN summsales;
END ;
$summsales$ LANGUAGE plpgsql;

SELECT public.sales_summ();

/*sum of expenses current date*/
CREATE OR REPLACE function ex_summ()
RETURNS integer AS $summex$
DECLARE
summex integer;
BEGIN
SELECT SUM(ex_amount) INTO summex FROM expenses WHERE DATE(ex_date) = current_date;
RETURN summex;
END ;
$summex$ LANGUAGE plpgsql;

SELECT public.ex_summ();

/*check summary if current date has data, this is for reports before saving*/
CREATE OR REPLACE function check_sumdata_curdate()
RETURNS integer AS $sumdata$
DECLARE
sumdata integer;
BEGIN
SELECT COUNT(*) INTO sumdata FROM summary WHERE date = current_date;
RETURN sumdata;
END ;
$sumdata$ LANGUAGE plpgsql;

SELECT public.check_sumdata_curdate();

/*function for filter expenses*/
CREATE OR REPLACE FUNCTION filter_exp(start_date date, end_date date)
RETURNS numeric AS $$
BEGIN
    RETURN (SELECT SUM(expenses) FROM summary WHERE date BETWEEN start_date AND end_date);
END; $$ LANGUAGE plpgsql;

SELECT filter_exp('2023-01-01','2024-01-01');

/*function for filter sales*/
CREATE OR REPLACE FUNCTION filter_sales(start_date date, end_date date)
RETURNS numeric AS $$
BEGIN
    RETURN (SELECT SUM(sales) FROM summary WHERE date BETWEEN start_date AND end_date);
END; $$ LANGUAGE plpgsql;

/*function for filter profit*/
CREATE OR REPLACE FUNCTION filter_profit(start_date date, end_date date)
RETURNS numeric AS $$
BEGIN
    RETURN (SELECT SUM(profit) FROM summary WHERE date BETWEEN start_date AND end_date);
END; $$ LANGUAGE plpgsql;

/*procedure for inserting expenses*/
CREATE OR REPLACE PROCEDURE insert_expense(ex_date timestamp, ex_name VARCHAR(50), ex_amount INTEGER) AS $$
BEGIN
    INSERT INTO expenses (ex_date, ex_name, ex_amount) VALUES (ex_date, ex_name, ex_amount);
END; $$ LANGUAGE plpgsql;

CALL insert_expense('2022-01-01','wala',20);

/*procedure for inserting services*/
CREATE OR REPLACE PROCEDURE insert_service(service_type VARCHAR(50), laundry_type VARCHAR(50), price INTEGER) AS $$
BEGIN
    INSERT INTO laundry_type_services (service_type, laundry_type, price) VALUES (service_type, laundry_type, price);
END; $$ LANGUAGE plpgsql;

/*procedure for inserting customers*/
CREATE OR REPLACE PROCEDURE insert_cus(first_name VARCHAR(50), last_name VARCHAR(50), contact_no VARCHAR(15)) AS $$
BEGIN
    INSERT INTO customers (first_name, last_name, contact_no) VALUES (first_name, last_name, contact_no);
END; $$ LANGUAGE plpgsql;

/*Procedure for inserting transactions*/
CREATE OR REPLACE PROCEDURE insert_order(customer_id INT,admin_id INT,service_id INT,weight INT,total_amount INT,payment_status VARCHAR(50),claim_status VARCHAR(50),laundry_status VARCHAR(50)) AS $$
BEGIN
    INSERT INTO transactions (customer_id,admin_id,service_id,weight,total_amount,payment_status,claim_status,laundry_status) VALUES (customer_id,admin_id,service_id,weight,total_amount,payment_status,claim_status,laundry_status);
END; $$ LANGUAGE plpgsql;

/*Procedure for register staff*/
CREATE OR REPLACE PROCEDURE reg_staff(first_name VARCHAR, last_name VARCHAR, username VARCHAR, password VARCHAR) AS $$
BEGIN
    INSERT INTO admin_accounts(first_name, last_name, username, password, user_type, status) VALUES (first_name, last_name, username, password, 'Staff', 'no');
END; $$ LANGUAGE plpgsql;

/*Procedure for update customer*/
CREATE OR REPLACE FUNCTION update_customer(p_customer_id INTEGER, p_first_name VARCHAR, p_last_name VARCHAR, p_contact VARCHAR)
RETURNS VOID AS $$
BEGIN
    UPDATE customers
    SET first_name = p_first_name, last_name = p_last_name, contact_no = p_contact
    WHERE customer_id = p_customer_id;
END;
$$ LANGUAGE plpgsql;
SELECT update_customer(1,'ray','ray123','091232123');

SELECT * FROM admin_accounts;

SELECT * FROM trans_logs;