

<fieldset class="scheduler-border">
    <legend class="scheduler-border"> <?= isset($legend) ? $legend : '' ?> </legend>

    <div class="form">
        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

            <div class="row row_reverse">

                <div class="form-group col-md-6 flex-column"> <!-- firstname -->
                    <label for="firstname" <?= $this->floatlabel('firstname' , $user_profile) ?> ><?= isset($Text_label_firstname) ? $Text_label_firstname : '' ?></label>
                    <input type="text" class="form-control box " id="firstname" required name="firstname"
                           minlength="3" maxlength="10" pattern="[a-zA-Z ءأ-ي]+" title="<?= $title_firstname ?>"
                           value="<?= $this->showvalue('firstname', $user_profile) ?>"
                    >
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_firstname) ? $invalid_msg_firstname : '' ?></div>
                </div>

                <div class="form-group col-md-6 flex-column"> <!-- lastname -->
                    <label for="lastname" <?= $this->floatlabel('lastname' , $user_profile) ?> ><?= isset($Text_label_lastname) ? $Text_label_lastname : '' ?></label>
                    <input type="text" class="form-control box " id="lastname" required name="lastname"
                           minlength="3" maxlength="10" pattern="[a-zA-Z ءأ-ي]+" title="<?= $title_lastname ?>"
                           value="<?= $this->showvalue('lastname', $user_profile) ?>"
                    >
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_lastname) ? $invalid_msg_lastname : '' ?></div>
                </div>

                <div class="form-group col-md-4 flex-column"> <!-- address -->
                    <label for="address" <?= $this->floatlabel('address' , $user_profile) ?> ><?= isset($Text_label_address) ? $Text_label_address : '' ?></label>
                    <input type="text" class="form-control box " id="address" name="address" maxlength="50"
                           value="<?= $this->showvalue('address', $user_profile) ?>"
                    >
                </div>

                <div class="form-group col-md-4 flex-column"> <!-- image -->
                    <label class="active" for="image"><?= isset($Text_label_image) ? $Text_label_image : '' ?></label>
                    <input type="file" class="form-control " id="image" name="image" accept="image/*" >
                </div>

                <div class="form-group col-md-4 flex-column"> <!-- dob -->
                    <label class="active"  <?= $this->floatlabel('dob' , $user_profile) ?> style="z-index: 9999"
                           for="dob"><?= isset($Text_label_dob) ? $Text_label_dob : '' ?></label>
                    <input type="text" class="form-control" autocomplete="off" id="datepicker" id="dob" name="dob"
                           value="<?= $this->showvalue('dob', $user_profile) ?>"
                    >
                </div>
                <div  style="width: 150px"> <!-- dob -->
                    <img class="img-thumbnail rounded" src="<?= $this->showvalue('image', $user_profile) ?>" >
                </div>
            </div>
            
            <hr>

            <button type="submit" class="btn btn-light save" name="submit"
                    id="submit"><?= isset($Text_add_new) ? $Text_add_new : '' ?></button>
        </form>
    </div>
</fieldset>