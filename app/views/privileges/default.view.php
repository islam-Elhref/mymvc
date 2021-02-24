<h1 class="font-weight-bolder title"> <?= isset($Text_header) ? "$Text_header" : '' ?> </h1>

<?php
$this->GetMessage();
?>

<table id="mytable" class="table table-striped table-bordered" style="width:100%">

    <thead>
    <tr>
        <th><?= isset($text_table_privilege_name) ? $text_table_privilege_name : '' ?></th>
        <th><?= isset($text_table_privilege_url) ? $text_table_privilege_url : '' ?></th>
        <th><?= isset($text_table_control) ? $text_table_control : '' ?></th>
    </tr>
    </thead>

    <tbody style="vertical-align: middle ;">
    <?php if (isset($privileges) && !empty($privileges)) {
        foreach ($privileges as $privilege) {
            ?>
            <tr>
                <td class="use_title"><?= $privilege->getPrivilegeName() ?></td>
                <td><?= $privilege->getPrivilegeurl() ?></td>
                <!-- control edit and delete  -->
                <td style="text-align: center">
                    <a class="btn btn-outline-light btn-sm" href="\privileges\edit\<?= $privilege->getPrivilegeId() ?>"> <i
                                class="fa fa-user-edit"></i> <?= isset($Text_edit) ? $Text_edit : '' ?>
                    </a>
                    &nbsp;
                    <a class="btn btn-outline-danger btn-sm delete" title="<?= isset($text_delete_title) ? $text_delete_title : '' ?>"
                       href="\privileges\delete\<?= $privilege->getPrivilegeId() ?>">
                        <i class="fa fa-user-times"></i> <?= isset($Text_delete) ? $Text_delete : '' ?>
                    </a>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>

</table>

<a class="btn btn-light btn_add" href="/privileges/add"><?= isset($text_add_new) ? $text_add_new : '' ?></a>
