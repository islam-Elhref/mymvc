<fieldset class="scheduler-border">
    <legend class="scheduler-border"> <?= isset($legend) ? $legend : '' ?> </legend>

    <div class="form">
        <form method="post" enctype="application/x-www-form-urlencoded" class="needs-validation" novalidate>

            <div class="row row_reverse">

                <div class="form-group col-md-6 flex-column"> <!-- name -->
                    <label for="name"><?= isset($Text_label_name) ? $Text_label_name : '' ?></label>
                    <input type="text" class="form-control box checkExist" id="name" required name="name"
                           minlength="4" maxlength="40" title="<?= $title_name ?>"
                           value="<?= isset($_POST['name']) ? $_POST['name'] : '' ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_name) ? $invalid_msg_name : '' ?> </div>
                </div>
                <div class="form-group col-md-6 flex-column"> <!-- email -->
                    <label for="name"><?= isset($Text_label_email) ? $Text_label_email : '' ?></label>
                    <input type="email" class="form-control box supplierExist" id="email" required name="email"
                           minlength="4" maxlength="40"
                           value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"
                         data-temp="<?= isset($invalid_msg_supplierExist) ? $invalid_msg_supplierExist : '' ?>"
                    ><?= isset($invalid_msg_email) ? $invalid_msg_email : '' ?></div>
                </div>

            </div> <!-- name and email -->
            <div class="row row_reverse">

                <div class="form-group col-md-6 flex-column"> <!-- phone -->
                    <label for="name"><?= isset($Text_label_phone) ? $Text_label_phone : '' ?></label>
                    <input type="tel" class="form-control box checkExist" id="phone" required name="phone"
                           minlength="4" maxlength="15" "
                           value="<?= isset($_POST['phone']) ? $_POST['phone'] : '' ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_phone) ? $invalid_msg_phone : '' ?> </div>
                </div>
                <div class="form-group col-md-6 flex-column"> <!-- address -->
                    <label for="name"><?= isset($Text_label_address) ? $Text_label_address : '' ?></label>
                    <input type="text" class="form-control box checkExist" id="address" required name="address"
                           minlength="4" maxlength="50"
                           value="<?= isset($_POST['address']) ? $_POST['address'] : '' ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_address) ? $invalid_msg_address : '' ?> </div>
                </div>

            </div> <!-- phone and address -->

            <hr>

            <button type="submit" class="btn btn-light save" name="submit"
                    id="submit"><?= isset($Text_add_new) ? $Text_add_new : '' ?></button>
        </form>
    </div>
</fieldset>