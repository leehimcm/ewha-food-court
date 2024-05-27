<html>
<head>
    <title>고객 유형별 인기메뉴</title>
</head>

<body>

<?php
    $conn = mysqli_connect("localhost", "web", "web_admin", "ewha_food_court");
    if(!$conn) {
        echo "Database Connection Error!!";
    }
    if(mysqli_connect_errno()) {
        echo "Could not connect: ".mysqli_connect_error();
        exit();
    }
?>

<h1>성별/연령별 주간 인기메뉴 순위 top5</h1>

<h3>20대 여성</h3>
<?php

    $query = "SELECT M.menu_name, SUM(OM.quantity) AS sales
    FROM menu M
    JOIN ordered_menu OM ON M.menu_id = OM.menu_id
    JOIN order_info O ON OM.order_num = O.order_num
    JOIN customer C ON O.customer_id = C.customer_id
    WHERE SUBSTRING(C.residence_registration_number, 1, 2) BETWEEN 96 AND 99 or SUBSTRING(C.residence_registration_number, 1, 2) between 00 and 05
    AND SUBSTRING(C.residence_registration_number, 8, 1) = '2' or SUBSTRING(C.residence_registration_number, 8, 1) = '4'
    GROUP BY M.menu_name
    ORDER BY SUM(OM.quantity) DESC
    LIMIT 5;";
    $result = mysqli_query($conn, $query);

    echo '<table border="1">
    <tr>
        <th>메뉴</th> 
        <th>판매량</th>
    </tr>
    '; 

    while($row = mysqli_fetch_array($result)) 
    {
        echo "<tr>";
        echo "<td>".$row['menu_name']."</td>";
        echo "<td>".$row["sales"]."</td>";
        echo "</tr>";
    }

    echo '</table>'
    
?>
<br>
<h3>40대 여성</h3>
<?php

    $query = "SELECT M.menu_name, SUM(OM.quantity) AS sales
    FROM menu M
    JOIN ordered_menu OM ON M.menu_id = OM.menu_id
    JOIN order_info O ON OM.order_num = O.order_num
    JOIN customer C ON O.customer_id = C.customer_id
    WHERE SUBSTRING(C.residence_registration_number, 1, 2) BETWEEN 76 AND 85
    AND SUBSTRING(C.residence_registration_number, 8, 1) = '2'
    GROUP BY M.menu_name
    ORDER BY SUM(OM.quantity) DESC
    LIMIT 5;";
    $result = mysqli_query($conn, $query);

    echo '<table border="1">
    <tr>
        <th>메뉴</th> 
        <th>판매량</th>
    </tr>
    '; 

    while($row = mysqli_fetch_array($result)) 
    {
        echo "<tr>";
        echo "<td>".$row['menu_name']."</td>";
        echo "<td>".$row["sales"]."</td>";
        echo "</tr>";
    }

    echo '</table>'
    
?>
<br>
<h3>30대 남성</h3>
<?php

    $query = "SELECT M.menu_name, SUM(OM.quantity) AS sales
    FROM menu M
    JOIN ordered_menu OM ON M.menu_id = OM.menu_id
    JOIN order_info O ON OM.order_num = O.order_num
    JOIN customer C ON O.customer_id = C.customer_id
    WHERE SUBSTRING(C.residence_registration_number, 1, 2) BETWEEN 86 AND 95
    AND SUBSTRING(C.residence_registration_number, 8, 1) = '1'
    GROUP BY M.menu_name
    ORDER BY SUM(OM.quantity) DESC
    LIMIT 5;";
    $result = mysqli_query($conn, $query);

    echo '<table border="1">
    <tr>
        <th>메뉴</th> 
        <th>판매량</th>
    </tr>
    '; 

    while($row = mysqli_fetch_array($result)) 
    {
        echo "<tr>";
        echo "<td>".$row['menu_name']."</td>";
        echo "<td>".$row["sales"]."</td>";
        echo "</tr>";
    }

    echo '</table>'
    
?>
<?php
mysqli_free_result($result);
mysqli_close($conn);
?>
</body>
</html>