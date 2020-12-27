<div class="navbar">

    <div class="navbar-info">
        <img src="../img/1.jpg" alt="">
        <h3>app admin</h3>
    </div>
    <div class="links">
        <a href="/" data-toggle="tooltip" data-placement="left" title="<?= isset($Text_home) ? $Text_home : '' ?>" >
            <i class="fa fa-chart-line fa-fw"></i>
            <span><?= isset($Text_home) ? $Text_home : '' ?> </span>
        </a>
        <a href="/transactions" data-toggle="tooltip" data-placement="left" title="<?= isset($Text_transactions) ? $Text_transactions : '' ?>" >
            <i class="fas fa-exchange-alt fa-fw"></i>
            <span> <?= isset($Text_transactions) ? $Text_transactions : '' ?> </span>
        </a>
        <a href="/expenses" data-toggle="tooltip" data-placement="left" title="<?= isset($Text_expenses) ? $Text_expenses : '' ?>" >
            <i class="fas fa-money-check-alt fa-fw"></i>
            <span> <?= isset($Text_expenses) ? $Text_expenses : '' ?> </span>
        </a>
        <a href="/store" data-toggle="tooltip" data-placement="left" title="<?= isset($Text_store) ? $Text_store : '' ?>"  >
            <i class="fa fa-store fa-fw"></i>
            <span> <?= isset($Text_store) ? $Text_store : '' ?> </span>
        </a>
        <a href="/users" data-toggle="tooltip" data-placement="left" title="<?= isset($Text_users) ? $Text_users : '' ?>" >
            <i class="fas fa-users fa-fw"></i>
            <span> <?= isset($Text_users) ? $Text_users : '' ?> </span>
        </a>
        <a href="/clients" data-toggle="tooltip" data-placement="left" title="<?= isset($Text_clients) ? $Text_clients : '' ?>" >
            <i class="fa fa-address-card fa-fw"></i>
            <span> <?= isset($Text_clients) ? $Text_clients : '' ?> </span>
        </a>
        <a href="/suppliers" data-toggle="tooltip" data-placement="left"  title="<?= isset($Text_suppliers) ? $Text_suppliers : '' ?>" >
            <i class="fas fa-user-friends fa-fw"></i>
            <span> <?= isset($Text_suppliers) ? $Text_suppliers : '' ?> </span>
        </a>
        <a href="/reports" data-toggle="tooltip" data-placement="left" title="<?= isset($Text_reports) ? $Text_reports : '' ?>" >
            <i class="fas fa-book fa-fw fa-fw"></i>
            <span> <?= isset($Text_reports) ? $Text_reports : '' ?> </span>
        </a>
        <a href="/language" data-toggle="tooltip" data-placement="left" title="<?= isset($Text_changeLanguage) ? $Text_changeLanguage : '' ?>" >
            <i class="fas fa-language fa-fw"></i>
            <span> <?= isset($Text_changeLanguage) ? $Text_changeLanguage : '' ?> </span>
        </a>
    </div>
</div>