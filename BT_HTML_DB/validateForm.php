<?php

$title = $date_add = $description = $content = "";
$titleErr = $date_addErr = $descriptionErr = $contentErr = "";
$valid = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["title"])) {
        $titleErr = "Title is required";
        $valid = 0;
    } else {
        $title = test_input($_POST["title"]);
        $valid = 1;
    }

    if (!empty($_POST["date_add"])) {
        $date_add = test_input($_POST["date_add"]);
        $valid = 1;
    }

    if (empty($_POST["description"])) {
        $descriptionErr = "Description is required";
        $valid = 0;
    } else {
        $description = test_input($_POST["description"]);
        $valid = 1;
    }

    if (empty($_POST["content"])) {
        $contentErr = "Content is required";
        $valid = 0;
    } else {
        $content = test_input($_POST["content"]);
        $valid = 1;
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
