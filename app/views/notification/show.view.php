<div class="container-fluid show ">

    <h1 class="text-logo"><?= isset($h1FirstName) ? $h1FirstName : '' ?>
        <span> <?= isset($h1SecondName) ? $h1SecondName : '' ?></span></h1>
    <hr>
    <h1 class="font-weight-bolder title text-center m-4"> <?= ${'title_' . $notification->getType()} ?> </h1>

            <h3><?= $old_info ?></h3>
     <table id="mytable" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
            <?php if (isset($object) && !empty($object)) {
            foreach ($object as  $key => $value) { if ( $value == '' ) continue; ?>
                <td><?= $key ?></td>
                <?php
                }
                }
                ?>
            </tr>
            </thead>

            <tbody style="vertical-align: middle ;">
            <tr>
            <?php if (isset($object) && !empty($object)) {
            foreach ($object as  $key => $value) { if ( $value == '' ) continue;
            ?>
                <td> <?= $value ?> </td>
                <?php
                }
                }
                ?>
            </tr>
            </tbody>

        </table>

</div>