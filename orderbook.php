<?php
    //lấy các biến
    $start_time = $_GET['start-time'];
    $end_time = $_GET['end-time'];
    $increase = $_GET['increase'];
    $decrease = $_GET['decrease'];
    $pair = $_GET['pair'];

    if ($pair == "INCH/USD") {
        $sql = "select * from v_pairINCHUSD";
    } else if ($pair == "VSY/USD") {
        $sql = "select * from v_pairVSYUSD";
    } else if ($pair == "AAVE/USD") {
        $sql = "select * from v_pairAAVEUSD";
    } else if ($pair == "ADA/USD") {
        $sql = "select * from v_pairADAUSD";
    } else if ($pair == "ALBT/USD") {
        $sql = "select * from v_pairALBTUSD";
    } else if ($pair == "AXS/USD") {
        $sql = "select * from v_pairAXSUSD";
    } else if ($pair == "ZCN/USD") {
        $sql = "select * from v_pairZCNUSD";
    } else if ($pair == "BEST/USD") {
        $sql = "select * from v_pairBESTUSD";
    } else if ($pair == "ETP/USD") {
        $sql = "select * from v_pairETPUSD";
    } else if ($pair == "SNX/USD") {
        $sql = "select * from v_pairSNXUSD";
    } else if ($pair == "DOG/USD") {
        $sql = "select * from v_pairDOGUSD";
    } else if ($pair == "CLO/USD") {
        $sql = "select * from v_pairCLOUSD";
    } else if ($pair == "YGG/USD") {
        $sql = "select * from v_pairYGGUSD";
    } else {
        // Pair không hợp lệ
        $sql = "";
    }

    if ($increase == 1) {
        $sql .= " ORDER BY ask_price_1 ASC LIMIT 50;";
    } else if ($decrease == 1) {
        $sql .= " ORDER BY ask_price_1 DESC LIMIT 50;";
    } else {
        $sql .= " LIMIT 50;";
    }

    echo $sql;

    try {
        $dbh = new PDO('sqlite:bitfinex.sqlite');
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // hiển thị thông tin hàng tìm kiếm được
    if ($results) {
        echo "<table>";
        echo 
            "<tr>
                <th>time</th>
                <th>ask_price_1</th>
                <th>ask_count_1</th>
                <th>ask_amount_1</th>
                <th>bid_price_1</th>
                <th>bid_count_1</th>
                <th>bid_amount_1</th>
            </tr>";

        foreach ($results as $result) {
            $tmp = $result['time'];
            $datetime = date('Y-m-d H:i:s', $tmp / 1000); 
            echo 
                "<tr>
                    <td>" . $datetime . "</td>
                    <td>" . $result['ask_price_1'] . "</td>
                    <td>" . $result['ask_count_1'] . "</td>
                    <td>" . $result['ask_amount_1'] . "</td>
                    <td>" . $result['bid_price_1'] . "</td>
                    <td>" . $result['bid_count_1'] . "</td>
                    <td>" . $result['bid_amount_1'] . "</td>
                </tr>";
        }
            
        echo "</table>";
    } else {
        echo "Không tìm thấy kết quả nào.";
    }
    $dbh = null;
?>
