<?php
$table = 'menu';
$data = getListByParent($table);
?>

<ul>
    <?php while ($row = $data->fetch_assoc()) {
        echo "<li><a href='index.php?parent=".$row['parent']."&id=".$row['id_menu']."'>" . $row['name_menu'] . "</a></li>";
    } ?>
</ul>