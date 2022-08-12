<?php require "../../validLoggedIn.php" ?>
<?php
include "../../../db/myFunction.php";
$id = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = getUser($id);
    $row = $data->fetch_assoc();
}
?>

<?php
// Xử lý form (method = POST) sau khi bấm nút 'Cập nhật' với nút 'Cập nhật' có name = 'update' => $_POST['update']
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $role = $_POST['role'];
    $result = updateRole($id, $role); // Hàm cập nhật (UPDATE) thông tin trong bảng
    if ($result) {
        echo ("<meta http-equiv='refresh' content='0; url= list.php'>"); // Trả về trang list
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/styles.css">
    <link rel="stylesheet" type="text/css" href="../../../css/popup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>View</title>
</head>

<body>
    <?php include "../../layout/admin/sidebar.php" ?>
    <?php include "../../layout/admin/header.php" ?>
    <div class="container">
        <div class="card">
            <img src="../../../images/avatar_temp.jpg" alt="">
            <?php echo "<h1>" . $row['name'] . "</h1>" ?>
            <?php echo "<p>" . $row['email'] . "</p>" ?>
            <?php
            if ($row['role'] == 1) {
                echo "<p>Super Admin</p>";
            } elseif ($row['role'] == 2) {
                echo "<p>Admin</p>";
            } else {
                echo "<p>User</p>";
            }
            ?>
        </div>
        <?php if ($row['role'] != 1) { ?>
            <form action="" method="post" enctype="multipart/form-data">
                <!-- Truyền id vào input hidden -->
                <input type="hidden" name="id" id="get_id" value='<?= $id ?>' />

                <div class="form-group">
                    <label for="role">Chức năng</label>
                    <select name="role" id="role">
                        <?php
                        
                            if ($row['role'] == 0) {
                                echo "<option selected value='0'>User</option>";
                                echo "<option value='2'>Admin</option>";
                            } elseif ($row['role'] == 2) {
                                echo "<option selected value='2'>Admin</option>";
                                echo "<option value='0'>User</option>";
                            }
                        
                        ?>
                    </select>
                    <div class="button-group">
                        <button type="submit" class="button-33" name="update">Cập nhật</button>
                        <a href="list.php" class="button-16 float-right">Hủy</a>
                    </div>
                </div>

            </form>
        <?php } ?>
    </div>


</body>

</html>