<fieldset class="scheduler-border">
    <legend class="scheduler-border"><?= isset($legend) ? $legend : '' ?></legend>

    <div class="form">
        <form method="post" enctype="application/x-www-form-urlencoded" novalidate class="needs-validation was-validated">
            <div class="form-group">
                <label for="name"><?= isset($Text_name) ? $Text_name : '' ?></label>
                <input type="text" class="form-control box" id="name" name="name" required
                       value="<?= isset($usergroup) ? $usergroup->getGroupName() : '' ?>">
                <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                <div class="invalid-feedback"><?= isset($invalid_msg_group_name) ? $invalid_msg_group_name : '' ?></div>
            </div>

            <div class="checkbtn">
                <div class="form-check">
                    <label class="col-form-label">
                        <?= isset($privilege_label_title) ? $privilege_label_title : '' ?>
                    </label>
                </div>
            </div> <!-- label for title privilege-->


            <?php if (isset($privileges) && !empty($privileges)): foreach ($privileges as $privilege): ?>
                <div class="checkbtn">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?= $privilege->getPrivilegeId() ?>"
                               name="privilege[]" id="<?= $privilege->getPrivilegeId() ?>"  <?= $this->in_old($privileges_old , $privilege->getPrivilegeId() ) ?>  >
                        <label class="form-check-label" for="<?= $privilege->getPrivilegeId() ?>">
                            <?= $privilege->getPrivilegeName() ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; endif; ?>

            <hr>

            <button type="submit" class="btn btn-light save" name="submit"
                    id="submit"><?= isset($Text_add_new) ? $Text_add_new : '' ?></button>
        </form>
    </div>


</fieldset>

