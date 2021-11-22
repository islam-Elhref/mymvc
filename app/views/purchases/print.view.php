<div class="container-fluid print ">

    <h1 class="text-logo"><?= isset($h1FirstName) ? $h1FirstName : '' ?>
        <span> <?= isset($h1SecondName) ? $h1SecondName : '' ?></span></h1>
    <hr>
    <h1 class="font-weight-bolder title text-center m-4"> <?= isset($Text_header) ? "$Text_header" : '' ?> </h1>


    <div class="row">
        <div class="col-6">
            <h4 class="text-center font-weight-bolder"><?= $info_bill ?></h4>
            <h5><?= sprintf("%s : %s", $text_table_bill_id, $purchase->getbill_id()) ?> </h5>
            <h5><?= sprintf("%s : %s", $text_from_supplier, $purchase->getsuppliername()) ?> </h5>
            <h5><?= sprintf("%s : %s", $text_table_user_id, $purchase->username) ?> </h5>
            <h5><?= sprintf("%s : %s", $text_table_payment_type, ${'Text_payment_type_' . $purchase->getpayment_type()}) ?> </h5>
            <h5><?= sprintf("%s : %s", $text_table_created, $purchase->getcreated()) ?> </h5>
            <h5><?= sprintf("%s : %s", $text_table_receiptpayprice, $purchase->receiptpayprice ) ?> </h5>
            <h5><?= sprintf("%s : %s", $text_table_last_price, ($purchase->getfinalorderprice() - $purchase->receiptpayprice) ) ?> </h5>
            <h5><?= sprintf("%s : %s", $text_table_payment_status, ${'Text_payment_status_' . $purchase->getpayment_status()}) ?> </h5>
        </div>
    </div>


    <table class="table table-striped table-bordered" style="width:100% ; margin: auto">
        <thead>
        <tr>
            <th><?= isset($text_table_product_name) ? $text_table_product_name : '' ?></th>
            <th><?= isset($text_table_category_name) ? $text_table_category_name : '' ?></th>
            <th><?= isset($text_table_quantity) ? $text_table_quantity : '' ?></th>
            <th><?= isset($text_table_BuyPrice) ? $text_table_BuyPrice : '' ?></th>
            <th><?= isset($text_table_unit) ? $text_table_unit : '' ?></th>
            <th><?= isset($text_table_order_price) ? $text_table_order_price : '' ?></th>
        </tr>
        </thead>
        <tbody style="vertical-align: middle ;">
        <?php if (isset($purchases_orders) && !empty($purchases_orders)) {
            foreach ($purchases_orders as $order) {
                ?>
                <tr>
                    <td><?= $order->product_name ?></td>
                    <td><?= $order->category_name ?></td>
                    <td><?= $order->getorder_quantity() ?></td>
                    <td><?= $order->BuyPrice ?></td>
                    <td ><?= isset(${'msg_unit_'.$order->unit}) ? ${'msg_unit_'.$order->unit} : ''?></td>
                    <td class="font-weight-bold"><?= $order->getorder_price() ?></td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>

    </table>
    <div class="row">
        <h3 class="col-6"><?= $text_table_count_product . " : " ?> <span class="font-weight-normal"> <?= $purchase->getcountproduct() ?> </span> </h3>
        <h3 class="col-6"><?= $text_table_bill_price . " : " ?> <span class="font-weight-normal "> <?= $purchase->getfinalorderprice() ?> </span> </h3>
    </div>
</div>

<script>
    window.print()
    window.onafterprint = function(){
        window.location.href = 'http://mymvc.com/purchases'
    }
</script>