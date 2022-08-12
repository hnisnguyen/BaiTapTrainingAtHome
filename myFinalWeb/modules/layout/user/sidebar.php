<!-- Sidebar cho trang người dùng -->

<?php
$data = getAllDetailById('menu', $_GET['id_lesson']);
$id_menu = "";
while ($row = $data->fetch_assoc()) {
    $id_menu = $row['id_primary'];
}
?>

<div class="user_sidebar">
    <div class="sidebar_header">
        <h3>Bài viết cùng chuyên mục</h3>
    </div>

    <div class="sidebar_content">
        <ul>
            <?php
            $data = getAllDetailByParent('menu', $id_menu);
            $number = 1;
            while ($row = $data->fetch_assoc()) {
                if ($row['id_secondary'] == $_GET['id_lesson']) {
                    echo "<li class='selected'><a href='?id_lesson=".$row['id_secondary']."'>Bài ".$number.": ".$row['name_secondary']."</a></li>";
                } else {
                    echo "<li><a href='?id_lesson=".$row['id_secondary']."'>Bài ".$number.": ".$row['name_secondary']."</a></li>";
                }
                $number ++;
            }
            ?>
        </ul>
    </div>
</div>