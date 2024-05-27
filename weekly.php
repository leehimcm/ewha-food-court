<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>주간 판매량</title>
</head>

<body>
    <?php
    $conn = mysqli_connect("localhost", "web", "web_admin", "ewha_food_court");
    if (!$conn) {
        echo "Database Connection Error!!";
    }

    $conn->query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'");

    $sql = "SELECT 
    DAYNAME(order_time) AS Weekday,
    SUM(menu.price * ordered_menu.quantity) AS Sales
FROM 
    order_info
JOIN 
    ordered_menu ON order_info.order_num = ordered_menu.order_num
JOIN 
    menu ON ordered_menu.menu_id = menu.menu_id
WHERE 
    order_time BETWEEN '2024-05-06' AND '2024-05-13'
GROUP BY 
    DAYOFWEEK(order_time)
ORDER BY 
    CASE WHEN DAYOFWEEK(order_time) = 1 THEN 7 ELSE DAYOFWEEK(order_time) - 1 END;
";

    $result = $conn->query($sql);

    ?>
<h1>주간 판매량</h1>
    <table border="1">
        <tr>
            <th>요일</th>
            <th>판매량</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <td><?php echo $row['Weekday']; ?></td>
                <td><?php echo number_format($row['Sales']); ?></td>
            </tr>
        <?php
        }
        ?>
    </table>

    <?php
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
</body>

</html>