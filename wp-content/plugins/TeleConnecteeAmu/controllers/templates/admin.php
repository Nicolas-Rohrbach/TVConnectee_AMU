<?php
/**
 * Plugin Name: PTUT_plugin
 * Description: le ptut c'est cool
 **/
?>

<html>
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="<?php echo plugins_url( '../assets/myscript.js?ver=5.1', __FILE__ ); ?>"></script>
    <!-- <link rel="stylesheet" type="text/css" href="<?php// echo plugins_url( '/templates/traitement.php', __FILE__ ); ?>" /> -->

</head>
<body class="body_menu" onload="(function () { startTime(); meteo(); refreshDate();})()">

<div class="header">

    <nav class="menu">

        <ul class="ul1">
            <li class="menu-html"><a href="#template_liste">Template</a></li>
            <li class="menu-html"><a href="#layout_liste">Layout</a></li>
            <li><a href="#module_liste">Module</a></li>
        </ul>

    </nav>

    <div id="template_liste" class="onglet">

        <ul class="submenu">
            <li><a href="traitement.php">--Info</a></li>
            <li><a href="#">--GMP</a></li>
            <li><a href="#">--TC</a></li>
        </ul>
    </div>

    <div id="layout_liste" class="onglet">

        <ul class="submenu">
            <li><a href="#">Layout 1</a></li>
            <li><a href="#">Layout 2</a></li>
            <li><a href="#">Layout 3</a></li>
        </ul>

        <a id="modif_layout" href="gestionLayout.html">Créer sa grille</a>
    </div>

    <div id="module_liste" class="onglet">


        <ul>
            <li><div class="boxchoix" id="choix1">
                    <div class="drag" id="drag1" draggable="true" ondragstart="drag(event)" ondblclick="doubleclic(event)"></div></div>
            </li>

            <li><div class="boxchoix" id="choix2">
                    <div class="drag" id="drag2" draggable="true" ondragstart="drag(event)" ondblclick="doubleclic(event)"></div></div>
            </li>

            <li><div class="boxchoix" id="choix3">
                    <div class="drag" id="drag3" draggable="true" ondragstart="drag(event)" ondblclick="doubleclic(event)"></div></div>
            </li>

            <li><div class="boxchoix" id="choix4">
                    <div class="drag" id="drag4" draggable="true" ondragstart="drag(event)" ondblclick="doubleclic(event)"></div></div>
            </li>

            <li><div class="boxchoix" id="choix5">
                    <div class="drag" id="drag5" draggable="true" ondragstart="drag(event)" ondblclick="doubleclic(event)"></div></div>
            </li>

            <li><div class="boxchoix" id="choix6">
                    <div class="drag" id="drag6" draggable="true" ondragstart="drag(event)" ondblclick="doubleclic(event)"></div></div>
            </li>

            <li><div class="boxchoix" id="choix7">
                    <div class="drag" id="drag7" draggable="true" ondragstart="drag(event)" ondblclick="doubleclic(event)"></div></div>
            </li>

            <li><div class="boxchoix" id="choix8">
                    <div class="drag" id="drag8" draggable="true" ondragstart="drag(event)" ondblclick="doubleclic(event)"></div></div>
            </li>

            <li><div class="boxchoix" id="choix9">
                    <div class="drag" id="drag9" draggable="true" ondragstart="drag(event)" ondblclick="doubleclic(event)"></div></div>
            </li>

            <li><div class="boxchoix" id="choix10">
                    <div class="drag" id="drag10" draggable="true" ondragstart="drag(event)" ondblclick="doubleclic(event)"></div></div>
            </li>
        </ul>

    </div>

</div>

<div id="zonedrop">
    <div class="ligne" id="ligne1">
        <div id="l1c1" class="dropbox" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    </div>
</div>

<form id="clayout" method="post">

    <div id="zoneligne" name="nbLigne" class="zonegestion">
        <h2>Nombre de lignes</h2>
        <select id="nbLigne" onchange="creerLignes()">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>

    </div>

    <div id="divordre" class="zonegestion">
        <div id="colonnezone">

            <h2>Gestion des colonnes</h2>

            <p class="selectColonne">Nombre de colonnes sur la ligne 1</p>

            <select onchange="creerColonne()" id="selectColonne1" name="selectColone1" class="selectColonne">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>

        </div>
    </div>

    <div id="dimensionzone" class="zonegestion">

        <h2>Gestion des dimensions</h2>

        <div id="dimension">


            <div id="diml1" class="dim">

                <h2>Ligne 1</h2>

                <h3 class="selectDimensionl">Hauteur</h3>

                <input class="selectDimensionl" id="selectDimensionl1" name="selectDimensionl1" type="number" value="100" max="100" min="0" onchange="changerHauteur(1)">

                <h3 class="selectLargeur">Largeur</h3>

                <p class="selectLargeur">Colonne 1</p>

                <input class="selectLargeur" id="selectLargeurl1c1" name="selectLargeurl1c1" type="number" value="100" max="100" min="0" onchange="changerLargeur(1,1)">

            </div>

        </div>
    </div>

    <input type="submit" value="Enregistrer Layout">

</form>

</body>

</html>