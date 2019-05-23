<?php

$current_user = wp_get_current_user();
$model = new CodeAdeManager();
$years = $model->getCodeYear();?>

<script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>

<div class="topnav" id="myTopnav">
    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
        <div class="logo">
            <img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
        </div>
    </a>
    <?php if (!is_user_logged_in()) { ?>
    <a href="<?php echo site_url('wp-login.php') ?>">Connexion</a>
    <?php } elseif ($current_user->role != "television" && is_user_logged_in()) { ?>
    <div class="drop_down">
        <button class="dropbtn">Emploi du temps
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="drop_down-content">
            <?php if (isset($years)) {
                foreach ($years as $year) { ?>
                    <a href="/emploi-du-temps/<?php echo $year['code']; ?>/"> <?php echo $year['title'] ?></a>
                <?php }
            } ?>
        </div>
    </div>
    <?php if ($current_user->role == "secretaire" || $current_user->role == "administrator") { ?>
        <div class="drop_down">
            <button class="dropbtn">Utilisateurs
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="drop_down-content">
                <a href="/creation-des-comptes"> Création des comptes</a>
                <a href="/gestion-des-utilisateurs">Gestion des utilisateurs</a>
            </div>
        </div>
    <?php }  if ($current_user->role == "secretaire" || $current_user->role == "administrator" || $current_user->role == "enseignant") { ?>
        <div class="drop_down">
            <button class="dropbtn">Alertes & Informations
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="drop_down-content">
                <a href="/creer-une-alerte">Créer une alerte</a>
                <a href="/gerer-les-alertes">Gestion des alertes</a>
                <?php if ($current_user->role == "secretaire" || $current_user->role == "administrator") { ?>
                    <a href="/creer-information">Créer une information</a>
                    <a href="/gerer-les-informations">Gestion des informations</a>
                <?php } ?>
            </div>
        </div>
        <?php if ($current_user->role == "secretaire" || $current_user->role == "administrator") { ?>
            <a href="/gestion-codes-ade/"> Codes ADE</a>
        <?php }
    } ?>
    <a href="/mon-compte">Mon compte</a>
    <a href="<?php echo wp_logout_url(); ?>">Déconnexion</a>
    <?php } else {?>
    <a class="ninja" href="<?php echo wp_logout_url(); ?>">Déconnexion</a>
    <?php } ?>
    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>

