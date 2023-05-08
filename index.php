<!DOCTYPE html>
<html>
<head>
    <title>Trang web của tôi</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tải các tệp CSS -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <!-- Menu thả xuống để chọn cặp tiền -->
    <select id="pair">
        <option value="none">none</option>
        <option value="INCH/USD">INCH/USD</option>
        <option value="VSY/USD">VSY/USD</option>
        <option value="AAVE/USD">AAVE/USD</option>
        <option value="ADA/USD">ADA/USD</option>
        <option value="ALBT/USD">ALBT/USD</option>
        <option value="AXS/USD">AXS/USD</option>
        <option value="ZCN/USD">ZCN/USD</option>
        <option value="BEST/US">BEST/USD</option>
        <option value="ETP/USD">ETP/USD</option>
        <option value="SNX/USD">SNX/USD</option>
        <option value="BDOG/USD">BDOG/USD</option>
        <option value="CLO/USD">CLO/USD</option>
        <option value="YGG/USD">YGG/USD</option>
        <!-- Thêm các tùy chọn khác tương ứng với các cặp tiền khác -->
    </select>

    <form id="time-form" method="get">
        <label for="start-time">Thời gian bắt đầu:</label>
        <input type="date" id="start-time" name="start-time">
        <br>
        <label for="end-time">Thời gian kết thúc:</label>
        <input type="date" id="end-time" name="end-time">
        <br>
        <input type="submit" value="Submit">
    </form>

    <label>
        <input type="checkbox" id="sort-checkbox"> Sắp xếp theo giá trị tăng dần của ask_price 
        <input type="checkbox" id="sort-checkbox2"> Sắp xếp theo giá trị giảm dần của ask_price 
        <input type="checkbox" id="sort-checkbox"> Sắp xếp theo giá trị tăng dần của bid_price 
        <input type="checkbox" id="sort-checkbox"> Sắp xếp theo giá trị giảm dần của bid_price 
    </label>

    <!-- Phần tử HTML để hiển thị kết quả -->
    <div id="orderbook"></div>

    <!-- Script xử lý sự kiện và gửi yêu cầu AJAX -->
    <script>
        //disable
        const form = document.querySelector('#time-form');
        form.querySelectorAll('input').forEach(input => {
        input.disabled = true;
        });

        var checkboxes = document.querySelectorAll('input[type=checkbox]'); // lấy tất cả các checkbox trong form
        for (var i = 0; i < checkboxes.length; i++) { // lặp qua từng checkbox và set thuộc tính disabled thành true
            checkboxes[i].disabled = true;
        }

        // Lấy phần tử HTML để hiển thị kết quả
        var orderbookEl = document.getElementById("orderbook");
        // Lấy phần tử HTML để chọn cặp tiền
        var pairEl = document.getElementById("pair");

        // Xử lý sự kiện khi người dùng thay đổi cặp tiền
        pairEl.addEventListener("change", function() {
            //enable
            form.querySelectorAll('input').forEach(input => {
            input.disabled = false;
            });

            var checkboxes = document.querySelectorAll('input[type=checkbox]'); // lấy tất cả các checkbox trong form
            for (var i = 0; i < checkboxes.length; i++) { // lặp qua từng checkbox và set thuộc tính disabled thành true
                checkboxes[i].disabled = false;
            }


            // Lấy giá trị của cặp tiền được chọn
            var pair = pairEl.value;
            // Gửi yêu cầu AJAX tới tệp orderbook.php để lấy thông tin orderbook
            var xhr = new XMLHttpRequest();
            console.log(pair);
            let url = "orderbook.php?start-time=" + startTime + "&end-time=" + endTime + "&increase=" + increase + "&decrease=" + decrease + "&pair=" + pair;
            xhr.open("GET", url);
            xhr.onload = function() {
                // Cập nhật nội dung của phần tử HTML để hiển thị kết quả
                orderbookEl.innerHTML = xhr.responseText;
            };
            xhr.send();

        });

        // -------------------
        // Lấy phần tử HTML form và phần tử HTML để hiển thị kết quả
        var formEl = document.getElementById("time-form");
        var orderbookEl = document.getElementById("orderbook");
        
        var increase = 0;
        var decrease = 0;

        let sortCheckbox = document.getElementById("sort-checkbox");
        let sortCheckbox2 = document.getElementById("sort-checkbox2");

        // Xử lý checked của checkbox
        sortCheckbox.addEventListener('change', function() {
            if (this.checked) {
                sortCheckbox2.disabled = true;
                increase = 1;   
            } else {
                increase = 0;
                sortCheckbox2.disabled = false;
            }
        });

        sortCheckbox2.addEventListener('change', function() {
            if (this.checked) {
                sortCheckbox.disabled = true;
                decrease = 1;   
            } else {
                decrease = 0;
                sortCheckbox.disabled = false;
            }
        });

    
        // Xử lý sự kiện submit của form time va checkbox
        formEl.addEventListener("submit", function(event) {
            
            // Ngăn chặn sự kiện mặc định của form
            event.preventDefault();

            // Lấy giá trị của start-time và end-time từ form
            var startTime = document.getElementById("start-time").value;
            var endTime = document.getElementById("end-time").value;

            // Lấy giá trị của cặp tiền được chọn
            var pair = pairEl.value;

            // Gửi yêu cầu AJAX tới tệp orderbook.php để lấy thông tin orderbook
            var xhr = new XMLHttpRequest();
            console.log(pair);
            let url = "orderbook.php?start-time=" + startTime + "&end-time=" + endTime + "&increase=" + increase + "&decrease=" + decrease + "&pair=" + pair;
            xhr.open("GET", url);
            xhr.onload = function() {
                // Cập nhật nội dung của phần tử HTML để hiển thị kết quả
                orderbookEl.innerHTML = xhr.responseText;
            };
            xhr.send();
        });

    </script>

    <!-- Đoạn mã PHP để đưa dữ liệu từ cơ sở dữ liệu vào trang web -->
    <?php

    ?>
</body>



</html>
