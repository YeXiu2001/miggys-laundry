PGDMP                          {            ite152    15.1    15.1 q    t           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            u           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            v           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            w           1262    16398    ite152    DATABASE     �   CREATE DATABASE ite152 WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
    DROP DATABASE ite152;
                postgres    false                       1255    16625    check_sumdata_curdate()    FUNCTION     �   CREATE FUNCTION public.check_sumdata_curdate() RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
sumdata integer;
BEGIN
SELECT COUNT(*) INTO sumdata FROM summary WHERE date = current_date;
RETURN sumdata;
END ;
$$;
 .   DROP FUNCTION public.check_sumdata_curdate();
       public          postgres    false                       1255    16624 	   ex_summ()    FUNCTION     �   CREATE FUNCTION public.ex_summ() RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
summex integer;
BEGIN
SELECT SUM(ex_amount) INTO summex FROM expenses WHERE DATE(ex_date) = current_date;
RETURN summex;
END ;
$$;
     DROP FUNCTION public.ex_summ();
       public          postgres    false                       1255    16627    filter_exp(date, date)    FUNCTION     �   CREATE FUNCTION public.filter_exp(start_date date, end_date date) RETURNS numeric
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN (SELECT SUM(expenses) FROM summary WHERE date BETWEEN start_date AND end_date);
END; $$;
 A   DROP FUNCTION public.filter_exp(start_date date, end_date date);
       public          postgres    false                       1255    16629    filter_profit(date, date)    FUNCTION     �   CREATE FUNCTION public.filter_profit(start_date date, end_date date) RETURNS numeric
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN (SELECT SUM(profit) FROM summary WHERE date BETWEEN start_date AND end_date);
END; $$;
 D   DROP FUNCTION public.filter_profit(start_date date, end_date date);
       public          postgres    false                       1255    16628    filter_sales(date, date)    FUNCTION     �   CREATE FUNCTION public.filter_sales(start_date date, end_date date) RETURNS numeric
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN (SELECT SUM(sales) FROM summary WHERE date BETWEEN start_date AND end_date);
END; $$;
 C   DROP FUNCTION public.filter_sales(start_date date, end_date date);
       public          postgres    false                       1255    16626    filtered_exp(date, date) 	   PROCEDURE     �   CREATE PROCEDURE public.filtered_exp(IN date, IN date)
    LANGUAGE plpgsql
    AS $$
BEGIN
SELECT SUM(expenses) FROM summary WHERE date BETWEEN 'from_date' AND 'to_date';
END;
$$;
 6   DROP PROCEDURE public.filtered_exp(IN date, IN date);
       public          postgres    false            �            1255    16633 C   insert_cus(character varying, character varying, character varying) 	   PROCEDURE       CREATE PROCEDURE public.insert_cus(IN first_name character varying, IN last_name character varying, IN contact_no character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO customers (first_name, last_name, contact_no) VALUES (first_name, last_name, contact_no);
END; $$;
 �   DROP PROCEDURE public.insert_cus(IN first_name character varying, IN last_name character varying, IN contact_no character varying);
       public          postgres    false                       1255    16631 G   insert_expense(timestamp without time zone, character varying, integer) 	   PROCEDURE       CREATE PROCEDURE public.insert_expense(IN ex_date timestamp without time zone, IN ex_name character varying, IN ex_amount integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO expenses (ex_date, ex_name, ex_amount) VALUES (ex_date, ex_name, ex_amount);
END; $$;
 �   DROP PROCEDURE public.insert_expense(IN ex_date timestamp without time zone, IN ex_name character varying, IN ex_amount integer);
       public          postgres    false            �            1255    16634 r   insert_order(integer, integer, integer, integer, integer, character varying, character varying, character varying) 	   PROCEDURE       CREATE PROCEDURE public.insert_order(IN customer_id integer, IN admin_id integer, IN service_id integer, IN weight integer, IN total_amount integer, IN payment_status character varying, IN claim_status character varying, IN laundry_status character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO transactions (customer_id,admin_id,service_id,weight,total_amount,payment_status,claim_status,laundry_status) VALUES (customer_id,admin_id,service_id,weight,total_amount,payment_status,claim_status,laundry_status);
END; $$;
   DROP PROCEDURE public.insert_order(IN customer_id integer, IN admin_id integer, IN service_id integer, IN weight integer, IN total_amount integer, IN payment_status character varying, IN claim_status character varying, IN laundry_status character varying);
       public          postgres    false                       1255    16632 =   insert_service(character varying, character varying, integer) 	   PROCEDURE     #  CREATE PROCEDURE public.insert_service(IN service_type character varying, IN laundry_type character varying, IN price integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO laundry_type_services (service_type, laundry_type, price) VALUES (service_type, laundry_type, price);
END; $$;
 ~   DROP PROCEDURE public.insert_service(IN service_type character varying, IN laundry_type character varying, IN price integer);
       public          postgres    false            �            1255    16532    logs_trans()    FUNCTION     (  CREATE FUNCTION public.logs_trans() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
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
$$;
 #   DROP FUNCTION public.logs_trans();
       public          postgres    false            �            1255    16636 U   reg_staff(character varying, character varying, character varying, character varying) 	   PROCEDURE     o  CREATE PROCEDURE public.reg_staff(IN first_name character varying, IN last_name character varying, IN username character varying, IN password character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO admin_accounts(first_name, last_name, username, password, user_type, status) VALUES (first_name, last_name, username, password, 'Staff', 'no');
END; $$;
 �   DROP PROCEDURE public.reg_staff(IN first_name character varying, IN last_name character varying, IN username character varying, IN password character varying);
       public          postgres    false                        1255    16623    sales_summ()    FUNCTION     �   CREATE FUNCTION public.sales_summ() RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
summsales integer;
BEGIN
SELECT SUM(total_amount) INTO summsales FROM transactions WHERE DATE(trans_date) = current_date;
RETURN summsales;
END ;
$$;
 #   DROP FUNCTION public.sales_summ();
       public          postgres    false            �            1255    16610 	   tot_cus()    FUNCTION     �   CREATE FUNCTION public.tot_cus() RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
total_cus integer;
BEGIN
SELECT COUNT(*) INTO total_cus FROM customers;
RETURN total_cus;
END ;
$$;
     DROP FUNCTION public.tot_cus();
       public          postgres    false            �            1255    16609 	   tot_exp()    FUNCTION     �   CREATE FUNCTION public.tot_exp() RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
total_exp integer;
BEGIN
SELECT SUM(ex_amount) INTO total_exp FROM expenses;
RETURN total_exp;
END ;
$$;
     DROP FUNCTION public.tot_exp();
       public          postgres    false            �            1255    16608    tot_sales()    FUNCTION     �   CREATE FUNCTION public.tot_sales() RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
total_sales integer;
BEGIN
SELECT SUM(total_amount) INTO total_sales FROM transactions;
RETURN total_sales;
END ;
$$;
 "   DROP FUNCTION public.tot_sales();
       public          postgres    false            �            1255    16622    try()    FUNCTION     ^  CREATE FUNCTION public.try() RETURNS TABLE(transaction_id integer, tdate timestamp without time zone, customer_name text, staff text, service text, price integer, weight integer, total_amount bigint, payment_status character varying, claim_status character varying, laundry_status character varying)
    LANGUAGE plpgsql
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
$$;
    DROP FUNCTION public.try();
       public          postgres    false            �            1259    16400    admin_accounts    TABLE     l  CREATE TABLE public.admin_accounts (
    id integer NOT NULL,
    first_name character varying(50),
    last_name character varying(50),
    username character varying(50),
    password character varying(50),
    user_type character varying(50) NOT NULL,
    status character varying(50) NOT NULL,
    date timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);
 "   DROP TABLE public.admin_accounts;
       public         heap    postgres    false            �            1259    16399    admin_accounts_id_seq    SEQUENCE     �   CREATE SEQUENCE public.admin_accounts_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.admin_accounts_id_seq;
       public          postgres    false    215            x           0    0    admin_accounts_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.admin_accounts_id_seq OWNED BY public.admin_accounts.id;
          public          postgres    false    214            �            1259    16588    cus_logs    TABLE     �  CREATE TABLE public.cus_logs (
    id integer NOT NULL,
    log_date timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    actor_id integer NOT NULL,
    action character varying(50),
    trans_date timestamp without time zone,
    customer_id integer NOT NULL,
    payment_status character varying(50),
    claim_status character varying(50),
    laundry_status character varying(50)
);
    DROP TABLE public.cus_logs;
       public         heap    postgres    false            �            1259    16586    cus_logs_actor_id_seq    SEQUENCE     �   CREATE SEQUENCE public.cus_logs_actor_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.cus_logs_actor_id_seq;
       public          postgres    false    236            y           0    0    cus_logs_actor_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.cus_logs_actor_id_seq OWNED BY public.cus_logs.actor_id;
          public          postgres    false    234            �            1259    16587    cus_logs_customer_id_seq    SEQUENCE     �   CREATE SEQUENCE public.cus_logs_customer_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.cus_logs_customer_id_seq;
       public          postgres    false    236            z           0    0    cus_logs_customer_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.cus_logs_customer_id_seq OWNED BY public.cus_logs.customer_id;
          public          postgres    false    235            �            1259    16585    cus_logs_id_seq    SEQUENCE     �   CREATE SEQUENCE public.cus_logs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.cus_logs_id_seq;
       public          postgres    false    236            {           0    0    cus_logs_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.cus_logs_id_seq OWNED BY public.cus_logs.id;
          public          postgres    false    233            �            1259    16408 	   customers    TABLE     �   CREATE TABLE public.customers (
    customer_id integer NOT NULL,
    first_name character varying(50),
    last_name character varying(50),
    contact_no character varying(15)
);
    DROP TABLE public.customers;
       public         heap    postgres    false            �            1259    16407    customers_customer_id_seq    SEQUENCE     �   CREATE SEQUENCE public.customers_customer_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.customers_customer_id_seq;
       public          postgres    false    217            |           0    0    customers_customer_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.customers_customer_id_seq OWNED BY public.customers.customer_id;
          public          postgres    false    216            �            1259    16415    expenses    TABLE     �   CREATE TABLE public.expenses (
    expense_id integer NOT NULL,
    ex_date timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    ex_name character varying(50),
    ex_amount integer
);
    DROP TABLE public.expenses;
       public         heap    postgres    false            �            1259    16414    expenses_expense_id_seq    SEQUENCE     �   CREATE SEQUENCE public.expenses_expense_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.expenses_expense_id_seq;
       public          postgres    false    219            }           0    0    expenses_expense_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.expenses_expense_id_seq OWNED BY public.expenses.expense_id;
          public          postgres    false    218            �            1259    16423    laundry_type_services    TABLE     �   CREATE TABLE public.laundry_type_services (
    laundry_id integer NOT NULL,
    service_type character varying(50),
    laundry_type character varying(50),
    price integer
);
 )   DROP TABLE public.laundry_type_services;
       public         heap    postgres    false            �            1259    16422 $   laundry_type_services_laundry_id_seq    SEQUENCE     �   CREATE SEQUENCE public.laundry_type_services_laundry_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE public.laundry_type_services_laundry_id_seq;
       public          postgres    false    221            ~           0    0 $   laundry_type_services_laundry_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE public.laundry_type_services_laundry_id_seq OWNED BY public.laundry_type_services.laundry_id;
          public          postgres    false    220            �            1259    16430    summary    TABLE     �   CREATE TABLE public.summary (
    id integer NOT NULL,
    date date DEFAULT CURRENT_TIMESTAMP,
    sales integer,
    expenses integer,
    profit integer
);
    DROP TABLE public.summary;
       public         heap    postgres    false            �            1259    16429    summary_id_seq    SEQUENCE     �   CREATE SEQUENCE public.summary_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.summary_id_seq;
       public          postgres    false    223                       0    0    summary_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.summary_id_seq OWNED BY public.summary.id;
          public          postgres    false    222            �            1259    16566 
   trans_logs    TABLE     �  CREATE TABLE public.trans_logs (
    id integer NOT NULL,
    log_date timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    actor_id integer NOT NULL,
    action character varying(50),
    trans_date timestamp without time zone,
    customer_id integer NOT NULL,
    payment_status character varying(50),
    claim_status character varying(50),
    laundry_status character varying(50)
);
    DROP TABLE public.trans_logs;
       public         heap    postgres    false            �            1259    16564    trans_logs_actor_id_seq    SEQUENCE     �   CREATE SEQUENCE public.trans_logs_actor_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.trans_logs_actor_id_seq;
       public          postgres    false    232            �           0    0    trans_logs_actor_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.trans_logs_actor_id_seq OWNED BY public.trans_logs.actor_id;
          public          postgres    false    230            �            1259    16565    trans_logs_customer_id_seq    SEQUENCE     �   CREATE SEQUENCE public.trans_logs_customer_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.trans_logs_customer_id_seq;
       public          postgres    false    232            �           0    0    trans_logs_customer_id_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE public.trans_logs_customer_id_seq OWNED BY public.trans_logs.customer_id;
          public          postgres    false    231            �            1259    16563    trans_logs_id_seq    SEQUENCE     �   CREATE SEQUENCE public.trans_logs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.trans_logs_id_seq;
       public          postgres    false    232            �           0    0    trans_logs_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.trans_logs_id_seq OWNED BY public.trans_logs.id;
          public          postgres    false    229            �            1259    16538    transactions    TABLE     �  CREATE TABLE public.transactions (
    transaction_id integer NOT NULL,
    trans_date timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    customer_id integer NOT NULL,
    admin_id integer NOT NULL,
    service_id integer NOT NULL,
    weight integer,
    total_amount bigint,
    payment_status character varying(50),
    claim_status character varying(50),
    laundry_status character varying(50)
);
     DROP TABLE public.transactions;
       public         heap    postgres    false            �            1259    16536    transactions_admin_id_seq    SEQUENCE     �   CREATE SEQUENCE public.transactions_admin_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.transactions_admin_id_seq;
       public          postgres    false    228            �           0    0    transactions_admin_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.transactions_admin_id_seq OWNED BY public.transactions.admin_id;
          public          postgres    false    226            �            1259    16535    transactions_customer_id_seq    SEQUENCE     �   CREATE SEQUENCE public.transactions_customer_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE public.transactions_customer_id_seq;
       public          postgres    false    228            �           0    0    transactions_customer_id_seq    SEQUENCE OWNED BY     ]   ALTER SEQUENCE public.transactions_customer_id_seq OWNED BY public.transactions.customer_id;
          public          postgres    false    225            �            1259    16537    transactions_service_id_seq    SEQUENCE     �   CREATE SEQUENCE public.transactions_service_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.transactions_service_id_seq;
       public          postgres    false    228            �           0    0    transactions_service_id_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.transactions_service_id_seq OWNED BY public.transactions.service_id;
          public          postgres    false    227            �            1259    16534    transactions_transaction_id_seq    SEQUENCE     �   CREATE SEQUENCE public.transactions_transaction_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE public.transactions_transaction_id_seq;
       public          postgres    false    228            �           0    0    transactions_transaction_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE public.transactions_transaction_id_seq OWNED BY public.transactions.transaction_id;
          public          postgres    false    224            �           2604    16403    admin_accounts id    DEFAULT     v   ALTER TABLE ONLY public.admin_accounts ALTER COLUMN id SET DEFAULT nextval('public.admin_accounts_id_seq'::regclass);
 @   ALTER TABLE public.admin_accounts ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    215    214    215            �           2604    16591    cus_logs id    DEFAULT     j   ALTER TABLE ONLY public.cus_logs ALTER COLUMN id SET DEFAULT nextval('public.cus_logs_id_seq'::regclass);
 :   ALTER TABLE public.cus_logs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    236    233    236            �           2604    16593    cus_logs actor_id    DEFAULT     v   ALTER TABLE ONLY public.cus_logs ALTER COLUMN actor_id SET DEFAULT nextval('public.cus_logs_actor_id_seq'::regclass);
 @   ALTER TABLE public.cus_logs ALTER COLUMN actor_id DROP DEFAULT;
       public          postgres    false    236    234    236            �           2604    16594    cus_logs customer_id    DEFAULT     |   ALTER TABLE ONLY public.cus_logs ALTER COLUMN customer_id SET DEFAULT nextval('public.cus_logs_customer_id_seq'::regclass);
 C   ALTER TABLE public.cus_logs ALTER COLUMN customer_id DROP DEFAULT;
       public          postgres    false    235    236    236            �           2604    16411    customers customer_id    DEFAULT     ~   ALTER TABLE ONLY public.customers ALTER COLUMN customer_id SET DEFAULT nextval('public.customers_customer_id_seq'::regclass);
 D   ALTER TABLE public.customers ALTER COLUMN customer_id DROP DEFAULT;
       public          postgres    false    216    217    217            �           2604    16418    expenses expense_id    DEFAULT     z   ALTER TABLE ONLY public.expenses ALTER COLUMN expense_id SET DEFAULT nextval('public.expenses_expense_id_seq'::regclass);
 B   ALTER TABLE public.expenses ALTER COLUMN expense_id DROP DEFAULT;
       public          postgres    false    218    219    219            �           2604    16426     laundry_type_services laundry_id    DEFAULT     �   ALTER TABLE ONLY public.laundry_type_services ALTER COLUMN laundry_id SET DEFAULT nextval('public.laundry_type_services_laundry_id_seq'::regclass);
 O   ALTER TABLE public.laundry_type_services ALTER COLUMN laundry_id DROP DEFAULT;
       public          postgres    false    220    221    221            �           2604    16433 
   summary id    DEFAULT     h   ALTER TABLE ONLY public.summary ALTER COLUMN id SET DEFAULT nextval('public.summary_id_seq'::regclass);
 9   ALTER TABLE public.summary ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    223    222    223            �           2604    16569    trans_logs id    DEFAULT     n   ALTER TABLE ONLY public.trans_logs ALTER COLUMN id SET DEFAULT nextval('public.trans_logs_id_seq'::regclass);
 <   ALTER TABLE public.trans_logs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    229    232    232            �           2604    16571    trans_logs actor_id    DEFAULT     z   ALTER TABLE ONLY public.trans_logs ALTER COLUMN actor_id SET DEFAULT nextval('public.trans_logs_actor_id_seq'::regclass);
 B   ALTER TABLE public.trans_logs ALTER COLUMN actor_id DROP DEFAULT;
       public          postgres    false    230    232    232            �           2604    16572    trans_logs customer_id    DEFAULT     �   ALTER TABLE ONLY public.trans_logs ALTER COLUMN customer_id SET DEFAULT nextval('public.trans_logs_customer_id_seq'::regclass);
 E   ALTER TABLE public.trans_logs ALTER COLUMN customer_id DROP DEFAULT;
       public          postgres    false    232    231    232            �           2604    16541    transactions transaction_id    DEFAULT     �   ALTER TABLE ONLY public.transactions ALTER COLUMN transaction_id SET DEFAULT nextval('public.transactions_transaction_id_seq'::regclass);
 J   ALTER TABLE public.transactions ALTER COLUMN transaction_id DROP DEFAULT;
       public          postgres    false    228    224    228            �           2604    16543    transactions customer_id    DEFAULT     �   ALTER TABLE ONLY public.transactions ALTER COLUMN customer_id SET DEFAULT nextval('public.transactions_customer_id_seq'::regclass);
 G   ALTER TABLE public.transactions ALTER COLUMN customer_id DROP DEFAULT;
       public          postgres    false    228    225    228            �           2604    16544    transactions admin_id    DEFAULT     ~   ALTER TABLE ONLY public.transactions ALTER COLUMN admin_id SET DEFAULT nextval('public.transactions_admin_id_seq'::regclass);
 D   ALTER TABLE public.transactions ALTER COLUMN admin_id DROP DEFAULT;
       public          postgres    false    226    228    228            �           2604    16545    transactions service_id    DEFAULT     �   ALTER TABLE ONLY public.transactions ALTER COLUMN service_id SET DEFAULT nextval('public.transactions_service_id_seq'::regclass);
 F   ALTER TABLE public.transactions ALTER COLUMN service_id DROP DEFAULT;
       public          postgres    false    228    227    228            \          0    16400    admin_accounts 
   TABLE DATA           p   COPY public.admin_accounts (id, first_name, last_name, username, password, user_type, status, date) FROM stdin;
    public          postgres    false    215   Ԝ       q          0    16588    cus_logs 
   TABLE DATA           �   COPY public.cus_logs (id, log_date, actor_id, action, trans_date, customer_id, payment_status, claim_status, laundry_status) FROM stdin;
    public          postgres    false    236   K�       ^          0    16408 	   customers 
   TABLE DATA           S   COPY public.customers (customer_id, first_name, last_name, contact_no) FROM stdin;
    public          postgres    false    217   h�       `          0    16415    expenses 
   TABLE DATA           K   COPY public.expenses (expense_id, ex_date, ex_name, ex_amount) FROM stdin;
    public          postgres    false    219   ˝       b          0    16423    laundry_type_services 
   TABLE DATA           ^   COPY public.laundry_type_services (laundry_id, service_type, laundry_type, price) FROM stdin;
    public          postgres    false    221   9�       d          0    16430    summary 
   TABLE DATA           D   COPY public.summary (id, date, sales, expenses, profit) FROM stdin;
    public          postgres    false    223   ��       m          0    16566 
   trans_logs 
   TABLE DATA           �   COPY public.trans_logs (id, log_date, actor_id, action, trans_date, customer_id, payment_status, claim_status, laundry_status) FROM stdin;
    public          postgres    false    232   #�       i          0    16538    transactions 
   TABLE DATA           �   COPY public.transactions (transaction_id, trans_date, customer_id, admin_id, service_id, weight, total_amount, payment_status, claim_status, laundry_status) FROM stdin;
    public          postgres    false    228   ��       �           0    0    admin_accounts_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.admin_accounts_id_seq', 5, true);
          public          postgres    false    214            �           0    0    cus_logs_actor_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.cus_logs_actor_id_seq', 1, false);
          public          postgres    false    234            �           0    0    cus_logs_customer_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.cus_logs_customer_id_seq', 1, false);
          public          postgres    false    235            �           0    0    cus_logs_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.cus_logs_id_seq', 1, false);
          public          postgres    false    233            �           0    0    customers_customer_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.customers_customer_id_seq', 1, true);
          public          postgres    false    216            �           0    0    expenses_expense_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.expenses_expense_id_seq', 5, true);
          public          postgres    false    218            �           0    0 $   laundry_type_services_laundry_id_seq    SEQUENCE SET     R   SELECT pg_catalog.setval('public.laundry_type_services_laundry_id_seq', 1, true);
          public          postgres    false    220            �           0    0    summary_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.summary_id_seq', 15, true);
          public          postgres    false    222            �           0    0    trans_logs_actor_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.trans_logs_actor_id_seq', 1, false);
          public          postgres    false    230            �           0    0    trans_logs_customer_id_seq    SEQUENCE SET     I   SELECT pg_catalog.setval('public.trans_logs_customer_id_seq', 1, false);
          public          postgres    false    231            �           0    0    trans_logs_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.trans_logs_id_seq', 22, true);
          public          postgres    false    229            �           0    0    transactions_admin_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.transactions_admin_id_seq', 1, false);
          public          postgres    false    226            �           0    0    transactions_customer_id_seq    SEQUENCE SET     K   SELECT pg_catalog.setval('public.transactions_customer_id_seq', 1, false);
          public          postgres    false    225            �           0    0    transactions_service_id_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('public.transactions_service_id_seq', 1, false);
          public          postgres    false    227            �           0    0    transactions_transaction_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('public.transactions_transaction_id_seq', 12, true);
          public          postgres    false    224            �           2606    16406 "   admin_accounts admin_accounts_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY public.admin_accounts
    ADD CONSTRAINT admin_accounts_pkey PRIMARY KEY (id);
 L   ALTER TABLE ONLY public.admin_accounts DROP CONSTRAINT admin_accounts_pkey;
       public            postgres    false    215            �           2606    16596    cus_logs cus_logs_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.cus_logs
    ADD CONSTRAINT cus_logs_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.cus_logs DROP CONSTRAINT cus_logs_pkey;
       public            postgres    false    236            �           2606    16413    customers customers_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.customers
    ADD CONSTRAINT customers_pkey PRIMARY KEY (customer_id);
 B   ALTER TABLE ONLY public.customers DROP CONSTRAINT customers_pkey;
       public            postgres    false    217            �           2606    16421    expenses expenses_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.expenses
    ADD CONSTRAINT expenses_pkey PRIMARY KEY (expense_id);
 @   ALTER TABLE ONLY public.expenses DROP CONSTRAINT expenses_pkey;
       public            postgres    false    219            �           2606    16428 0   laundry_type_services laundry_type_services_pkey 
   CONSTRAINT     v   ALTER TABLE ONLY public.laundry_type_services
    ADD CONSTRAINT laundry_type_services_pkey PRIMARY KEY (laundry_id);
 Z   ALTER TABLE ONLY public.laundry_type_services DROP CONSTRAINT laundry_type_services_pkey;
       public            postgres    false    221            �           2606    16436    summary summary_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.summary
    ADD CONSTRAINT summary_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.summary DROP CONSTRAINT summary_pkey;
       public            postgres    false    223            �           2606    16574    trans_logs trans_logs_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.trans_logs
    ADD CONSTRAINT trans_logs_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.trans_logs DROP CONSTRAINT trans_logs_pkey;
       public            postgres    false    232            �           2606    16547    transactions transactions_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.transactions
    ADD CONSTRAINT transactions_pkey PRIMARY KEY (transaction_id);
 H   ALTER TABLE ONLY public.transactions DROP CONSTRAINT transactions_pkey;
       public            postgres    false    228            �           2620    16607    transactions for_trans_logs    TRIGGER     �   CREATE TRIGGER for_trans_logs AFTER INSERT OR DELETE OR UPDATE ON public.transactions FOR EACH ROW EXECUTE FUNCTION public.logs_trans();
 4   DROP TRIGGER for_trans_logs ON public.transactions;
       public          postgres    false    254    228            �           2606    16597    cus_logs cus_logs_actor_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.cus_logs
    ADD CONSTRAINT cus_logs_actor_id_fkey FOREIGN KEY (actor_id) REFERENCES public.admin_accounts(id);
 I   ALTER TABLE ONLY public.cus_logs DROP CONSTRAINT cus_logs_actor_id_fkey;
       public          postgres    false    215    3254    236            �           2606    16602 "   cus_logs cus_logs_customer_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.cus_logs
    ADD CONSTRAINT cus_logs_customer_id_fkey FOREIGN KEY (customer_id) REFERENCES public.customers(customer_id);
 L   ALTER TABLE ONLY public.cus_logs DROP CONSTRAINT cus_logs_customer_id_fkey;
       public          postgres    false    236    217    3256            �           2606    16575 #   trans_logs trans_logs_actor_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.trans_logs
    ADD CONSTRAINT trans_logs_actor_id_fkey FOREIGN KEY (actor_id) REFERENCES public.admin_accounts(id) ON DELETE CASCADE;
 M   ALTER TABLE ONLY public.trans_logs DROP CONSTRAINT trans_logs_actor_id_fkey;
       public          postgres    false    232    215    3254            �           2606    16580 &   trans_logs trans_logs_customer_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.trans_logs
    ADD CONSTRAINT trans_logs_customer_id_fkey FOREIGN KEY (customer_id) REFERENCES public.customers(customer_id) ON DELETE CASCADE;
 P   ALTER TABLE ONLY public.trans_logs DROP CONSTRAINT trans_logs_customer_id_fkey;
       public          postgres    false    232    217    3256            �           2606    16553 '   transactions transactions_admin_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.transactions
    ADD CONSTRAINT transactions_admin_id_fkey FOREIGN KEY (admin_id) REFERENCES public.admin_accounts(id) ON DELETE CASCADE;
 Q   ALTER TABLE ONLY public.transactions DROP CONSTRAINT transactions_admin_id_fkey;
       public          postgres    false    215    228    3254            �           2606    16548 *   transactions transactions_customer_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.transactions
    ADD CONSTRAINT transactions_customer_id_fkey FOREIGN KEY (customer_id) REFERENCES public.customers(customer_id) ON DELETE CASCADE;
 T   ALTER TABLE ONLY public.transactions DROP CONSTRAINT transactions_customer_id_fkey;
       public          postgres    false    217    3256    228            �           2606    16558 )   transactions transactions_service_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.transactions
    ADD CONSTRAINT transactions_service_id_fkey FOREIGN KEY (service_id) REFERENCES public.laundry_type_services(laundry_id) ON DELETE CASCADE;
 S   ALTER TABLE ONLY public.transactions DROP CONSTRAINT transactions_service_id_fkey;
       public          postgres    false    228    221    3260            \   g   x�3�J��M,*�H,J�,��LL���3�Q��y�E���ŜFFF����&
V`�e�镟�����X�Y�b��K��p�4�tK�HE�i������� �B1�      q      x������ � �      ^   S   x�3���IM*���L*�L�+�4��07351622�23���OJ��J�M-F�1��N,���t.-*�������[p��qqq F      `   ^   x�3�4202�50"+0�L��N�42�2���*X��d]RKR��S�J8�,�L@J��(O�IJp��`ned�-,O�440������ ���      b   ]   x�3�*-��T��,*)�41岀�8�����sZpYB�R�9��8���t����r"�!j̀j���@�
H��r��qqq �&      d   m   x�M��	1�o{�+��]���QQ�a�D�#_���� Q�R4IST�]�Kt�n�"-�&m�g��@;��Q ���k�Z;S>���(yF?�m�?ow�,�.�      m   P  x����n� E��+�A����d�MT[��ֶ���BS%���4����*���&���F�P��[w��4�1L�US7��pQ�PO��r�n���V �q����|��E��c�������u6�L?�q�*�q9�du��۾�B#X��YX��i����g�2�.�6�hc�x���5e�����:&ޯ>ה�nm%Ԁb��oM�lXE;6"\¿4e�[M�H�RWH��������?�Z���0��!9�g��V�kM�N�;�R�!i�l7�KM��}:Μ�I��q�)v�}���Oϖ����M�ӂ�6��j[�i	g)�d�+�K��UU�  E,      i   	  x���In�@�uq
.�VM]=��ﲱ��@�|���x�Y���~�/F�Ҏ�fʂ��Q4aC �S�k����߶�f�ۊ�%c��]�,��>|�o�c�7]�����p:��K%O�h��i4f-F�4���ͩ��T��i�W��� ,K�M�^&�d�lAh	osA�L�7�xGt�U�\�MJ0�$��p(�a�v_�j�����pF�\���Ȕ�?!�a�&v�ŗK0�1?���+c��^y:4���|���� /�S     