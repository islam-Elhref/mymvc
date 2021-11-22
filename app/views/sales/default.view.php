<table id="mytable" class="table table-striped table-bordered" style="width:100%">

    <thead>
    <tr>
        <th><?= isset($text_table_bill_id) ? $text_table_bill_id : '' ?></th>
        <th><?= isset($text_table_client_id) ? $text_table_client_id : '' ?></th>
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
    <?php if (isset($sales) && !empty($sales)) {
        foreach ($sales as $sale) {
            ?>
            <tr id="<?= $sale->getbill_id() ?>">
                <td class="use_title"><?= $sale->getbill_id() ?></td>
                <td ><?= $sale->getclientname() ?></td>
                <td ><?= $sale->getcountproduct() ?></td>
                <td ><?= $sale->getfinalorderprice() ?></td>
                <td ><?= ${'Text_payment_type_' . $sale->getpayment_type()} ?></td>
                <td ><?= $sale->getcreated() ?></td>
                <td ><?= $sale->username ?></td>
                <td class="statue_<?= $sale->getpayment_status() ?>" ><?= ${'Text_payment_status_' . $sale->getpayment_status()} ?></td>


                <td style="text-align: center">
                    <a class="btn btn-outline-light btn-sm" href="\sales\edit\<?= $sale->getbill_id() ?>"> <i
                                class="fa fa-edit"></i> <?= isset($Text_edit) ? $Text_edit : '' ?></a>
                    &nbsp;
                    <a class="btn btn-outline-danger btn-sm delete"
                       title="<?= isset($text_delete_title) ? $text_delete_title : '' ?>"
                       href="\sales\delete\<?= $sale->getbill_id() ?>">
                        <i class="fa fa-times"></i> <?= isset($Text_delete) ? $Text_delete : '' ?>
                    </a>

                    <a class="btn btn-outline-success btn-sm delete"
                       title="<?= isset($text_print_title) ? $text_print_title : '' ?>"
                       href="\sales\print\<?= $sale->getbill_id() ?>">
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

<a  class="btn btn-light btn_add" href="/sales/add"><?= isset($text_add_new_user) ? $text_add_new_user : '' ?></a>
