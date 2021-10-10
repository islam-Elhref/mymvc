<br>
<?php
$this->GetMessage();
?>

<a href="/auth/logout" class="btn btn-danger"> <i class="fa fa-arrow-alt-circle-left"></i> <?= $Text_logout ?></a>

<fieldset class="scheduler-border">
    <legend class="scheduler-border"> <?= isset($legend) ? $legend : '' ?> </legend>

    <div class="form">
        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

            <div class="row row_reverse">

                <div class="form-group col-md-6 flex-column"> <!-- firstname -->
                    <label for="firstname"><?= isset($Text_label_firstname) ? $Text_label_firstname : '' ?></label>
                    <input type="text" class="form-control box " id="firstname" required name="firstname"
                           minlength="3" maxlength="10" pattern="[a-zA-Z\p{Arabic}]+" title="<?= $title_firstname ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_firstname) ? $invalid_msg_firstname : '' ?></div>
                </div>

                <div class="form-group col-md-6 flex-column"> <!-- lastname -->
                    <label for="lastname"><?= isset($Text_label_lastname) ? $Text_label_lastname : '' ?></label>
                    <input type="text" class="form-control box " id="lastname" required name="lastname"
                           minlength="3" maxlength="10" pattern="[a-zA-Z\p{Arabic}]+" title="<?= $title_lastname ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_lastname) ? $invalid_msg_lastname : '' ?></div>
                </div>

                <div class="form-group col-md-4 flex-column"> <!-- address -->
                    <label for="address"><?= isset($Text_label_address) ? $Text_label_address : '' ?></label>
                    <input type="text" class="form-control box " id="address" name="address" maxlength="50">
                </div>

                <div class="form-group col-md-4 flex-column"> <!-- image -->
                    <label class="active" for="image"><?= isset($Text_label_image) ? $Text_label_image : '' ?></label>
                    <input type="file" class="form-control " id="image" name="image" required>
                </div>

                <div class="form-group col-md-4 flex-column"> <!-- dob -->
                    <label class="active" style="z-index: 9999"
                           for="dob"><?= isset($Text_label_dob) ? $Text_label_dob : '' ?></label>
                    <input type="text" class="form-control" autocomplete="off" id="datepicker" id="dob" name="dob">
                </div>
            </div>

            <hr>

            <button type="submit" class="btn btn-light save" name="submit"
                    id="submit"><?= isset($Text_add_new) ? $Text_add_new : '' ?></button>
        </form>
    </div>
</fieldset>