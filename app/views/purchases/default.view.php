<table id="mytable" class="table table-striped table-bordered" style="width:100%">

    <thead>
    <tr>
        <th><?= isset($text_table_bill_id) ? $text_table_bill_id : '' ?></th>
        <th><?= isset($text_table_supplier_id) ? $text_table_supplier_id : '' ?></th>
        <th><?= isset($text_table_count_product) ? $text_table_count_product : '' ?></th>
        <th><?= isset($text_table_bill_price) ? $text_table_bill_price : '' ?></th>
        <th><?= isset($text_table_payment_type) ? $text_table_payment_type : '' ?></th>
        <th><?= isset($text_table_created) ? $text_table_created : '' ?></th>
        <th><?= isset($text_table_user_id) ? $text_table_user_id : '' ?></th>
        <th><?= isset($text_table_payment_status) ? $text_table_payment_status : '' ?></th>
        <th><?= isset($text_table_control) ? $text_table_control : '' ?></th>
    </tr>
    </thead>
    <tbody style="vertical-align: middle ;">
    <?php if (isset($purchases) && !empty($purchases)) {
        foreach ($purchases as $purchase) {
            ?>
            <tr id="<?= $purchase->getbill_id() ?>">
                <td class="use_title"><?= $purchase->getbill_id() ?></td>
                <td ><?= $purchase->getsuppliername() ?></td>
                <td ><?= $purchase->getcountproduct() ?></td>
                <td ><?= $purchase->getfinalorderprice() ?></td>
                <td ><?= ${'Text_payment_type_' . $purchase->getpayment_type()} ?></td>
                <td ><?= $purchase->getcreated() ?></td>
                <td ><?= $purchase->username ?></td>
                <td class="statue_<?= $purchase->getpayment_status() ?>"><?= ${'Text_payment_status_' . $purchase->getpayment_status()} ?></td>


                <td style="text-align: center">
                    <a class="btn btn-outline-light btn-sm" href="\purchases\edit\<?= $purchase->getbill_id() ?>"> <i
                                class="fa fa-edit"></i> <?= isset($Text_edit) ? $Text_edit : '' ?></a>
                    &nbsp;
                    <a class="btn btn-outline-danger btn-sm delete"
                       title="<?= isset($text_delete_title) ? $text_delete_title : '' ?>"
                       href="\purchases\delete\<?= $purchase->getbill_id() ?>">
                        <i class="fa fa-times"></i> <?= isset($Text_delete) ? $Text_delete : '' ?>
                    </a>

                    <a class="btn btn-outline-success btn-sm delete"
                       title="<?= isset($text_print_title) ? $text_print_title : '' ?>"
                       href="\purchases\print\<?= $purchase->getbill_id() ?>" >
                        <i class="fa fa-print"></i> <?= isset($Text_print) ? $Text_print : '' ?>
                    </a>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>

</table>

<a  class="btn btn-light btn_add" href="/purchases/add"><?= isset($text_add_new_user) ? $text_add_new_user : '' ?></a>
