<?php
require "info.php";
require "validateForm.php";

if (isset($_GET['id'])) {
    $id = $_REQUEST['id'];
    $sql = "SELECT * FROM tintuc WHERE id=$id";
    $data = $connect->query($sql);
    foreach ($data as $key => $value) {
        $title = $value['title'];
        $date_add = $value['date_add'];
        $description = $value['description'];
        $content = $value['content'];
    }
} else {
    $title = $date_add = $description = $content = "";
}
?>

<?php if ($valid == 0) { ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit news</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    </head>

    <body>
    <?php include "../../BT_Design_Web/layout/header.php" ?>
    <?php include "../../BT_Design_Web/layout/menu.php" ?>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$id"; ?>" method="post">

            <h3>Update news</h3>
            <div class="form-group">
                <input type="hidden" id="id" name="id" value=' <?php echo $id ?> '/>
            </div>
            <div class="form-group">
                <label for="title">Title</label><br/>
                <input type="text" id="title" name="title" value='<?php echo $title ?>'/>
                <span class="error">* <?php echo $titleErr; ?></span><br/>
            </div>
            <div class="form-group">
                <label for="date_add">Date</label><br/>
                <input type="date" name="date_add" id="date_add" value='<?php echo $date_add ?>'/>
            </div>
            <div class="form-group">
                <label for="description">Description</label><br/>
                <textarea name="description" id="description" rows="4" cols="50"
                          placeholder="Enter text here ..."><?php echo $description ?></textarea>
                <span class="error">* <?php echo $descriptionErr; ?></span>
            </div>
            <div class="form-group"><br/><br/>
                <label for="content">Content</label><br/>
                <textarea name="content" id="content" rows="4" cols="50"
                          placeholder="Enter text here ..."><?php echo $content ?></textarea>
                <span class="error">* <?php echo $contentErr; ?></span>
            </div>
            <div class="form-group">
                <input class="button-8" type="submit" id="submitbtn" name="submitbtn" value="Update"/>
                <input class="button-8" type="reset" id="resetbtn" name="resetbtn" value="Reset"/>
            </div>
        </form>
        <a href="listNews.php"><input class="button-8" type="button" value="Back to list"/></a>
    </div>
    <?php include "../../BT_Design_Web/layout/footer.php"?>
    </body>

    </html>

<?php } ?>

<?php
if ($valid === 1) {
    include "actionSuccess.php";
} ?>