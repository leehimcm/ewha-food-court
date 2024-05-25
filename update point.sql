create view buy_point (menu_id, points)
as 	select menu_id, price/10
	from menu;

UPDATE customer AS c
JOIN (
    SELECT customer_id, SUM(ordered_menu.quantity * buy_point.points) AS total_points
    FROM order_info
    INNER JOIN ordered_menu ON order_info.order_num = ordered_menu.order_num
    INNER JOIN buy_point ON ordered_menu.menu_id = buy_point.menu_id
    GROUP BY customer_id
) AS points_sum ON c.customer_id = points_sum.customer_id
SET c.points = points_sum.total_points;

UPDATE customer AS c
JOIN (
    SELECT customer_id, COUNT(*) * 50 AS points
    FROM review
    GROUP BY customer_id
) AS rp ON c.customer_id = rp.customer_id
SET c.points = c.points + rp.points;

select customer_name, points
from customer;