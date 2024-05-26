<!DOCTYPE html>
<html>
<head>
    <title>코너별 메뉴별 주문 건수와 매출</title>
</head>
<body>
<?php
$conn = mysqli_connect("localhost", "web", "web_admin", "ewha_food_court");
if (!$conn) {
    echo "Database Connection Error!!";
}
if (mysqli_connect_errno()) {
    echo "Could not connect: " . mysqli_connect_error();
    exit();
}

function displayCornerInfo($conn, $cornerId, $cornerName) {
    $query = "SELECT 
        M.menu_name AS 메뉴이름,
        SUM(OM.quantity) AS 주문건수,
        M.price * SUM(OM.quantity) AS 매출
    FROM 
        menu M
    JOIN 
        ordered_menu OM ON M.menu_id = OM.menu_id
    WHERE 
        M.corner_id = $cornerId
    GROUP BY 
        M.menu_name";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Query Error: " . mysqli_error($conn);
        exit();
    }
    ?>
    <!--테이블 생성-->
    <h1><?= $cornerName ?>의 메뉴별 주문 건수와 매출</h1>

    <table border="1">
        <tr>
            <th>메뉴이름</th>
            <th>주문건수</th>
            <th>매출</th>
        </tr>

    <?php
    while ($row = mysqli_fetch_array($result)) {
    ?>
        <tr>
            <td><?= $row['메뉴이름'] ?></td>
            <td><?= $row['주문건수'] ?></td>
            <td><?= $row['매출'] ?></td>
        </tr>
    <?php } ?>
    </table>

    <?php
    mysqli_free_result($result);
    ?>
}


// 코너 1 한식
displayCornerInfo($conn, 1, "코너 1 한식");

// 코너 2 분식
displayCornerInfo($conn, 2, "코너 2 분식");

// 코너 3 중국음식
displayCornerInfo($conn, 3, "코너 3 중국음식");

// 코너 4 아시안음식
displayCornerInfo($conn, 4, "코너 4 아시안음식");

// 코너 5 양식
displayCornerInfo($conn, 5, "코너 5 양식");

<?php
$popular_menu_query = "SELECT 
                        M.corner_id AS 코너번호,
                        M.menu_name AS 메뉴이름,
                        SUM(OM.quantity) AS 주문건수,
                        M.price * SUM(OM.quantity) AS 매출
                    FROM 
                        menu M
                    JOIN 
                        ordered_menu OM ON M.menu_id = OM.menu_id
                    GROUP BY 
                        M.corner_id
                    ORDER BY 
                        SUM(OM.quantity) DESC";

$popular_menu_result = mysqli_query($conn, $popular_menu_query);

if (!$popular_menu_result) {
    echo "Query Error: " . mysqli_error($conn);
    exit();
}
?>

<!--테이블 생성-->
<h1>코너별 가장 인기있는 메뉴</h1>

<table border="1">
    <tr>
        <th>코너번호</th>
        <th>메뉴이름</th>
        <th>주문건수</th>
        <th>매출</th>
    </tr>

<?php
while ($row = mysqli_fetch_array($popular_menu_result)) {
?>
    <tr>
        <td><?= $row['코너번호'] ?></td>
        <td><?= $row['메뉴이름'] ?></td>
        <td><?= $row['주문건수'] ?></td>
        <td><?= $row['매출'] ?></td>
    </tr>
<?php } ?>
</table>

<?php
mysqli_free_result($popular_menu_result);
?>

<?php
mysqli_close($conn);
?>

</body>
</html>
