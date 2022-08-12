<?php
include "../../db/myFunction.php";
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../../css/user-styles.css">

    <!-- Link import cho icon font awesome free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Trang chủ</title>
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
    <main>
        <?php if (isset($_GET['parent']) && isset($_GET['id'])) {
            $id_menu = $_GET['id'];
            $data = getItemById($table, $id_menu);
            $row = $data->fetch_assoc();

            echo "<div class='title'><h2>" . $row['name_menu'] . "</h2></div>" ?>

            <div class="table">
                <table>
                    <thead>
                        <th>Name</th>
                        <th>Link</th>
                    </thead>
                    <tbody>
                        <?php
                        $parent = $id_menu;
                        $data = getListByParent($table, $parent);
                        $num_rows = $data->num_rows;
                        if ($num_rows > 0) {
                            $number = 1;
                            while ($row = $data->fetch_assoc()) {

                                echo '<tr>';
                                echo '<td>Bài ' . $number . ": " . $row['name_menu'] . '</td>';
                                echo '<td><button><a href="content.php?id_lesson=' . $row["id_menu"] . '">Xem</a></button></td>';
                                echo '</tr>';
                                $number += 1;
                            }
                        } else {
                            echo '<tr>';
                            echo '<td>(trống)</td>';
                            echo '<td>(trống)</td>';
                            echo '</tr>';
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </main>
    <footer>
        <!-- thêm footer vào file -->
        <?php include_once "../layout/user/footer.php" ?>
    </footer>

</body>

</html>