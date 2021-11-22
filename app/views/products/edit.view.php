<fieldset class="scheduler-border">
    <legend class="scheduler-border"> <?= isset($legend) ? $legend : '' ?> </legend>

    <div class="form">
        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

            <div class="row dr_arabic">
                <div class="form-group col-md-12 flex-column"> <!-- product_name -->
                    <label for="product_name" <?= $this->floatlabel('product_name' , $product) ?> ><?= isset($Text_label_product_name) ? $Text_label_product_name : '' ?></label>
                    <input type="text" class="form-control box" id="product_name" required name="product_name"
                           maxlength="30"
                           value="<?= $this->showvalue('product_name', $product) ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_product_name) ? $invalid_msg_product_name : '' ?> </div>
                </div>

                <div class="form-group flex-column col-md-3"> <!-- Group Name -->
                    <select name="category_id" id="category_id" class="custom-select" required>
                        <option label="<?= isset($Text_label_category_id) ? $Text_label_category_id : '' ?>" disabled
                                selected
                                value=""></option>
                        <?php
                        if (isset($categories) && !empty($categories)) {
                            foreach ($categories as $category) {
                                ?>
                                <option <?= $this->selectedoptions('category_id', $product->getcategory_id() , $product ) ?>
                                        value="<?= $category->getcategory_id() ?>"> <?= $category->getcategory_name() ?>  </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_category_id) ? $invalid_msg_category_id : '' ?></div>
                </div>

                <div class="form-group flex-column col-md-3"> <!-- units -->
                    <select name="unit" id="unit" class="custom-select" required>
                        <option label="<?= isset($Text_label_unit) ? $Text_label_unit : '' ?>" disabled selected value="" ></option>
                        <option label="<?= isset($msg_unit_1) ? $msg_unit_1 : '' ?>" <?= $this->selectedoptions('unit', 1 , $product) ?>  value="1"></option>
                        <option label="<?= isset($msg_unit_2) ? $msg_unit_2 : '' ?>"   <?= $this->selectedoptions('unit', 2 , $product) ?>   value="2"></option>
                        <option label="<?= isset($msg_unit_3) ? $msg_unit_3 : '' ?>" <?= $this->selectedoptions('unit', 3, $product) ?> value="3"></option>
                        <option label="<?= isset($msg_unit_4) ? $msg_unit_4 : '' ?>" <?= $this->selectedoptions('unit', 4, $product) ?> value="4"></option>
                    </select>
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_unit) ? $invalid_msg_unit : '' ?></div>
                </div>

                <div class="form-group col-md-3 flex-column"> <!-- BuyPrice -->
                    <label for="BuyPrice" <?= $this->floatlabel('BuyPrice', $product) ?> ><?= isset($Text_label_BuyPrice) ? $Text_label_BuyPrice : '' ?></label>
                    <input type="number" class="form-control box" id="BuyPrice" required name="BuyPrice" step="0.5"
                           value="<?= $this->showvalue('BuyPrice', $product) ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_BuyPrice) ? $invalid_msg_BuyPrice : '' ?> </div>
                </div>

                <div class="form-group col-md-3 flex-column"> <!-- SellPrice -->
                    <label for="SellPrice" <?= $this->floatlabel('SellPrice', $product) ?> ><?= isset($Text_label_SellPrice) ? $Text_label_SellPrice : '' ?></label>
                    <input type="number" class="form-control box" id="SellPrice" required name="SellPrice" step="0.5"
                           value="<?= $this->showvalue('SellPrice', $product) ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_SellPrice) ? $invalid_msg_SellPrice : '' ?> </div>
                </div>


            </div>

            <hr>

            <button type="submit" class="btn btn-light save" name="submit"
                    id="submit"><?= isset($Text_add_new) ? $Text_add_new : '' ?></button>
        </form>
    </div>
</fieldset>