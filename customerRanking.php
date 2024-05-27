<html>
<head>
    <title>고객랭킹</title>
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

<h1>고객 랭킹</h1>

<h3>우수 고객 top5</h3>
<?php
    $conn->query("SET @rank := 0;");

    $sql = "SELECT @rank := @rank + 1 AS ranking, customer_name, points
        FROM customer
        ORDER BY points DESC
        LIMIT 5;";

    $result = $conn->query($sql);

    echo '<table border="1">
    <tr>
        <th>순위</th> 
        <th>이름</th>
        <th>포인트</th>
    </tr>
    '; 

    while($row = mysqli_fetch_array($result)) 
    {
        echo "<tr>";
        echo "<td>".$row['ranking']."</td>";
        echo "<td>".$row["customer_name"]."</td>";
        echo "<td>".$row["points"].'p'."</td>";
        echo "</tr>";
    }

    echo '</table>'
?>
<br><br>
<h3>우수 리뷰어 top5</h3>
<?php
    $conn->query("SET @rank := 0;");
    $sql = "SELECT @rank := @rank + 1 AS ranking, customer_name, recommendation
    from review, customer
    where review.customer_id = customer.customer_id
    order by recommendation desc
    limit 5;";

    $result = $conn->query($sql);

    echo '<table border="1">
    <tr>
        <th>순위</th> 
        <th>이름</th>
        <th>리뷰 추천수</th>
    </tr>
    '; 

    while($row = mysqli_fetch_array($result)) 
    {
        echo "<tr>";
        echo "<td>".$row['ranking']."</td>";
        echo "<td>".$row["customer_name"]."</td>";
        echo "<td>".$row["recommendation"]."</td>";
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