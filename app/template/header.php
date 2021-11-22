<header class="main">
    <div class="user_info">
        <div class="dropdown">
            <button class="btn dropdown-toggle btn-sm" type="button" id="dropdownMenu2" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                <?= $Text_welcome ?>  <?= $this->getuser()->getusername() ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <a class="dropdown-item" href="/usersprofile/edit"> <?= isset($Text_user_info) ? $Text_user_info : '' ?> </a>
                <a class="dropdown-item" href="/users/changepass"> <?= isset($Text_change_pass) ? $Text_change_pass : '' ?> </a>
                <div class="dropdown-divider"></div>
                <a class="text-light dropdown-item-text fa fa-sign-out-alt"
                   href="/auth/logout""> <?= isset($Text_logout) ? $Text_logout : '' ?></a>
            </div>
        </div>
        <div class="notification">
            <button class="btn" type="button" id="dropdown_notification" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                <i class="fa fa-bell fa-lg" aria-hidden="true"></i>
            </button>
        </div>
        <div class="mailer">
            <button class="btn" type="button" id="dropdown_notification" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                <i class="fa fa-envelope fa-lg" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <i class="fas fa-bars navbar_btn" id="open_nav"></i>
    <a href="/" class="link_no_style">
        <h1>
            <?= isset($h1FirstName) ? $h1FirstName : '' ?>
            <span> <?= isset($h1SecondName) ? $h1SecondName : '' ?></span>
        </h1>
    </a>
</header>