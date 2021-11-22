<div class="row">

    <!-- Tasks Card users -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <a href="/users" class="link_no_style">
                            <div class="text-sm font-weight-bold text-success text-uppercase mb-1"><?= $text_users ?></div>
                        </a>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $index->count_users ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Card clients -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <a href="/clients" class="link_no_style">
                            <div class="text-sm font-weight-bold text-dark text-uppercase mb-1"><?= $text_clients ?></div>
                        </a>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $index->count_clients ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Card suppliers -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <a href="/suppliers" class="link_no_style">
                            <div class="text-sm font-weight-bold text-info text-uppercase mb-1"><?= $text_suppliers ?></div>
                        </a>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $index->count_suppliers ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- product -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <a href="/products" class="link_no_style">
                            <div class="text-sm font-weight-bold text-dark text-uppercase mb-1"> <?= $text_product ?> </div>
                        </a>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $index->count_product ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-store fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  purchases_bills -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <a href="/purchases" class="link_no_style">
                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1"><?= $text_purchases_bills ?></div>
                        </a>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $purchases->count_purchases_bills ?></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $purchases->price_purchases_bills ?>
                            <i class="fa fa-pound-sign"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cart-arrow-down fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  purchases_receipt -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <a href="/receiptspurchases" class="link_no_style">
                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1"><?= $text_purchases_receipt ?></div>
                        </a>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $purchases_receipt->count_purchases_receipt ?></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $purchases_receipt->price_purchases_receipt ?>
                            <i class="fa fa-pound-sign"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-money-bill fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- sales_bills -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <a href="/sales" class="link_no_style">
                            <div class="text-sm font-weight-bold text-success text-uppercase mb-1"><?= $text_sales_bills ?></div>
                        </a>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sales->count_sales_bills ?></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $sales->price_sales_bills ?>
                            <i class="fa fa-pound-sign"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cart-plus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- sales_receipt -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <a href="/receiptssales" class="link_no_style">
                            <div class="text-sm font-weight-bold text-success text-uppercase mb-1"><?= $text_sales_receipt ?></div>
                        </a>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sales_receipt->count_sales_receipt ?></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $sales_receipt->price_sales_receipt ?>
                            <i class="fa fa-pound-sign"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row col-xl-12 col-md-12 mb-12 text-center">
        <hr class="col-12">
        <div class="col-2"><a href="/users/add"><?= $text_users_add ?></a> </div>
        <div class="col-2"><a href="/clients/add"><?= $text_clients_add ?></a> </div>
        <div class="col-2"><a href="/suppliers/add"><?= $text_suppliers_add ?></a> </div>
        <div class="col-2"><a href="/products/add"><?= $text_products_add ?></a> </div>
        <div class="col-2"><a href="/productscategory/add"><?= $text_productscategory_add ?></a> </div>
        <div class="col-2"><a href="/privileges/add"><?= $text_privileges_add ?></a> </div>
        <div class="col-2"><a href="/usersgroups/add"><?= $text_usersgroups_add ?></a> </div>
        <div class="col-2"><a href="/receiptspurchases/add"><?= $text_receiptspurchases_add ?></a> </div>
        <div class="col-2"><a href="/receiptssales/add"><?= $text_receiptssales_add ?></a> </div>
        <div class="col-2"><a href="/purchases/add"><?= $text_purchases_add ?></a> </div>
        <div class="col-2"><a href="/sales/add"><?= $text_sales_add ?></a> </div>
    </div>

</div>


<!-- Footer -->
<hr>
<footer class="text-center">
    <div class="mb-2">
        <small>
            © 2021 made with <i class="fa fa-heart" style="color:red"></i> by - <a target="_blank"
                                                                                   href="https://www.facebook.com/profile.php?id=100060866798336">
                Islam Ali
            </a>
        </small>
        <a href="https://twitter.com/ealhref" target="_blank">
            <i class="fab fa-twitter fa-lg"></i>
        </a>
        <a href="https://www.facebook.com/profile.php?id=100060866798336" target="_blank">
            <i class="fab fa-facebook-f fa-lg"></i>
        </a>
    </div>
</footer>
<!-- End of Footer -->