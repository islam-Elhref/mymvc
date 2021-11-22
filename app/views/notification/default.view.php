

<table id="mytable" class="table table-striped table-bordered" style="width:100%">

    <thead>
    <tr>
        <th><?= isset($text_table_notification_id) ? $text_table_notification_id : '' ?></th>
        <th><?= isset($text_table_title) ? $text_table_title : '' ?></th>
        <th><?= isset($text_table_content) ? $text_table_content : '' ?></th>
        <th><?= isset($text_table_type) ? $text_table_type : '' ?></th>
        <th><?= isset($text_table_created) ? $text_table_created : '' ?></th>
        <th><?= isset($text_table_user_id) ? $text_table_user_id : '' ?></th>
        <th><?= isset($text_table_opject) ? $text_table_opject : '' ?></th>
    </tr>
    </thead>
    <tbody style="vertical-align: middle ;">
    <?php if (isset($notifications) && !empty($notifications)) {
        foreach ($notifications as $notification) {
            ?>
            <tr>
                <td class="use_title"><?= $notification->getNotificationId() ?></td>
                <td><?= ${$notification->getTitle()} ?></td>
                <td><a href="<?= $notification->getUrl() ?>"><?= $notification->showcontent(${$notification->getContent()}) ?></a></td>
                <td><?= ${'notif_type_'.$notification->getType()} ?></td>
                <td><?= $notification->getCreated() ?></td>
                <?php

                if($this->getuser()->getUserId() == $notification->getUserId() ){
                    ?>
                    <td> <?= $notif_by_me ?> </td>
                    <?php
                }else{
                ?>
                <td><a href="/users/edit/<?= $notification->getUserId() ?>"><?= $notification->username ?></a></td>
                    <?php
                }?>
                <td style="text-align: center">
                    <?php if ($notification->getType() == 2 || $notification->getType() == 1 ){ ?>
                        <a class="btn btn-outline-danger btn-sm"
                           href="\notification\show\<?= $notification->getNotificationId() ?>">
                            <i class="fa fa-search"></i> <?= isset($Text_show) ? $Text_show : '' ?>
                        </a>
                <?php }else{ echo  $notif_in_delete_only ; } ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>

</table>