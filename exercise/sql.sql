CREATE TABLE Addressbook (
regist_no INTEGER NOT NULL,
name VARCHAR(128) NOT NULL,
address VARCHAR(128) NOT NULL,
tel_no CHAR(10),
mail_address CHAR(20),
PRIMARY KEY (regist_no)
);

ALTER TABLE Addressbook ADD postal_code CHAR(8) NOT NULL;

DROP TABLE Addressbook;


SELECT COUNT(*)
	FROM Product;

SELECT COUNT(purchase_price) 
	FROM Product;

SELECT COUNT(*), COUNT(purchase_price)
	FROM Product;

SELECT SUM(sale_price)
	FROM Product;

SELECT AVG(sale_price)
	FROM Product;

SELECT MAX(regist_date), MIN(regist_date)
	FROM Product;

SELECT COUNT(DISTINCT product_type)
	FROM Product;

SELECT SUM(sale_price), SUM(DISTINCT sale_price)
	FROM Product;

SELECT product_type, COUNT(*)
	FROM Product
GROUP BY product_type;

SELECT purchase_price, COUNT(*)
	FROM Product
GROUP BY purchase_price;

SELECT purchase_price, COUNT(*)
	FROM Product
WHERE product_type = '衣服'
GROUP BY purchase_price

/**
 * 错误写法
 */
SELECT product_name, purchase_price, COUNT(*)
	FROM Product
GROUP BY purchase_price;

SELECT product_type AS pt, COUNT(*)
	FROM Product
GROUP BY pt;

SELECT product_type, COUNT(*)
	FROM Product
WHERE COUNT(*) = 2
GROUP BY product_type;

SELECT DISTINCT product_type
	FROM Product;

SELECT product_type
	FROM Product
GROUP BY product_type;

SELECT product_type, COUNT(*)
	FROM Product
GROUP BY product_type
HAVING COUNT(*) = 2;

SELECT product_type, AVG(sale_price)
	FROM Product
GROUP BY product_type;

SELECT product_type, AVG(sale_price)
	FROM Product
GROUP BY product_type
HAVING AVG(sale_price) >= 2500;

/**
 * 错误用法
 */
SELECT product_type, COUNT(*)
	FROM Product
GROUP BY product_type
HAVING product_name = '圆珠笔';


SELECT product_type, COUNT(*)
	FROM Product
WHERE product_type = '衣服'
GROUP BY product_type;

SELECT product_type, COUNT(*)
	FROM Product
GROUP BY product_type
HAVING product_type = '衣服';

SELECT product_id, product_name, sale_price, purchase_price
	FROM Product
ORDER BY sale_price,product_id;

SELECT product_id AS id, product_name, sale_price AS sp, purchase_price
	FROM Product
ORDER BY sp, id;

SELECT product_name, sale_price AS sp, purchase_price
	FROM Product
ORDER BY product_id;

SELECT product_type, COUNT(*)
	FROM Product
GROUP BY product_type
ORDER BY COUNT(*);

SELECT product_type, SUM(product_type)
	FROM Product
WHERE regist_date > '2009-09-01'
GROUP BY product_type;

SELECT product_type, SUM(sale_price), SUM(purchase_price)
	FROM Product
GROUP BY product_type
HAVING SUM(sale_price) = 1.5 * (SUM(purchase_price));

SELECT * FROM Product ORDER BY regist_date DESC, sale_price; 

/**
 * 第四章
 */

INSERT INTO ProductIns (product_id, product_name, product_type, sale_price, purchase_price,regist_date) 
VALUES ('0001', 'T恤衫', '衣服', 1000, 500, '2009-09-20');

INSERT INTO ProductIns VALUES ('0002', '打孔器', '办公用品', 500, 320, '2009-09-11'),
('0003', '运动T恤', '衣服', 4000, 2800, NULL),
('0004', '菜刀', '厨房用具', 3000, 2800, '2009-09-20');

INSERT INTO ProductIns VALUES ('0005', '高压锅', '厨房用具', 6800, 5000, '2009-01-15'),
('0006', '叉子', '厨房用具', 500, NULL, '2009-09-20'),
('0007', '擦菜板', '厨房用具', DEFAULT, 790, '2009-04-28');

/**
 * 从其他表中复制数据
 */

INSERT INTO ProductCopy (product_id, product_name, product_type, sale_price, purchase_price, regist_date) 
SELECT product_id, product_name, product_type, sale_price, purchase_price, regist_date
	FROM Product;

CREATE TABLE ProductType (
product_type VARCHAR(32) NOT NULL,
sum_sale_price INTEGER,
sum_purchase_price INTEGER,
PRIMARY KEY (product_type)
);

INSERT INTO ProductType (product_type, sum_sale_price, sum_purchase_price)
SELECT product_type, SUM(sale_price), SUM(purchase_price)
	FROM Product
GROUP BY product_type;

UPDATE ProductCopy 
	SET sale_price = sale_price * 10,
		purchase_price = purchase_price / 2;

/**
 * 事务
 */
START TRANSACTION;

	UPDATE ProductCopy
		SET sale_price = 80000
	WHERE product_name = '运动T恤';

	UPDATE ProductCopy
		SET sale_price = 80000
	WHERE product_name = 'T恤衫';

ROLLBACK;

INSERT INTO Product2
SELECT product_id, product_name, product_type, sale_price, purchase_price, regist_date, sale_price - purchase_price AS margin
FROM Product;


START TRANSACTION;
	UPDATE Product2
		SET sale_price = sale_price - 1000
	WHERE product_name = '运动T恤';

	UPDATE Product2
		SET margin = sale_price - purchase_price;
COMMIT;

CREATE VIEW ProductSum2 (product_type, cnt_product)
AS 
SELECT product_type, COUNT(*)
	FROM Product
GROUP BY product_type
ORDER BY product_type;-- 不建议这么写

SELECT * FROM ProductSum;

CREATE VIEW ProductSumJim (product_type, cnt_product)
AS
SELECT product_type, cnt_product
	FROM ProductSum
WHERE product_type = '办公用品';

INSERT INTO ProductSum VALUES ('电器制品', 5);

CREATE VIEW ProductJim (product_id, product_name, product_type, sale_price, purchase_price, regist_date)
AS
SELECT * 
	FROM Product
WHERE product_type = '办公用品';

INSERT INTO ProductJim VALUES ('0009', '印章', '办公用品', 95, 10 ,'2009-11-30');


/**
 * 错误写法，product_id not null
 */
CREATE VIEW ProductJim1 (product_name, product_type, sale_price, purchase_price, regist_date)
AS
SELECT product_name, product_type, sale_price, purchase_price, regist_date
	FROM Product
WHERE product_type = '办公用品';

INSERT INTO ProductJim VALUES ('印章', '办公用品', 95, 10 ,'2009-11-30');
--------


DROP VIEW ProductSum;

/**
 * 子查询
 */

SELECT product_type, cnt_product
	FROM 
(SELECT product_type, COUNT(*) as cnt_product
	FROM Product
GROUP BY product_type
HAVING cnt_product = 4) -- 必须写括号 
AS ProductSum;

SELECT product_type, cnt_product
	FROM (SELECT product_type, cnt_product
		FROM (SELECT product_type, COUNT(*) as cnt_product
				FROM Product
				GROUP BY product_type) AS ProductSum1
		WHERE cnt_product = 4) AS ProductSum;

/**
 * 标量子查询
 */

SELECT * 
	FROM Product
WHERE sale_price > (SELECT AVG(sale_price)
					FROM Product);

SELECT product_id, product_name, sale_price, (SELECT AVG(sale_price)
												FROM Product) AS avg_price
FROM Product;

SELECT product_type, AVG(sale_price)
	FROM Product
GROUP BY product_type
HAVING AVG(sale_price) > (SELECT AVG(sale_price) FROM Product);

/**
 * 错误实例
 */

SELECT product_type, (SELECT AVG(sale_price) FROM Product GROUP BY product_type)
	FROM Product;

/**
 * 关联子查询
 */
-- 执行过程是什么样的呢？
SELECT product_type, product_name, sale_price
	FROM Product AS P1
WHERE sale_price > (SELECT AVG(sale_price) 
						FROM Product AS P2 
							WHERE P1.product_type = p2.product_type 
						GROUP BY product_type);


CREATE VIEW VIEWPractice5_1 (product_name, sale_price, regist_date)
AS
SELECT product_name, sale_price, regist_date
FROM Product
WHERE sale_price >= 1000 AND regist_date = '2009-09-20';

-- INSERT INTO VIEWPractice5_1 VALUES ('刀子', 1300, '2009-11-02');
CREATE VIEW VIEW111 (product_id, product_name, product_type, sale_price, avg_sale_price)
AS
SELECT product_id, product_name, product_type, sale_price, (SELECT AVG(sale_price) FROM Product AS P2 WHERE P1.product_type = P2.product_type GROUP BY product_type) AS avg_sale_price
FROM Product AS P1;


/**
 * 函数
 */

-- 算数函数：sum、min、max、count、+、-、*、/、abs、round、mod、

SELECT m + n + p AS total, n - p AS jian, m * n * p AS cheng, m / n AS chu, MOD(m, n), ABS(m), ROUND(m, n)
	FROM SampleMath;

-- 字符串函数：concat(str1,str2), length(str1), lower(),upper(), replace(str, existstr, replacestr),substring(str from 3 for 2)

SELECT str1, str2,str3,
		concat(str1, str2, str3),
		length(str1),
		lower(str1),
		upper(str1),
		replace(str1, 'abc', 'ggg'),
		substring(str1 from 2 for 2)
	FROM SampleStr;

-- 日期函数：current_date、 current_time、 current_timestamp、now、 date_format('2008-09-20 2:30:44', '%Y%m%d%H%i%s')
SELECT current_date, current_time, current_timestamp, now(), date_format('2008-09-20 2:30:44', '%Y%m%d%H%i%s');

SELECT current_timestamp,
		extract(year from current_timestamp),
		extract(month from current_timestamp),
		extract(day from current_timestamp),
		extract(hour from current_timestamp),
		extract(minute from current_timestamp),
		extract(second from current_timestamp);

-- 转换函数:
SELECT cast(m AS signed INTEGER) as int_col from SampleMath;

SELECT cast(regist_date AS DATETIME) as time FROM Product;

SELECT coalesce(m, 1) from SampleMath;

/**
 * 谓词
 */

-- like
SELECT * FROM SampleLike WHERE strcol like 'ddd%';
SELECT * FROM SampleLike WHERE strcol like '%ddd%';
SELECT * FROM SampleLike WHERE strcol like '%ddd';
SELECT * FROM SampleLike WHERE strcol like 'abc__';
SELECT * FROM SampleLike WHERE strcol like 'abc___';

-- between
select product_name, sale_price from Product WHERE sale_price between 100 and 1000;

-- IS NULL IS NOT NULL
select product_name, purchase_price
	from Product 
WHERE purchase_price IS NULL;

select product_name, purchase_price
	from Product 
WHERE purchase_price IS NOT NULL;

-- IN
SELECT product_name, purchase_price from Product WHERE purchase_price IN (320, 500, 5000);
SELECT product_name, purchase_price from Product WHERE purchase_price NOT IN (320, 500, 5000);

-- IN 子查询 (0.0009s,0.0003s, 0.0003s)用in很慢

select sale_price from Product 
WHERE product_id IN (select product_id from ShopProduct WHERE shop_name = '大阪');

select sale_price FROM Product as p join ShopProduct as s on p.product_id = s.product_id WHERE s.shop_name = '大阪';

select product_name, sale_price from Product as p 
WHERE exists (select * from ShopProduct as sp WHERE sp.shop_name = '大阪' and p.product_id = sp.product_id);


select product_name, sale_price from Product as p 
WHERE not exists (select * from ShopProduct as sp WHERE sp.shop_name = '大阪' and p.product_id = sp.product_id);

/**
 * case
 */

select product_name, 
	case 
		when product_type = '衣服' then concat('A', product_type)
		when product_type = '办公用品' then concat('B', product_type)
		when product_type = '厨房用具' then concat('C', product_type)
		else NULL
	end as abc_product_type
from Product;

select SUM(case when product_type = '衣服' then sale_price else 0 end) as sum_price_cloth,
		SUM(case when product_type = '厨房用具' then sale_price else 0 end) as sum_price_kitchen,
		SUM(case when product_type = '办公用品' then sale_price else 0 end) as sum_price_office
FROM Product;


select product_name, purchase_price
	from Product
WHERE purchase_price not in (500, 2800,5000, null);


select 
	sum(case when sale_price < 1000 then 1 else 0 end) as lower,
	sum(case when sale_price between 1000 and 3000 then 1 else 0 end) as mid,
	sum(case when sale_price > 3000 then 1 else 0 end) as upper
from Product;

select (select count(*) from Product WHERE sale_price < 1000) AS lower, (select count(*) from Product WHERE sale_price between 1000 and 3000) AS mid, (select count(*) from Product WHERE sale_price > 3000) as upper;

/**
 * 集合
 */

select product_id, product_type
	FROM Product
union all
select product_id, product_type
	FROM Product2;

select * FROM Product join Product2 on Product.product_id = Product2.product_id;

select product_id, product_name
	FROM Product
WHERE product_type = '厨房用具'
union
select product_id, product_name
	FROM Product2
WHERE product_type = '厨房用具'
ORDER BY product_id;


/**
 * mysql 不支持intersect，except
 */
select product_id, product_name
	FROM Product
EXCEPT
SELECT product_id, product_name
	FROM Product2
ORDER BY product_id;

/**
 * join 内联结必须用on
 */

select *
FROM ShopProduct as sp join Product as p on sp.product_id = p.product_id;

select *
FROM ShopProduct as sp left join Product as p on sp.product_id = p.product_id;

select *
FROM ShopProduct as sp right join Product as p on sp.product_id = p.product_id;


select *
FROM ShopProduct as sp left join Product as p on sp.product_id = p.product_id
union
select *
FROM ShopProduct as sp right join Product as p on sp.product_id = p.product_id;

select *
FROM ShopProduct as sp left join Product as p on sp.product_id = p.product_id
union all
select *
FROM ShopProduct as sp right join Product as p on sp.product_id = p.product_id;


select product_id
FROM ShopProduct
union
select product_id
FROM Product;

select *
FROM ShopProduct as sp join Product as p on sp.product_id = p.product_id;
select * from InventoryProduct;
select *
FROM ShopProduct as sp inner join Product as p 
on sp.product_id = p.product_id 
inner join InventoryProduct as ip
on sp.product_id = ip.product_id;

select * FROM Product
union 
select * FROM Product;

select coalesce(sp.shop_id, '不确定'), coalesce(sp.shop_name, '不确定')
FROM ShopProduct as sp right join Product as p on sp.product_id = p.product_id
ORDER BY sp.product_id;

