<?php require "info.php" ?>
<?php require "validateForm.php" ?>
<?php if ($valid == 0) { ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add news</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    </head>

    <body>
    <?php include "../../BT_Design_Web/layout/header.php" ?>
    <?php include "../../BT_Design_Web/layout/menu.php" ?>
    <div class="container">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h3>Create news</h3>
            <div class="form-group">
                <label for="title">Title</label><br/>
                <input type="text" id="title" name="title" value="<?php echo $title; ?>"/>
                <span class="error">* <?php echo $titleErr; ?></span><br/>
            </div>
            <div class="form-group">
                <label for="date_add">Date</label><br/>
                <input type="date" id="date_add" name="date_add" value="<?php echo date("Y-m-d"); ?>"/><br/>
            </div>
            <div class="form-group">
                <label for="description">Description</label><br/>
                <textarea name="description" id="description" rows="4" cols="50"
                          placeholder="Enter text here ..."><?php echo $description; ?></textarea>
                <span class="error">* <?php echo $descriptionErr; ?></span>
            </div>
            <div class="form-group">
                <label for="content">Content</label><br/>
                <textarea name="content" id="content" rows="4" cols="50"
                          placeholder="Enter text here ..."><?php echo $content; ?></textarea>
                <span class="error">* <?php echo $contentErr; ?></span>
            </div>
            <div class="form-group">
                <input class="button-8" type="submit" id="submitbtn" name="submitbtn" value="Add"/>
                <input class="button-8" type="reset" id="resetbtn" name="resetbtn" value="Reset"/>

            </div>
        </form>


        <a href="listNews.php"><input class="button-8" type="button" value="Back to list"/></a>
    </div>
    <?php include "../../BT_Design_Web/layout/footer.php" ?>
    </body>

    </html>
<?php } ?>

<?php
if ($valid === 1) {
    include "actionSuccess.php";
} ?>