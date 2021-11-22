<fieldset class="scheduler-border">
    <legend class="scheduler-border"> <?= isset($legend) ? $legend : '' ?> </legend>

    <div class="form">
        <form method="post" enctype="application/x-www-form-urlencoded" id="purchases_form" class="needs-validation"
              novalidate>

            <div class="row dr_arabic">


                <div class="form-group flex-column col-md-4"> <!-- supplier_id -->
                    <label for="supplier_id"
                           class="active"><?= isset($Text_label_supplier_id) ? $Text_label_supplier_id : '' ?></label>
                    <select name="supplier_id" id="supplier_id" class="custom-select" required>
                        <option label="<?= isset($Text_label_supplier_id) ? $Text_label_supplier_id : '' ?>" disabled
                                selected
                                value=""></option>
                        <?php
                        if (isset($suppliers) && !empty($suppliers)) {
                            foreach ($suppliers as $supplier) {
                                ?>
                                <option <?= $this->selectedoptions('supplier_id', $supplier->getSuppliersId(), $purchase) ?>
                                        value="<?= $supplier->getSuppliersId() ?>"> <?= $supplier->getName() ?>  </option>
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
                        <option label="<?= isset($Text_payment_type_1) ? $Text_payment_type_1 : '' ?>" <?= $this->selectedoptions('payment_type', 1, $purchase) ?>
                                value="1"></option>
                        <option label="<?= isset($Text_payment_type_2) ? $Text_payment_type_2 : '' ?>" <?= $this->selectedoptions('payment_type', 2, $purchase) ?>
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
                                if (($this->selectedoptions('product_id', $product->getproduct_id(), $purchase_orders))) {
                                    ?>
                                    <option <?= $this->selectedoptions('product_id', $product->getproduct_id()) ?>
                                            value="<?= $product->getproduct_id() ?>"> <?= $product->getproduct_name() ?>  </option>
                                <?php
                                }else{
                                    ?>
                                    <option hidden class="product_delete" <?= $this->selectedoptions('product_id', $product->getproduct_id()) ?>
                                            value="<?= $product->getproduct_id() ?>"> <?= $product->getproduct_name() ?>  </option>
                                    <?php
                                }
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
                    <?php
                    if (isset($purchase_orders) && !empty($purchase_orders)) {
                        foreach ($purchase_orders as $purchase_order) {
                            $count_in_store = $purchase_order->getproductallowcount($purchase_order->getproduct_id()) ;
                            $min = $purchase_order->getorder_quantity() - $count_in_store ;
                            ?>
                            <div class="row product_plus" data-id='<?= $purchase_order->getproduct_id() ?>'>
                                <div class="form-group col-md-2"> <!-- payment_type -->
                                    <label for="payment_type"
                                           class="active" id="product_name"><?= $Text_show_product_name ?></label>
                                    <input type="text" name="product_name_add" class="form-control" required readonly
                                           disabled value="<?= $purchase_order->product_name ?>">
                                    <input type="text" name="product_id_add[]" class="form-control" required readonly
                                           hidden value="<?= $purchase_order->getproduct_id() ?>">
                                </div>
                                <div class="form-group flex-column col-md-3 "> <!-- count_add -->
                                    <label for="payment_type"
                                           class="active" id="product_count"><?= $Text_show_product_quantity ?></label>
                                    <input type="number" name="product_count_add[]" class=" product_count_add buy form-control" required min="<?= $min ?>"  autocomplete="off"
                                           value="<?= $purchase_order->getorder_quantity() ?>">
                                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                                    <div class="invalid-feedback"
                                         data-temp="<?= isset($invalid_msg_add_count_min) ? $invalid_msg_add_count_min : '' ?>"
                                         data-old="<?= isset($Text_label_product_count_add) ? $Text_label_product_count_add : '' ?>">
                                    </div>
                                </div>

                                <div class="allow_count col-md-2">
                                    <label class="active"> <small><?= $Text_count ?></small> </label>
                                   <p> <?= $min ?> </p>
                                </div>

                                <div class="form-group col-md-2 "> <!-- price_add -->
                                    <label for="payment_type"
                                           class="active" id="product_price"><?= $Text_show_product_price ?></label>
                                    <input type="text" name="product_price_add[]" class="form-control" required readonly
                                           disabled value="<?= $purchase_order->BuyPrice ?>">
                                </div>
                                <div class="btn btn-rounded closeproduct text-danger"><i class="fa fa-times"></i></div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <hr>

            <button type="submit" class="btn btn-light save" name="submit"
                    id="submit"><?= isset($Text_add_new) ? $Text_add_new : '' ?></button>
        </form>
    </div>
</fieldset>

