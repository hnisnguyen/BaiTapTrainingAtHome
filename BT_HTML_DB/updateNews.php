<?php
require "info.php" ?>
<?php
if ($_GET['id']) {
    $id = $_REQUEST['id'];
}
$sql = "SELECT * FROM tintuc WHERE id=$id";
$data = $connect->query($sql);
foreach ($data as $key => $value) {
    $title = $value['title'];
    $date_add = $value['date_add'];
    $description = $value['description'];
    $content = $value['content'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit news</title>
    <link rel="stylesheet" href="css/mystyle.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div  class="container">
        <form action="editSuccess.php" method="post">
            <h3>Update news</h3>
            <div class="form-group">
                <input type="hidden" id="id" name="id" value=' <?php echo $id ?> ' />
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value='<?php echo $title ?>' />
            </div>
            <div class="form-group">
                <label for="date_add">Date</label>
                <input type="date" name="date_add" id="date_add" value='<?php echo $date_add ?>' />
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="4" cols="50" placeholder="Enter text here ..."><?php echo $description ?></textarea>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" rows="4" cols="50" placeholder="Enter text here ..."><?php echo $content ?></textarea>
            </div>
            <div class="form-group">
                <input class="button-8" type="submit" id="submitbtn" name="submitbtn" value="Update" />
                <input class="button-8" type="reset" id="resetbtn" name="resetbtn" value="Reset" />
            </div>
        </form>
        <a href="listNews.php"><input class="button-8" type="button" value="Back to list" /></a>
    </div>
</body>

</html>