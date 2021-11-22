<fieldset class="scheduler-border">
    <legend class="scheduler-border"> <?= isset($legend) ? $legend : '' ?> </legend>

    <div class="form">
        <form method="post" enctype="application/x-www-form-urlencoded" class="needs-validation"   novalidate>

            <div class="row row_reverse">

                <div class="form-group col-md-4 flex-column">  <!-- password -->
                    <label for="password" <?= $this->floatlabel('Password') ?> ><?= isset($Text_label_Password) ? $Text_label_Password : '' ?></label>
                    <input type="password" class="form-control box" id="password"  name="Password" minlength="6" maxlength="20"
                           value="" autocomplete="new-password">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_password) ? $invalid_msg_password : '' ?></div>
                </div>

                <div class="form-group col-md-4 flex-column">  <!-- password -->
                    <label for="cpassword" <?= $this->floatlabel('Password' ) ?> ><?= isset($Text_label_CPassword) ? $Text_label_CPassword : '' ?></label>
                    <input type="password" class="form-control box" id="CPassword"  name="CPassword" minlength="6" maxlength="20"
                        value=""  autocomplete="new-password"  >
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_password) ? $invalid_msg_password : '' ?></div>
                </div>
            </div>

            <div class="row row_reverse">


                <div class="form-group col-md-4 flex-column"> <!-- email -->
                    <label for="email" <?= $this->floatlabel('Email' , $userActive ) ?> ><?= isset($Text_label_Email) ? $Text_label_Email : '' ?></label>
                    <input type="email" class="form-control box checkExist " id="email" required name="Email"
                           value="<?=  $this->showvalue('Email' , $userActive ) ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"
                         data-temp="<?= isset($invalid_msg_emailExist) ? $invalid_msg_emailExist : '' ?>"
                    ><?= isset($invalid_msg_email) ? $invalid_msg_email : '' ?></div>
                </div>
                <div class="form-group col-md-4 flex-column"> <!-- email -->
                    <label for="cemail" <?= $this->floatlabel('Email' , $userActive ) ?> ><?= isset($Text_label_CEmail) ? $Text_label_CEmail : '' ?></label>
                    <input type="email" class="form-control box" id="CEmail" required name="CEmail"
                           value="<?=  $this->showvalue('CEmail' , $userActive ) ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_email) ? $invalid_msg_email : '' ?></div>
                </div>

                <div class="form-group col-md-4 flex-column"> <!-- phone -->
                    <label for="phone" <?= $this->floatlabel('Phone' , $userActive ) ?> ><?= isset($Text_label_Phone) ? $Text_label_Phone : '' ?></label>
                    <input type="tel" class="form-control box" id="phone" name="Phone"
                           value="<?=  $this->showvalue('Phone' , $userActive ) ?>" minlength="11" maxlength="11" pattern="^01[0-9]{9}$" >
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_phone) ? $invalid_msg_phone : '' ?></div>
                </div>
            </div>`


            <hr>

            <button type="submit" class="btn btn-light save" name="submit"
                    id="submit"><?= isset($Text_add_new) ? $Text_add_new : '' ?></button>
        </form>
    </div>
</fieldset>