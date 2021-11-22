<div class="navbar">

    <div class="navbar-info">
        <img src="<?=   $this->getuser()->getProfile()->getImage() ?>" alt="">
        <h3><?= $this->getuser()->getProfile()->getMixName() ?></h3>
        <p><?= $this->getuser()->getGroupName() ?></p>
    </div>
    <ul class="list-unstyled links">

        <li class="parent_link <?= $this->checkurl('/')== true ? 'active' : '' ?>" > <!-- dashboard ling -->
            <a href="/"  title="<?= isset($Text_home) ? $Text_home : '' ?>" data-toggletool="tooltip" data-placement="right">
                <i class="fa fa-chart-line "></i>
                <span><?= isset($Text_home) ? $Text_home : '' ?> </span>
            </a>
        </li> <!-- dashboard link -->

        <li class="parent_link"  > <!-- transactions link parent -->
            <a href="#transactions" data-toggletool="tooltip" data-placement="right" title="<?= isset($Text_transactions) ? $Text_transactions : '' ?>">
                <i class="fas fa-exchange-alt "></i>
                <span> <?= isset($Text_transactions) ? $Text_transactions : '' ?> </span>
            </a>
            <ul class="list-unstyled submenu" id="transactions"> <!-- transactions submenu  -->
                <li class="<?= $this->checkurl('/purchases')== true ? 'subactive' : '' ?>">
                    <a href="/purchases" title="<?= isset($Text_transactions_purchases) ? $Text_transactions_purchases : '' ?>" data-toggletool="tooltip" data-placement="right">
                        <i class="fas fa-cart-arrow-down fa-fw"></i>
                        <span> <?= isset($Text_transactions_purchases) ? $Text_transactions_purchases : '' ?> </span>
                    </a>
                </li>
                <li class="<?= $this->checkurl('/sales')== true ? 'subactive' : '' ?>">
                    <a href="/sales" title="<?= isset($Text_sales) ? $Text_sales : 'المبيعات' ?>" data-toggletool="tooltip" data-placement="right">
                        <i class="fa  fa-money-bill"></i>
                        <span> <?= isset($Text_sales) ? $Text_sales : 'المبيعات' ?> </span>
                    </a>
                </li>
            </ul>

        </li> <!-- transactions link parent -->

        <li class="parent_link" > <!-- expenses link parent -->
            <a href="#expenses" title="<?= isset($Text_Receipts) ? $Text_Receipts : '' ?>" data-toggletool="tooltip" data-placement="right"  >
                <i class="fas fa-money-check-alt "></i>
                <span> <?= isset($Text_Receipts) ? $Text_Receipts : '' ?> </span>
            </a>

            <ul class="list-unstyled  submenu" id="receiptspurchases"> <!-- expenses submenu  -->
                <li class="<?= $this->checkurl('/receiptspurchases')== true ? 'subactive' : '' ?>">
                    <a href="/receiptspurchases" title="<?= isset($Text_Receipts_purchases) ? $Text_Receipts_purchases : '' ?>" data-toggletool="tooltip" data-placement="right"  >
                        <i class="fa  fa-money-bill"></i>
                        <span> <?= isset($Text_Receipts_purchases) ? $Text_Receipts_purchases : '' ?> </span>
                    </a>
                </li>
                <li class="<?= $this->checkurl('/receiptssales')== true ? 'subactive' : '' ?>">
                    <a href="/receiptssales"  title="<?= isset($Text_Receipts_sales) ? $Text_Receipts_sales : '' ?>" data-toggletool="tooltip" data-placement="right" >
                        <i class="fas fa-cart-arrow-down "></i>
                        <span> <?= isset($Text_Receipts_sales) ? $Text_Receipts_sales : '' ?> </span>
                    </a>
                </li>
            </ul>

        </li> <!-- expenses link parent end -->


        <li class="parent_link" > <!-- store link parent -->
            <a href="#store" title="<?= isset($Text_store) ? $Text_store : '' ?>" data-toggletool="tooltip" data-placement="right">
                <i class="fa fa-store fa-fw"></i>
                <span> <?= isset($Text_store) ? $Text_store : '' ?> </span>
            </a>

            <ul class="list-unstyled  submenu" id="store"> <!-- expenses submenu  -->

                <li class="<?= $this->checkurl('/productscategory')== true ? 'subactive' : '' ?>">
                    <a href="/productscategory" title="<?= isset($Text_product_categories) ? $Text_product_categories : '' ?>"  data-toggletool="tooltip" data-placement="right">
                        <i class="fa  fa-money-bill"></i>
                        <span> <?= isset($Text_product_categories) ? $Text_product_categories : '' ?> </span>
                    </a>
                </li>
                <li class="<?= $this->checkurl('/products')== true ? 'subactive' : '' ?>">
                    <a href="/products"  title="<?= isset($Text_products) ? $Text_products : '' ?>"  data-toggletool="tooltip" data-placement="right">
                        <i class="fas fa-cart-arrow-down fa-fw"></i>
                        <span> <?= isset($Text_products) ? $Text_products : '' ?> </span>
                    </a>
                </li>

            </ul>

        </li> <!-- store link parent end -->


        <li class="parent_link" >
            <a href="#users" title="<?= isset($Text_users) ? $Text_users : '' ?>" data-toggletool="tooltip" data-placement="right">
                <i class="fas fa-user fa-fw"></i>
                <span> <?= isset($Text_users) ? $Text_users : '' ?> </span>
            </a>
            <ul class="list-unstyled  submenu" id="users"> <!-- expenses submenu  -->

                <li class="<?= $this->checkurl('/users')== true ? 'subactive' : '' ?>"  >
                    <a href="/users"  title="<?= isset($Text_users_list) ? $Text_users_list : '' ?>" data-toggletool="tooltip" data-placement="right" >
                        <i class="fas fa-user-circle fa-fw"></i>
                        <span> <?= isset($Text_users_list) ? $Text_users_list : '' ?> </span>
                    </a>
                </li>
                <li class="<?= $this->checkurl('/usersgroups')== true ? 'subactive' : '' ?>">
                    <a href="/usersgroups"  title="<?= isset($text_users_group) ? $text_users_group : '' ?>" data-toggletool="tooltip" data-placement="right">
                        <i class="fas fa-users fa-fw"></i>
                        <span> <?= isset($text_users_group) ? $text_users_group : '' ?> </span>
                    </a>
                </li>
                <li class="<?= $this->checkurl('/privileges')== true ? 'subactive' : '' ?>">
                    <a href="/privileges" title="<?= isset($text_users_privilege) ? $text_users_privilege : '' ?>" data-toggletool="tooltip" data-placement="right">
                        <i class="fas fa-key fa-fw"></i>
                        <span> <?= isset($text_users_privilege) ? $text_users_privilege : '' ?> </span>
                    </a>
                </li>

            </ul>
        </li>

        <li class="parent_link <?= $this->checkurl('/clients')== true ? 'active' : '' ?>" >
            <a href="/clients" title="<?= isset($Text_clients) ? $Text_clients : '' ?>" data-toggletool="tooltip" data-placement="right">
                <i class="fa fa-address-card fa-fw"></i>
                <span> <?= isset($Text_clients) ? $Text_clients : '' ?> </span>
            </a>
        </li>

        <li class="parent_link <?= $this->checkurl('/suppliers')== true ? 'active' : '' ?>" >
            <a href="/suppliers" title="<?= isset($Text_suppliers) ? $Text_suppliers : '' ?>" data-toggletool="tooltip" data-placement="right" >
                <i class="fas fa-user-friends fa-fw"></i>
                <span> <?= isset($Text_suppliers) ? $Text_suppliers : '' ?> </span>
            </a>
        </li>

        <li class="parent_link <?= $this->checkurl('/reports')== true ? 'active' : '' ?> " >
            <a href="/notification" title="<?= isset($Text_reports) ? $Text_reports : '' ?>" data-toggletool="tooltip" data-placement="right">
                <i class="fas fa-book fa-fw fa-fw"></i>
                <span> <?= isset($Text_reports) ? $Text_reports : '' ?> </span>
            </a>
        </li>

        <li class="parent_link" >
            <a href="/language" title="<?= isset($Text_changeLanguage) ? $Text_changeLanguage : '' ?>" data-toggletool="tooltip" data-placement="right">
                <i class="fas fa-language fa-fw"></i>
                <span> <?= isset($Text_changeLanguage) ? $Text_changeLanguage : '' ?> </span>
            </a>
        </li>
    </ul>
</div>