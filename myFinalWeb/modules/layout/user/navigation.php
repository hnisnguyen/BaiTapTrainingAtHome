<!-- Thanh menu cho trang người dùng -->

<?php
$table = 'menu';
$data = getListByParent($table);
?>

<ul>
    <?php while ($row = $data->fetch_assoc()) {
        if (isset($_GET['id'])) {
            if ($row['id_menu'] == $_GET['id']) {
                echo "<li class='nav-selected'><a href='index.php?parent=" . $row['parent'] . "&id=" . $row['id_menu'] . "'>" . $row['name_menu'] . "</a></li>";
            } else {
                echo "<li><a href='index.php?parent=" . $row['parent'] . "&id=" . $row['id_menu'] . "'>" . $row['name_menu'] . "</a></li>";
            }
        } elseif (isset($_GET['id_lesson'])) {
            $data2 = getItemById($table, $_GET['id_lesson'])->fetch_assoc();
            if ($row['id_menu'] == $data2['parent']) {
                echo "<li class='nav-selected'><a href='index.php?parent=" . $row['parent'] . "&id=" . $row['id_menu'] . "'>" . $row['name_menu'] . "</a></li>";
            } else {
                echo "<li><a href='index.php?parent=" . $row['parent'] . "&id=" . $row['id_menu'] . "'>" . $row['name_menu'] . "</a></li>";
            }
        }
        else {
            echo "<li><a href='index.php?parent=" . $row['parent'] . "&id=" . $row['id_menu'] . "'>" . $row['name_menu'] . "</a></li>";
        }
    } ?>
</ul>