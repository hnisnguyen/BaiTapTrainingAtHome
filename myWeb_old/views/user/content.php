<?php
include "../../db/myFunction.php";

if (isset($_GET['id_lesson'])) {
    $id_lesson = $_GET['id_lesson'];
} else {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/user-styles.css">

    <!-- Link import cho icon font awesome free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Nội dung bài</title>
</head>

<body>
    <header>
        <!-- thêm header vào file -->
        <?php include_once "../layout/user/header.php" ?>
    </header>
    <nav>
        <!-- thêm menu vào file -->
        <?php include_once "../layout/user/navigation.php" ?>
    </nav>

    <div class="container">

        <main>
            <?php
            $data = getItemById($table, $id_lesson);
            $row = $data->fetch_assoc();

            echo "<div class='title'><h3>Bài: " . $row['name_menu'] . "</h3></div>";

            $data = getContent($id_lesson);
            while ($row = $data->fetch_assoc()) {
                echo $row['content'];
            }
            ?>
        </main>

        <?php include "../layout/user/sidebar.php" ?>
    </div>

    <footer>
        <!-- thêm footer vào file -->
        <?php include_once "../layout/user/footer.php" ?>
    </footer>
</body>

</html>