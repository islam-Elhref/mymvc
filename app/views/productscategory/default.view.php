<table id="mytable" class="table table-striped table-bordered" style="width:100%">

    <thead>
    <tr>
        <th><?= isset($text_table_category_name) ? $text_table_category_name : '' ?></th>
        <th><?= isset($text_table_control) ? $text_table_control : '' ?></th>
    </tr>
    </thead>
    <tbody style="vertical-align: middle ;">
    <?php if (isset($categories) && !empty($categories)) {
        foreach ($categories as $category) {
            ?>
            <tr>
                <td class="use_title"><?= $category->getcategory_name() ?></td>
                <td style="text-align: center">
                    <a class="btn btn-outline-light btn-sm" href="\productscategory\edit\<?= $category->getcategory_id() ?>"> <i
                                class="fa fa-edit"></i> <?= isset($Text_edit) ? $Text_edit : '' ?></a>
                    &nbsp;
                    <a class="btn btn-outline-danger btn-sm delete"
                       title="<?= isset($text_delete_title) ? $text_delete_title : '' ?>"
                       href="\productscategory\delete\<?= $category->getcategory_id() ?>">
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

<a class="btn btn-light btn_add" href="/productscategory/add"><?= isset($text_add_new_user) ? $text_add_new_user : '' ?></a>
