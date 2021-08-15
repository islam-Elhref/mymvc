<table id="mytable" class="table table-striped table-bordered" style="width:100%">

    <thead>
    <tr>
        <th><?= isset($text_table_username) ? $text_table_username : '' ?></th>
        <th><?= isset($text_table_group) ? $text_table_group : '' ?></th>
        <th><?= isset($text_table_email) ? $text_table_email : '' ?></th>
        <th><?= isset($text_table_phone) ? $text_table_phone : '' ?></th>
        <th><?= isset($text_table_subscription_date) ? $text_table_subscription_date : '' ?></th>
        <th><?= isset($text_table_last_login) ? $text_table_last_login : '' ?></th>
        <th><?= isset($text_table_control) ? $text_table_control : '' ?></th>
    </tr>
    </thead>
    <tbody style="vertical-align: middle ;">
    <?php if (isset($users) && !empty($users)) {
        foreach ($users as $user) {
            if ($user->getStatus() == 1 || $user->getStatus() == 3) {
                $statue_text = 'dark';
                $text_permit = $Text_block;
                $text_permit_title = $text_block_title;
                $block_font = 'fa-user-lock';
            } else {
                $statue_text = 'success';
                $text_permit = $Text_unblock;
                $text_permit_title = $text_unblock_title;
                $block_font = 'fa-unlock ';
            }
            ?>
            <tr>
                <td class="use_title"><?= $user->getUsername() ?></td>
                <td><?= $user->getGroupName() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><?= $user->getPhone() ?></td>
                <td><?= $user->getSubscriptionDate() ?></td>
                <td><?= $user->getLastLogin() ?></td>
                <td style="text-align: center">
                    <a class="btn btn-outline-light btn-sm" href="\users\edit\<?= $user->getUserId() ?>"> <i
                                class="fa fa-user-edit"></i> <?= isset($Text_edit) ? $Text_edit : '' ?></a>
                    &nbsp;
                    <a class="btn btn-outline-danger btn-sm delete"
                       title="<?= isset($text_delete_title) ? $text_delete_title : '' ?>"
                       href="\users\delete\<?= $user->getUserId() ?>">
                        <i class="fa fa-user-times"></i> <?= isset($Text_delete) ? $Text_delete : '' ?></a>
                    &nbsp;
                    <a class="btn btn-outline-<?= $statue_text ?> btn-sm delete"
                       title="<?= isset($text_permit_title) ? $text_permit_title : '' ?>"
                       href="\users\permit\<?= $user->getUserId() ?>">
                        <i class="fa <?= $block_font ?>"></i> <?= isset($text_permit) ? $text_permit : '' ?></a>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>

</table>

<a class="btn btn-light btn_add" href="/users/add"><?= isset($text_add_new_user) ? $text_add_new_user : '' ?></a>
