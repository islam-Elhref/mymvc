<fieldset class="scheduler-border">
    <legend class="scheduler-border"> <?= isset($legend) ? $legend : '' ?> </legend>

    <div class="form">
        <form method="post" enctype="application/x-www-form-urlencoded" id="sales_form" class="needs-validation"
              novalidate>

            <div class="row dr_arabic">


                <div class="form-group flex-column col-md-4"> <!-- client_id -->
                    <label for="client_id"
                           class="active"><?= isset($Text_label_client_id) ? $Text_label_client_id : '' ?></label>
                    <select name="client_id" id="client_id" class="custom-select" required>
                        <option label="<?= isset($Text_label_client_id) ? $Text_label_client_id : '' ?>" disabled
                                selected
                                value=""></option>
                        <?php
                        if (isset($clients) && !empty($clients)) {
                            foreach ($clients as $client) {
                                ?>
                                <option <?= $this->selectedoptions('client_id', $client->getclientsId()) ?>
                                        value="<?= $client->getclientsId() ?>"> <?= $client->getName() ?>  </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_product_id) ? $invalid_msg_product_id : '' ?></div>
                </div>


                <div class="form-group flex-column col-md-4"> <!-- payment_type -->
                    <label for="payment_type"
                           class="active"><?= isset($Text_label_payment_type) ? $Text_label_payment_type : '' ?></label>
                    <select name="payment_type" id="payment_type" class="custom-select" required>
                        <option label="<?= isset($Text_label_payment_type) ? $Text_label_payment_type : '' ?>" disabled
                                selected value=""></option>
                        <option label="<?= isset($Text_payment_type_1) ? $Text_payment_type_1 : '' ?>" <?= $this->selectedoptions('payment_type', 1) ?>
                                value="1"></option>
                        <option label="<?= isset($Text_payment_type_2) ? $Text_payment_type_2 : '' ?>" <?= $this->selectedoptions('payment_type', 2) ?>
                                value="2"></option>
                    </select>
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_payment_type) ? $invalid_msg_payment_type : '' ?></div>
                </div>


                <div class="form-group flex-column col-md-4" id="product"> <!-- product -->
                    <label for="product_id"
                           class="active"><?= isset($Text_label_product) ? $Text_label_product : '' ?></label>
                    <select name="product_id" id="product_id" class="custom-select">
                        <option label="<?= isset($text_option_product) ? $text_option_product : '' ?>" disabled
                                selected
                                value=""></option>
                        <?php
                        if (isset($products) && !empty($products)) {
                            foreach ($products as $product) {
                                ?>
                                <option <?= $this->selectedoptions('product_id', $product->getproduct_id()) ?>
                                        value="<?= $product->getproduct_id() ?>"> <?= $product->getproduct_name() ?>  </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_product_id) ? $invalid_msg_product_id : '' ?></div>
                </div>
                <button type="button" class="btn btn-link m-auto " id="addproductorder"
                        name="addproductorder"><?= isset($Text_label_add_product) ? $Text_label_add_product : '' ?></button>
                <div class="complete_form" data-count="1">

                </div>
            </div>

            <hr>

            <button type="submit" class="btn btn-light save" name="submit"
                    id="submit"><?= isset($Text_add_new) ? $Text_add_new : '' ?></button>
        </form>
    </div>
</fieldset>