<fieldset class="scheduler-border">
    <legend class="scheduler-border"> <?= isset($legend) ? $legend : '' ?> </legend>

    <div class="form">
        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

            <div class="row dr_arabic">
                <div class="form-group col-md-12 flex-column"> <!-- category name -->
                    <label for="category_name" <?= $this->floatlabel('category_name') ?> ><?= isset($Text_label_category_name) ? $Text_label_category_name : '' ?></label>
                    <input type="text" class="form-control box" id="category_name" required name="category_name"
                           maxlength="30"
                           value="<?= $this->showvalue('category_name') ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_category_name) ? $invalid_msg_category_name : '' ?> </div>
                </div>
            </div>


            <hr>

            <button type="submit" class="btn btn-light save" name="submit"
                    id="submit"><?= isset($Text_add_new) ? $Text_add_new : '' ?></button>
        </form>
    </div>
</fieldset>