<?php
$this->GetMessage();
echo "</br>";
?>

<div class="container h-100">
    <div class="d-flex justify-content-center h-100">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <img src="https://cdn.freebiesupply.com/logos/large/2x/pinterest-circle-logo-png-transparent.png" class="brand_logo" alt="Logo">
                </div>
            </div>
            <div class="d-flex justify-content-center form_container">
                <form class="login_form" method="POST" action="" enctype="application/x-www-form-urlencoded">
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="username" class="form-control input_user" required  value="<?= $this->showvalue('username')  ?>" placeholder="<?= $Text_label_Username  ?>" title="<?= $invalid_msg_username ?>"  oninvalid="this.setCustomValidity(this.title)" oninput="this.setCustomValidity('')" >
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input  type="password" name="password" class="form-control input_pass" required value="" placeholder="<?= $Text_label_Password ?>" title="<?= $invalid_msg_password  ?>" oninvalid="this.setCustomValidity(this.title)" oninput="this.setCustomValidity('')">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customControlInline" name="remember" <?=  $this->checkedbtn('remember')  ?> >
                            <label class="custom-control-label" for="customControlInline"><?= isset($Text_label_RememberMe) ? $Text_label_RememberMe : '' ?></label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button type="submit" name="submit" class="btn login_btn" ><?= isset($Text_label_login) ? $Text_label_login : '' ?></button>
                    </div>
                </form>
            </div>

            <div class="mt-4">
                <div class="d-flex justify-content-center links">
                    <a href="#"><?= isset($Text_label_forget) ? $Text_label_forget : '' ?></a>
                </div>
                <br/>
                <div class="d-flex justify-content-center links alert-primary ">
                    <a class="" href="/language"><?= isset($Text_label_lang) ? $Text_label_lang: '' ?></a>
                </div>
            </div>
        </div>
    </div>
</div>


