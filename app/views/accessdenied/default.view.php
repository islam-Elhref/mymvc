<div class="text-center">

    <h1 class="text-lg-center text-danger text-capitalize text_error">404</h1>
    <a href="/" class="text-capitalize text-light text-decoration-none">
        <h2>
            <?php if (isset($Text_access_denied)) {
                echo $Text_access_denied;
            } else {
                echo '';
            } ?>
        </h2>
    </a>

</div>

