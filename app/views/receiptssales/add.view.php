<fieldset class="scheduler-border">
    <legend class="scheduler-border"> <?= isset($legend) ? $legend : '' ?> </legend>

    <div class="form">
        <form method="post" enctype="application/x-www-form-urlencoded" id="purchases_form" class="needs-validation"
              novalidate>

            <div class="row dr_arabic">


                <div class="form-group flex-column col-md-3"> <!-- bill_id -->
                    <label for="bill_id"
                           class="active"><?= isset($Text_label_bill_id) ? $Text_label_bill_id : '' ?></label>
                    <select name="bill_id" id="bill_id" class="custom-select" required>
                        <option label="<?= isset($Text_label_bill_id) ? $Text_label_bill_id : '' ?>" disabled
                                selected
                                value=""></option>
                        <?php
                        if (isset($sales) && !empty($sales)) {
                            foreach ($sales as $sale) {
                                ?>
                                <option <?= $this->selectedoptions('bill_id', $sale->getbill_id()) ?>
                                        value="<?= $sale->getbill_id() ?>"> <?= $sale->getbill_id() . ' :-- ' . $sale->getclientname() ?>  </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_bill_id) ? $invalid_msg_bill_id : '' ?></div>
                </div> <!-- bill_id -->

                <div class="form-group col-md-2 flex-column"> <!-- bill_price -->
                    <label class="active" ><?= isset($Text_label_bill_price) ? $Text_label_bill_price : '' ?></label>
                    <input type="text" id="bill_price" class="form-control box" disabled readonly value="" >
                    <i class="icon fa fa-arrow"></i>
                </div> <!-- receipt_price -->

                <div class="form-group col-md-2 flex-column"> <!-- receipt_price -->
                    <label for="receipt_price" <?= $this->floatlabel('receipt_price') ?> ><?= isset($Text_label_receipt_price) ? $Text_label_receipt_price : '' ?></label>
                    <input type="number" class="form-control box" id="receipt_price" required name="receipt_price" min="1"
                           value="<?= $this->showvalue('receipt_price') ?>" >
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_receipt_price) ? $invalid_msg_receipt_price : '' ?> </div>
                </div> <!-- receipt_price -->


                <div class="form-group col-md-3 flex-column"> <!-- receipt_price -->
                    <label for="reciept_literal_price" <?= $this->floatlabel('reciept_literal_price') ?> ><?= isset($Text_label_reciept_literal_price) ? $Text_label_reciept_literal_price : '' ?></label>
                    <input type="text" class="form-control box" id="reciept_literal_price" required name="reciept_literal_price" minlength="5"
                           value="<?= $this->showvalue('reciept_literal_price') ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_reciept_literal_price) ? $invalid_msg_reciept_literal_price : '' ?> </div>
                </div> <!-- receipt_price -->

                <div class="form-group flex-column col-md-2"> <!-- reciept_type -->
                    <label for="reciept_type"
                           class="active"><?= isset($Text_label_reciept_type) ? $Text_label_reciept_type : '' ?></label>
                    <select name="reciept_type" id="reciept_type" class="custom-select sales" required>
                        <option label="<?= isset($Text_label_reciept_type) ? $Text_label_reciept_type : '' ?>" disabled
                                selected value=""></option>
                        <option label="<?= isset($Text_reciept_type_1) ? $Text_reciept_type_1 : '' ?>" <?= $this->selectedoptions('reciept_type', 1) ?>
                                value="1"></option>
                        <option label="<?= isset($Text_reciept_type_2) ? $Text_reciept_type_2 : '' ?>" <?= $this->selectedoptions('reciept_type', 2) ?>
                                value="2"></option>
                    </select>
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_reciept_type) ? $invalid_msg_reciept_type : '' ?></div>
                </div> <!-- reciept_type -->

                </div>

            <div id="receipt_bank" class="row dr_arabic">

                <div class="form-group col-md-4 flex-column"> <!-- bank_name -->
                    <label for="bank_name" <?= $this->floatlabel('bank_name') ?> ><?= isset($Text_label_bank_name) ? $Text_label_bank_name : '' ?></label>
                    <input type="text" class="form-control box" id="bank_name"  name="bank_name"
                           value="<?= $this->showvalue('bank_name') ?>" >
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_bank_name) ? $invalid_msg_bank_name : '' ?> </div>
                </div> <!-- bank_name -->

                <div class="form-group col-md-3 flex-column"> <!-- bank_account_number -->
                    <label for="bank_account_number" <?= $this->floatlabel('bank_account_number') ?> ><?= isset($Text_label_bank_account_number) ? $Text_label_bank_account_number : '' ?></label>
                    <input type="text" class="form-control box" id="bank_account_number"  name="bank_account_number" pattern="[0-9]+"
                           value="<?= $this->showvalue('bank_account_number') ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_bank_account_number) ? $invalid_msg_bank_account_number : '' ?> </div>
                </div> <!-- bank_account_number -->

                <div class="form-group col-md-2 flex-column"> <!-- check_number -->
                    <label for="check_number" <?= $this->floatlabel('check_number') ?> ><?= isset($Text_label_check_number) ? $Text_label_check_number : '' ?></label>
                    <input type="text" class="form-control box" id="check_number"  name="check_number" pattern="[0-9]+"
                           value="<?= $this->showvalue('check_number') ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_check_number) ? $invalid_msg_check_number : '' ?> </div>
                </div> <!-- check_number -->

                <div class="form-group col-md-3 flex-column"> <!-- transferedto -->
                    <label for="transferedto" <?= $this->floatlabel('transferedto') ?> ><?= isset($Text_label_transferedto) ? $Text_label_transferedto : '' ?></label>
                    <input type="text" class="form-control box" id="transferedto"  name="transferedto"
                           value="<?= $this->showvalue('transferedto') ?>">
                    <div class="valid-feedback"><?= isset($valid_msg) ? $valid_msg : '' ?> </div>
                    <div class="invalid-feedback"><?= isset($invalid_msg_transferedto) ? $invalid_msg_transferedto : '' ?> </div>
                </div> <!-- transferedto -->


            </div>

            </div>

            <hr>

            <button type="submit" class="btn btn-light save" name="submit"
                    id="submit"><?= isset($Text_add_new) ? $Text_add_new : '' ?></button>
        </form>
    </div>
</fieldset>