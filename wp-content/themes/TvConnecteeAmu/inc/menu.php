<?php

$current_user = wp_get_current_user();
$model = new CodeAdeManager();
$years = $model->getCodeYear();?>
<div id="header">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
        <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
            <div class="logo">
            <?php
                echo get_custom_logo( $blog_id = 0 );
            ?>
            </div>
        </a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarsExampleDefault" style="">
            <ul class="navbar-nav mr-auto">
                <?php if (!is_user_logged_in()) { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo site_url('wp-login.php') ?>">Connexion</a>
                </li>
                <?php }
                elseif ($current_user->role != "television" && is_user_logged_in()) { ?>
                <li class="nav-item active dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Emploi du temps</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <?php if (isset($years)) {
                            foreach ($years as $year) { ?>
                                <a class="dropdown-item"
                                   href="<?php echo home_url(); ?>/emploi-du-temps/<?php echo $year['code']; ?>/"> <?php echo $year['title'] ?>
                                </a>
                            <?php }
                        } ?>
                    </div>
                </li>
                <?php if ($current_user->role == "secretaire" || $current_user->role == "administrator") { ?>
                <li class="nav-item active dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Utilisateurs</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown02">
                        <a class="dropdown-item" href="/creation-des-comptes"> Création des comptes</a>
                        <a class="dropdown-item" href="/gestion-des-utilisateurs">Gestion des utilisateurs</a>
                    </div>
                </li>
                <?php }
                if ($current_user->role == "secretaire" || $current_user->role == "administrator" || $current_user->role == "enseignant") { ?>
                    <li class="nav-item active dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Alertes & Informations</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown03">
                            <a class="dropdown-item" href="/creer-une-alerte">Créer une alerte</a>
                            <a class="dropdown-item" href="/gerer-les-alertes">Gestion des alertes</a>
                            <?php if ($current_user->role == "secretaire" || $current_user->role == "administrator") { ?>
                                <a class="dropdown-item" href="/creer-information">Créer une information</a>
                                <a class="dropdown-item" href="/gerer-les-informations">Gestion des informations</a>
                            <?php } ?>
                        </div>
                    </li>
                    <?php if ($current_user->role == "secretaire" || $current_user->role == "administrator") { ?>
                        <li class="nav-item active dropdown">
                        <a class="nav-link" href="/gestion-codes-ade/"> Codes ADE</a>
                    </li>
                <?php }
                } ?>
                <li class="nav-item active">
                    <a class="nav-link" href="/mon-compte">Mon compte</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo wp_logout_url(); ?>">Déconnexion</a>
                </li>
                <?php }
                else { ?>
                    <li>
                        <a class="ninja" href="<?php echo wp_logout_url(); ?>">Déconnexion</a>
                    </li>
                <?php } ?>
        </div>
    </nav>
</div>



