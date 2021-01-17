<h1 class="font-weight-bolder title"> <?= isset($Text_header) ? "$Text_header" : '' ?> </h1>


<?php
$this->GetMessage();
?>

<table id="mytable" class="table table-striped table-bordered" style="width:100%">

    <thead>
    <tr>
        <th><?= isset($text_table_username) ? $text_table_username : '' ?></th>
        <th><?= isset($text_table_control) ? $text_table_control : '' ?></th>
    </tr>
    </thead>
    <tbody style="vertical-align: middle ;">
    <?php if (isset($usersgroups) && !empty($usersgroups)) {
        foreach ($usersgroups as $usergroup) {
            ?>
            <tr>
                <td><?= $usergroup->getGroupName() ?></td>
                <!-- control edit and delete  -->
                <td style="text-align: center">
                    <a class="btn btn-outline-light btn-sm" href="\usersgroups\edit\<?= $usergroup->getGroupId() ?>"> <i
                                class="fa fa-user-edit"></i> <?= isset($Text_edit) ? $Text_edit : '' ?>
                    </a>
                    &nbsp;
                    <a class="btn btn-outline-danger btn-sm delete"
                       href="\usersgroups\delete\<?= $usergroup->getGroupId() ?>">
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

<a class="btn btn-light btn_add" href="/usersgroups/add"><?= isset($text_add_new_user) ? $text_add_new_user : '' ?></a>
