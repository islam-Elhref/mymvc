<table id="mytable" class="table table-striped table-bordered" style="width:100%">

    <thead>
    <tr>
        <th><?= isset($text_table_product_name) ? $text_table_product_name : '' ?></th>
        <th><?= isset($text_table_category_name) ? $text_table_category_name : '' ?></th>
        <th><?= isset($text_table_BuyPrice) ? $text_table_BuyPrice : '' ?></th>
        <th><?= isset($text_table_SellPrice) ? $text_table_SellPrice : '' ?></th>
        <th><?= isset($text_table_quantity) ? $text_table_quantity : '' ?></th>
        <th><?= isset($text_table_unit) ? $text_table_unit : '' ?></th>
        <th><?= isset($text_table_control) ? $text_table_control : '' ?></th>
    </tr>
    </thead>
    <tbody style="vertical-align: middle ;">
    <?php if (isset($products) && !empty($products)) {
        foreach ($products as $product) {
            ?>
            <tr>
                <td class="use_title"><?= $product->getproduct_name() ?></td>
                <td ><?= $product->getCategoryName() ?></td>
                <td ><?= $product->getBuyPrice() ?></td>
                <td ><?= $product->getSellPrice() ?></td>
                <td ><?= $product->count ?></td>
                <td ><?= isset(${'msg_unit_'.$product->getunit()}) ? ${'msg_unit_'.$product->getunit()} : ''?></td>




                <td style="text-align: center">
                    <a class="btn btn-outline-light btn-sm" href="\products\edit\<?= $product->getproduct_id() ?>"> <i
                                class="fa fa-edit"></i> <?= isset($Text_edit) ? $Text_edit : '' ?></a>
                    &nbsp;
                    <a class="btn btn-outline-danger btn-sm delete"
                       title="<?= isset($text_delete_title) ? $text_delete_title : '' ?>"
                       href="\products\delete\<?= $product->getproduct_id() ?>">
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

<a class="btn btn-light btn_add" href="/products/add"><?= isset($text_add_new_user) ? $text_add_new_user : '' ?></a>
