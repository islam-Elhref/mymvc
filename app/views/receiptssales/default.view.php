<table id="mytable" class="table table-striped table-bordered" style="width:100%">

    <thead>
    <tr>
        <th><?= isset($text_table_receipt_id) ? $text_table_receipt_id : '' ?></th>
        <th><?= isset($text_table_bill_id) ? $text_table_bill_id : '' ?></th>
        <th><?= isset($text_table_bill_price) ? $text_table_bill_price : '' ?></th>
        <th><?= isset($text_table_receipt_price) ? $text_table_receipt_price : '' ?></th>
        <th><?= isset($text_table_reciept_type) ? $text_table_reciept_type : '' ?></th>
        <th><?= isset($text_table_user_id) ? $text_table_user_id : '' ?></th>
        <th><?= isset($text_table_created) ? $text_table_created : '' ?></th>
        <th><?= isset($text_table_control) ? $text_table_control : '' ?></th>
    </tr>
    </thead>
    <tbody style="vertical-align: middle ;">
    <?php if (isset($receiptssales) && !empty($receiptssales)) {
        foreach ($receiptssales as $receiptssale) {
            ?>
            <tr id="<?= $receiptssale->getReceiptId() ?>">
                <td class="use_title"><?= $receiptssale->getReceiptId() ?></td>
                <td ><a href="/sales#<?= $receiptssale->getbill_id() ?>"><?= $receiptssale->getbill_id() ?></a></td>
                <td class="finalorderprice" ><?= $receiptssale->finalorderprice ?></td>
                <td class="receipt_price"><?= $receiptssale->getreceipt_price() ?></td>
                <td ><?= $receiptssale->getreciept_type() ?></td>
                <td ><?= $receiptssale->username ?></td>
                <td ><?= $receiptssale->getdate_of_receipt() ?></td>


                <td style="text-align: center">
                    &nbsp;
                    <a class="btn btn-outline-danger btn-sm delete"
                       title="<?= isset($text_delete_title) ? $text_delete_title : '' ?>"
                       href="\receiptssales\delete\<?= $receiptssale->getReceiptId() ?>">
                        <i class="fa fa-times"></i> <?= isset($Text_delete) ? $Text_delete : '' ?>
                    </a>

                </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>

</table>

<a  class="btn btn-light btn_add" href="/receiptssales/add"><?= isset($text_add_new_user) ? $text_add_new_user : '' ?></a>
