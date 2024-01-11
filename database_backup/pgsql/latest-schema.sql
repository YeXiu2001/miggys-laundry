CREATE TABLE admin_accounts (
  id SERIAL PRIMARY KEY,
  first_name varchar(50),
  last_name varchar(50),
  username varchar(50),
  password varchar(50),
  user_type varchar(50) NOT NULL,
  status varchar(50) NOT NULL,
  date timestamp DEFAULT current_timestamp
	);
	
CREATE TABLE customers (
  customer_id SERIAL PRIMARY KEY,
  first_name varchar(50),
  last_name varchar(50),
  contact_no varchar(15)
);

CREATE TABLE expenses (
  expense_id  SERIAL PRIMARY KEY,
  ex_date timestamp DEFAULT current_timestamp,
  ex_name varchar(50),
  ex_amount INT
);

CREATE TABLE laundry_type_services (
  laundry_id SERIAL PRIMARY KEY,
  service_type varchar(50),
  laundry_type varchar(50),
  price int
);

CREATE TABLE summary (
  id SERIAL PRIMARY KEY,
  date date DEFAULT current_timestamp,
  sales int,
  expenses int,
  profit int
);
DROP TABLE transactions;
CREATE TABLE transactions (
  transaction_id Serial Primary KEY,
  trans_date timestamp DEFAULT current_timestamp,
  customer_id SERIAL,
  admin_id SERIAL,
  service_id SERIAL,
  weight int,
  total_amount bigint,
	payment_status varchar(50),
  claim_status varchar(50),
	laundry_status varchar(50),
	FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
	FOREIGN KEY (admin_id) REFERENCES admin_accounts(id) ON DELETE CASCADE,
	FOREIGN KEY (service_id) REFERENCES laundry_type_services(laundry_id) ON DELETE CASCADE
);
ALTER TABLE transactions ALTER trans_date TYPE DateTime; 

DROP TABLE trans_logs;
CREATE TABLE trans_logs(
	id SERIAL PRIMARY KEY
	,log_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	,actor_id SERIAL
	,action VARCHAR(50)
	,trans_date TIMESTAMP
	,customer_id SERIAL,
	payment_status varchar(50),
  	claim_status varchar(50),
	laundry_status varchar(50),
	FOREIGN KEY (actor_id) REFERENCES admin_accounts(id) ON DELETE CASCADE,
	FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE
);

CREATE TABLE cus_logs(
	id SERIAL PRIMARY KEY
	,log_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	,actor_id SERIAL
	,action VARCHAR(50)
	,trans_date TIMESTAMP
	,customer_id SERIAL,
	payment_status varchar(50),
  	claim_status varchar(50),
	laundry_status varchar(50),
	FOREIGN KEY (actor_id) REFERENCES admin_accounts(id),
	FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
);

INSERT INTO admin_accounts (first_name,last_name, username, password, user_type, status, date) VALUES
('Raymart', 'Paraiso', 'admin1', 'admin1', 'Owner', 'yes', '2022-10-14 00:00:00'),
('Jonaem', 'Azis', 'admin2', 'admin2', 'Staff', 'yes', '2022-10-14 00:00:00'),
('Faheem', 'Azis', 'admin3', 'admin3', 'Staff', 'yes', '2022-10-14 00:00:00');

INSERT INTO customers (customer_id, first_name, last_name, contact_no) VALUES
(59, 'lebron', 'bryant', '09876543221'),
(60, 'Kobe', 'James', '09876543221'),
(61, 'Kawhi', 'Curry', '09123345678');

INSERT INTO laundry_type_services (laundry_id, service_type, laundry_type, price) VALUES
(7, 'Rush', ' Shirts', 45),
(8, 'Rush', 'Comforters', 80),
(9, 'Rush', 'Jeans', 70),
(10, 'Non-rush', ' Shirts', 35),
(11, 'Non-rush', 'Jeans', 60),
(12, 'Non-rush', ' Comforters', 75);

INSERT INTO expenses(ex_date, ex_name, ex_amount)
VALUES('2023-01-01','coke',25 );
SELECT * FROM expenses;
SELECT * FROM admin_accounts;

SELECT * FROM summary;
SELECT * FROM laundry_type_services;
INSERT INTO summary(date, sales, expenses, profit)
VALUES('2023-12-01', 0, 0, 0);