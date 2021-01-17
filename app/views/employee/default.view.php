<h1 class="font-weight-bolder text-center title"> <?= isset($Text_title) ? $Text_title : '' ?> </h1>
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
            <th><?= isset($Text_id) ? $Text_id : '' ?></th>
            <th><?= isset($Text_name) ? $Text_name : '' ?></th>
            <th><?= isset($Text_age) ? $Text_age : '' ?></th>
            <th><?= isset($Text_address) ? $Text_address : '' ?></th>
            <th><?= isset($Text_salary) ? $Text_salary : '' ?></th>
            <th><?= isset($Text_control) ? $Text_control : '' ?></th>
        </tr>
    </thead>

    <tbody style="vertical-align: middle">
    <?php if (isset($employees) && !empty($employees)) {
        foreach ($employees as $employee) {
            ?>
            <tr>
                <td><?= $employee->getId() ?></td>
                <td><?= $employee->getName() ?></td>
                <td><?= $employee->getAge() ?></td>
                <td><?= $employee->getAddress() ?></td>
                <td><?= $employee->getSalary() ?></td>
                <td style="text-align: center">
                    <a class="btn btn-outline-light btn-sm" href="\employee\edit\<?= $employee->getId() ?>"> <i
                                class="fa fa-user-edit"></i> <?= isset($Text_edit) ? $Text_edit : '' ?></a>
                    &nbsp;
                    <a class="btn btn-outline-danger btn-sm delete" href="\employee\delete\<?= $employee->getId() ?>">
                        <i class="fa fa-user-times"></i> <?= isset($Text_delete) ? $Text_delete : '' ?></a>
                </td>
            </tr>
            <?php
        }
    }
    ?>

    </tbody>

</table>



<a class="btn btn-light" href="/employee/add"><?= isset($Text_add_new_employee) ? $Text_add_new_employee : '' ?></a>

