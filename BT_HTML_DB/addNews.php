<?php require "info.php" ?>

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
    <div  class="container">
        <form action="actionSuccess.php" method="post">
            <h3>Create news</h3>
            <div class="form-group">
            <label for="title">Title</label>
                <input type="text" id="title" name="title" />
            </div>
            <div class="form-group">
                <label for="date_add">Date</label>
                <input type="date" id="date_add" name="date_add" value="<?php echo date("Y-m-d"); ?>" />
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="4" cols="50" placeholder="Enter text here ..."></textarea>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" rows="4" cols="50" placeholder="Enter text here ..."></textarea>
            </div>
            <div class="form-group">
                <input class="button-8" type="submit" id="submitbtn" name="submitbtn" value="Add" />
                <input class="button-8" type="reset" id="resetbtn" name="resetbtn" value="Reset" />

            </div>
        </form>
        <a href="listNews.php"><input class="button-8" type="button" value="Back to list" /></a>
    </div>
</body>

</html>