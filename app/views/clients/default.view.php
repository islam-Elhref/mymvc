<table id="mytable" class="table table-striped table-bordered" style="width:100%">

    <thead>
    <tr>
        <th><?= isset($text_table_name) ? $text_table_name : '' ?></th>
        <th><?= isset($text_table_email) ? $text_table_email : '' ?></th>
        <th><?= isset($text_table_phone) ? $text_table_phone : '' ?></th>
        <th><?= isset($text_table_address) ? $text_table_address : '' ?></th>
        <th><?= isset($text_table_control) ? $text_table_control : '' ?></th>
    </tr>
    </thead>
    <tbody style="vertical-align: middle ;">
    <?php if (isset($clients) && !empty($clients)) {
        foreach ($clients as $client) {
            ?>
            <tr>
                <td class="use_title"><?= $client->getName() ?></td>
                <td><?= $client->getEmail() ?></td>
                <td><?= $client->getPhone() ?></td>
                <td><?= $client->getAddress() ?></td>
                <td style="text-align: center">
                    <a class="btn btn-outline-light btn-sm" href="\clients\edit\<?= $client->getclientsId() ?>"> <i
                                class="fa fa-edit"></i> <?= isset($Text_edit) ? $Text_edit : '' ?></a>
                    &nbsp;
                    <a class="btn btn-outline-danger btn-sm delete"
                       title="<?= isset($text_delete_title) ? $text_delete_title : '' ?>"
                       href="\clients\delete\<?= $client->getclientsId() ?>">
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

<a class="btn btn-light btn_add" href="/clients/add"><?= isset($text_add_new_user) ? $text_add_new_user : '' ?></a>
