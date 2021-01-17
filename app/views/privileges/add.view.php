<div class="form">
    <form method="post" enctype="application/x-www-form-urlencoded">
        <div class="form-group">
            <label for="name"><?= isset($Text_name) ? $Text_name : '' ?></label>
            <input type="text" class="form-control box" id="name" required name="name">
        </div>
        <button type="submit" class="btn btn-light save" name="submit" id="submit"><?= isset($Text_add_new) ? $Text_add_new : '' ?></button>
    </form>
</div>
