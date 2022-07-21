<form action="actionSuccess.php" method="post">
    <input type="hidden" name="id" id="get_id" value='<?php echo $_GET['id']; ?>' />
    <input type="hidden" name="table" id="get_table">
    <div id="popup1" class="overlay">
        <div class="popup">
            <a class="close" href="">&times;</a>
            <div class="content">
                Bạn có chắc muốn xóa không?
            </div>
            <div class="footerpopup">
                <button type="submit" class="btn btn-primary" name="delete">OK</button>
                <a href="" class="btn btn-secondary float-right">Hủy</a>
            </div>
        </div>
    </div>
</form>