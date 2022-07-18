<?php
require "info.php";

if ($_GET['id']) {
    $id = $_REQUEST['id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete?</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
    <div  class="container">
        <form action="actionSuccess.php" method="post">
            <h3>Delete news id = <?php echo $id ?> ???</h3>
            <div>
                <input type="hidden" id="id" name="id" value=' <?php echo $id ?> ' />
            </div>
            <input class="button-8" type="submit" id="submitbtn" name="submitbtn" value="Confirm" />
        </form>
        <div>
            <h4>Or</h4>
            <a href="listNews.php"><input class="button-8" type="button" value="Back to list"></a>
        </div>
    </div>
</body>

</html>