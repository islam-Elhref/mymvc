<fieldset class="scheduler-border">
    <legend class="scheduler-border"> <?= isset($legend) ? $legend : '' ?> </legend>

    <div class="form">
        <form method="post" enctype="application/x-www-form-urlencoded" class="needs-validation " novalidate>

            <div class="form-group"> <!-- username -->
                <label for="name"><?= isset($Text_name) ? $Text_name : '' ?></label>
                <input type="text" class="form-control box" id="name" required name="name">
                <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                <div class="invalid-feedback"><?= isset($invalid_msg_username) ? $invalid_msg_username : '' ?></div>
            </div>

            <div class="form-group">  <!-- password -->
                <label for="password"><?= isset($Text_password) ? $Text_password : '' ?></label>
                <input type="text" class="form-control box" id="password" required name="password">
                <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                <div class="invalid-feedback"><?= isset($invalid_msg_password) ? $invalid_msg_password : '' ?></div>
            </div>

            <div class="form-group"> <!-- email -->
                <label for="email"><?= isset($Text_email) ? $Text_email : '' ?></label>
                <input type="text" class="form-control box" id="email" required name="email">
                <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                <div class="invalid-feedback"><?= isset($invalid_msg_email) ? $invalid_msg_email : '' ?></div>
            </div>



            <hr>

            <button type="submit" class="btn btn-light save" name="submit"
                    id="submit"><?= isset($Text_add_new) ? $Text_add_new : '' ?></button>
        </form>
    </div>
</fieldset>