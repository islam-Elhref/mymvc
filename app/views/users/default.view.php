<h1 class="font-weight-bolder title"> <?= isset($Text_header) ? "$Text_header" : '' ?> </h1>


<?php
if (isset($_SESSION['message'])) {
    if (!isset($_SESSION['error'])) {
        ?>

        <div class="alert alert-success" id="message"><?= $_SESSION['message'] ?></div>

        <?php
    } else { ?>
        <div class="alert alert-danger" id="message"><?= $_SESSION['message'] ?></div>
        <?php
    }
    unset($_SESSION['message'], $_SESSION['error']);
}
?>

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
    ?>
            <tr>
                <td><?= $user->getUsername() ?></td>
                <td><?= $user->getGroupId() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><?= $user->getPhone() ?></td>
                <td><?= $user->getSubscriptionDate() ?></td>
                <td><?= $user->getLastLogin() ?></td>
                <td style="text-align: center">
                    <a class="btn btn-outline-light btn-sm" href="\employee\edit\<?= $user->getUserId() ?>"> <i
                                class="fa fa-user-edit"></i> <?= isset($Text_edit) ? $Text_edit : '' ?></a>
                    &nbsp;
                    <a class="btn btn-outline-danger btn-sm delete" href="\employee\delete\<?= $user->getUserId() ?>">
                        <i class="fa fa-user-times"></i> <?= isset($Text_delete) ? $Text_delete : '' ?></a>
                </td>
            </tr>
    <?php
        }
    }
    ?>
    </tbody>

</table>

<a class="btn btn-light btn_add" href="/employee/add"><?= isset($text_add_new_user) ? $text_add_new_user : '' ?></a>
