<?php
include 'connect/connection.php';

// ดึงข้อมูลจากตาราง menu
$sql = "SELECT id, name, stock FROM menu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการ Stock</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <div class="container">
        <nav class="navbar">
            <div class="logo">
                <a href="#"><img src="pic/logo.png" alt="logo"></a>
            </div>
            <ul class="menu">
                <li><a href="admin.php" class="active">Stock</a></li>
                <li><a href="admin_conf.php" class="">Order</a></li>
                <li><a href="admin_transaction.php" class="">Transaction</a></li>
            </ul>
        </nav>
    </div>

        <h2>จัดการ Stock สินค้า</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ชื่อเมนู</th>
                    <th>Stock ปัจจุบัน</th>
                    <th>เปลี่ยนแปลง</th>
                    <th>ดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td id="stock-<?php echo $row['id']; ?>"><?php echo $row['stock']; ?></td>
                    <td>
                        <select class="action" data-id="<?php echo $row['id']; ?>">
                            <option value="increase">เพิ่ม</option>
                            <option value="decrease">ลด</option>
                        </select>
                        <input type="number" class="amount" data-id="<?php echo $row['id']; ?>" min="1" value="1">
                    </td>
                    <td>
                        <button class="update-stock" data-id="<?php echo $row['id']; ?>">อัปเดต</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $(".update-stock").click(function() {
                let menuId = $(this).data("id");
                let action = $(".action[data-id='" + menuId + "']").val();
                let amount = parseInt($(".amount[data-id='" + menuId + "']").val());

                if (amount > 0) {
                    $.post("update_stock.php", { menu_id: menuId, action: action, amount: amount }, function(response) {
                        let data = JSON.parse(response);
                        if (data.success) {
                            $("#stock-" + menuId).text(data.new_stock);
                            alert("Stock อัปเดตสำเร็จ!");
                        } else {
                            alert("เกิดข้อผิดพลาด: " + data.message);
                        }
                    });
                } else {
                    alert("กรุณาระบุจำนวนที่มากกว่า 0");
                }
            });
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>
