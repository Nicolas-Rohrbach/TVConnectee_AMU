//if(window.addEventListener){
//    window.addEventListener('load', afterLoadPage, false);
//}else{
//    window.attachEvent('onload', afterLoadPage);
//}

//function afterLoadPage () {
//	alert('scooby doo');
//}

/**
 * param : event
 * permet de d'autoriser le dépot de l'evenement
 **/
function allowDrop(ev) {
    ev.preventDefault();
}

function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('drag1').innerHTML =
        h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}

function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}

function refreshDate(){
    var maintenant=new Date();
    var jour=maintenant.getDate();
    var mois=maintenant.getMonth()+1;
    var an=maintenant.getFullYear();
    document.getElementById("drag3").innerHTML = jour+"/"+mois+"/"+an;

}

function meteo () {
    var meteoRequest = new XMLHttpRequest();
    var longitude = 5.4510;
    var latitude = 43.5156;
    var url = "http://api.openweathermap.org/data/2.5/weather?lat=" + latitude + "&lon=" + longitude + "&lang=fr&APPID=ae546c64c1c36e47123b3d512efa723e";
    function refreshWeather(){
        meteoRequest.open('GET', url, true);
        meteoRequest.setRequestHeader('Accept', 'application/json');
        meteoRequest.send();
    }
    meteoRequest.onload =  function () {
        var json = JSON.parse(this.responseText);
        var temp = Math.round(getTemp(json));
        var vent = getWind(json).toFixed(0);
        var div = document.getElementById('drag2');
        div.innerHTML = "";
        var weather = document.createElement("DIV");
        weather.innerHTML = temp + "<span style=\"font-size: 16px;\">°C</span>";
        weather.id = "weather";
        var imgTemp = document.createElement("IMG");
        imgTemp.id = "icon";
        imgTemp.src = "http://tv-connectee-amu.alwaysdata.net/wp-content/plugins/TeleConnecteeAmu/notif&alerte/weather/" + getIcon(json) + ".png";
        imgTemp.alt = getAlt(json);
        imgTemp.setAttribute ('style', 'max-height : 25px; float : left; background-color: grey; clear : both');
        weather.appendChild(imgTemp);
        var wind = document.createElement("DIV");
        wind.innerHTML = vent + "<span style=\"font-size: 16px;\">km/h</span>";
        wind.id = "wind";
        var imgVent = document.createElement("IMG");
        imgVent.src = "http://tv-connectee-amu.alwaysdata.net/wp-content/plugins/TeleConnecteeAmu/notif&alerte/weather/wind.png";
        imgVent.alt = "Img du vent";
        imgVent.setAttribute ('style', 'float :left; max-height: 25px; background-color: grey; clear : both');
        wind.appendChild(imgVent);
        div.appendChild(weather);
        div.appendChild(wind);
        document.getElementById('choix2').appendChild(div);
        setTimeout(refreshWeather, 900000);
    }
    function getAlt(json){
        return json["weather"][0]["description"];
    }
    function getIcon(json){
        return cutIcon(json["weather"][0]["icon"]);
    }
    function cutIcon(str){
        return str.substr(0, str.length -1);
    }
    function getTemp(json){
        return kelvinToC(json["main"]["temp"]);;
    }
    function kelvinToC(kelvin){
        return kelvin - 273.15;
    }
    function getWind(json) {
        return msToKmh(json["wind"]["speed"]);
    }
    function msToKmh(speed) {
        return speed * 3.6;
    }
    refreshWeather();
}

/**
 * parma : event
 * transforme le contenu de l'event en texte pour le déplacer
 **/
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

/**
 * param : event
 * fonction qui permet de déposer l'event dans une dropzone
 * **/
function drop(ev) {
    var target = $( ev.target );
    if (target.is("div")){
        var data = ev.dataTransfer.getData("text");
        var parent = ev.target.parentNode.id;
        var par2 = document.getElementById(data).parentNode;

        if(ev.target.className == 'drag'){

            for (i=0;i<20;++i){
                if (ev.target.id == "drag"+i){
                    if(par2.className == 'dropbox'){
                        document.getElementById(par2.id).appendChild(ev.target);
                        continue;
                    }
                    document.getElementById("choix"+i).appendChild(ev.target);
                }
            }
            document.getElementById(parent).appendChild(document.getElementById(data));
            document.getElementById(data).style.width= "auto";
            document.getElementById(data).style.minHeight= "100%";
            document.getElementById(data).style.maxWidth= "100%";
            return;
        }
        document.getElementById(ev.target.id).appendChild(document.getElementById(data));
        document.getElementById(data).style.minHeight= "100%";
        document.getElementById(data).style.maxWidth= "100%";
        document.getElementById(data).style.width= "auto";
    }
}


// ici
// var element = document.getElementsByClassName('drag');
// var resizer = document.createElement('div');
// resizer.className = 'resizer';
// resizer.style.width = '10px';
// resizer.style.height = '10px';
// resizer.style.background = 'red';
// resizer.style.position = 'absolute';
// resizer.style.right = 0;
// resizer.style.bottom = 0;
// resizer.style.cursor = 'se-resize';
// element.appendChild(resizer)
// resizer.addEventListener('mousedown', initResize, false);

/**
 * param : event
 * ajoute un eventListener sur la page qui :
 * quand l'utilisateur bouge la souris la fonction Resize s'arrête
 * quand l'utilisateur leve son doigt de la souris la fonction stopResize s'arrête
 * **/
function initResize(e) {
    window.addEventListener('mousemove', Resize, false);
    window.addEventListener('mouseup', stopResize, false);
}

/**
 * param e : event
 * redimensionne l'élement désigné par l'evenement
 * **/
function Resize(e) {
    element.style.width = (e.clientX - element.offsetLeft) + 'px';
    element.style.height = (e.clientY - element.offsetTop) + 'px';
}

/**
 * param e : event
 * retire les eventListener de la fonction initResize
 * */
function stopResize(e) {
    window.removeEventListener('mousemove', Resize, false);
    window.removeEventListener('mouseup', stopResize, false);
}


/**
 * param ev : event
 * lorsqu'on double-clique sur un élement il est remis dans la liste des modules
 */
function doubleclic(ev) {
    ev.preventDefault();
    for (i=0;i<100;++i){
        if (ev.target.id == "drag"+i){
            document.getElementById("choix"+i).appendChild(ev.target);
        }
    }
}

/**
 function enregistrer() {
	$('.dropbox').each(function() {
		alert ($(this).attr('id'));
		alert ($(this).children().attr('id'));
		alert ($(this).css());
	});
}
 **/

//creer les lignes
function creerLignes() {

    var nbDivLigne = document.getElementById("zonedrop");

    var l = document.getElementById("nbLigne");
    var nbLigne = l.options[l.selectedIndex].value;

    // Verification si div ligne deja presentes, si oui on les supprime
    if (nbDivLigne.childElementCount !== 0) {
        while (nbDivLigne.firstChild) {
            while (nbDivLigne.firstChild.firstChild){
                if (nbDivLigne.firstChild.firstChild.firstChild){
                    for (let i = 1; i<20; i++){
                        if  (document.getElementsByClassName("dropbox")[0].firstElementChild.id == ("drag"+i)){
                            document.getElementById("choix"+i).appendChild(document.getElementsByClassName("dropbox")[0].firstElementChild);
                            i = 21;
                        }
                    }
                }
                nbDivLigne.firstChild.removeChild(nbDivLigne.firstChild.firstChild);
            }
            nbDivLigne.removeChild(nbDivLigne.firstChild);
        }
    }

    //Supression des selections de dimension de ligne

    var alldim = document.getElementsByClassName("dim");
    while (alldim[0]) {
        alldim[0].parentNode.removeChild(alldim[0]);
    }

    //Suppression des select du nombre de colonne ( a ameliorer )

    var selectc = document.getElementsByClassName("selectColonne");
    while (selectc[0]) {
        selectc[0].parentNode.removeChild(selectc[0]);
    }

    var array = [1, 2, 3, 4];


    for (var i = 1; i <= nbLigne; i++) {

        //creation de div ligne

        var ligne = document.createElement('div');
        ligne.className = "ligne";
        ligne.id = "ligne" + i;
        var dz = document.getElementById("zonedrop");

        if(nbLigne == 3){
            if(i == 1)
                ligne.style.height = 34 + "%";
            else
                ligne.style.height = 33 + "%";
        }
        else
            ligne.style.height = (100 * (1/nbLigne)) + "%";

        dz.appendChild(ligne);

        //creation div colonne

        var colonne = document.createElement("div");
        colonne.id = "l" + i + "c" + 1;
        colonne.className = "dropbox";
        colonne.ondrop = function () {drop(event)};
        colonne.ondragover = function () {allowDrop(event)};

        colonne.style.width = 100 + '%';

        document.getElementById("ligne" + i).appendChild(colonne);

        //creation des select du nombre de colonne par lignes

        var textList = document.createElement("p");

        textList.innerHTML = "Nombre de colonne sur la ligne " + i;
        textList.className = "selectColonne";

        var selectList = document.createElement("select");

        selectList.setAttribute("onchange", "creerColonne()");

        selectList.id = "selectColonne" + i;
        selectList.name = "selectColonne" + i;
        selectList.className = "selectColonne";

        var colonnezone = document.getElementById("colonnezone")

        colonnezone.appendChild(textList);
        colonnezone.appendChild(selectList);

        document.getElementById("divordre").appendChild(colonnezone);

        //ajout des option des nombres de colonne par ligne

        for (var j = 0; j < array.length; j++) {
            var option = document.createElement("option");
            option.value = array[j];
            option.text = array[j];
            selectList.appendChild(option);
        }

        //creation des select de la hauteur des lignes

        var dim = document.createElement("div");
        dim.id = "diml" + i;
        dim.className = "dim";

        var dim_p = document.createElement("h2");
        dim_p.innerHTML = "Ligne " + i;

        var dim_p2 = document.createElement("h3");
        dim_p2.innerHTML = "Hauteur";

        var dim_input = document.createElement("input");
        dim_input.type = "number";
        dim_input.id = "selectDimensionl" + i;
        dim_input.name = "selectDimensionl" + i;
        dim_input.className = "selectDimensionl";
        dim_input.value = 100;
        dim_input.max = 100/nbLigne * 2;
        dim_input.min = 0;
        dim_input.value = Math.round(document.getElementById("ligne" + i).clientHeight / 480 * 100);
        dim_input.setAttribute("onchange", "changerHauteur(" +i+ ")");

        dim.appendChild(dim_p);
        dim.appendChild(dim_p2);
        dim.appendChild(dim_input);

        document.getElementById("dimension").appendChild(dim);

        //creation des select de la largeur des colonnes


        var largcolonne_h3 = document.createElement("h3");
        largcolonne_h3.className = "selectLargeur";
        largcolonne_h3.innerHTML = "Largeur";

        var largcolonne_p = document.createElement("p");
        largcolonne_p.className = "selectLargeur";
        largcolonne_p.innerHTML = "Colonne 1";

        var largcolonne_input = document.createElement("input");
        largcolonne_input.type = "number";
        largcolonne_input.id = "selectLargeurl" + i + "c1";
        largcolonne_input.name = "selectLargeurl" + i + "c1";
        largcolonne_input.className = "selectLargeur";
        largcolonne_input.value = 100;
        largcolonne_input.max = 100;
        largcolonne_input.min = 0;
        largcolonne_input.setAttribute("onchange", "changerLargeur("+i+",  1 )");

        dim.appendChild(largcolonne_h3);
        dim.appendChild(largcolonne_p);
        dim.appendChild(largcolonne_input);


    }
}

//creer le nombre de colonne par ligne : les select et les div
function creerColonne(){

    var l = document.getElementById("nbLigne");
    var nbLigne = l.options[l.selectedIndex].value;
    var nbLigneTemoin = nbLigne;

    //suppression des largeurs de colonnes

    var largeurcolonne = document.getElementsByClassName("selectLargeur");
    while(largeurcolonne[0]){
        largeurcolonne[0].parentNode.removeChild(largeurcolonne[0]);
    }

    for(;nbLigne > 0; nbLigne--){

        var c = document.getElementById("selectColonne" + nbLigne);
        var nbcolonne = c.options[c.selectedIndex].value;
        var nbcolonneTemoin = nbcolonne;

        var nb = document.getElementById("ligne" + nbLigne);

        //verification de la presence de colonne pour une ligne, si oui suppression des colonnes ( a ameliorer )

        if(nb.childElementCount !== 0){
            while (nb.firstChild) {
                if (nb.firstChild.firstChild){
                    for (let j=0;j<16;++j){
                        if (document.getElementsByClassName("dropbox")[j]){
                            let id =document.getElementsByClassName("dropbox")[j].firstElementChild.id.substring(4);
                            document.getElementById("choix"+id).appendChild(document.getElementsByClassName("dropbox")[j].firstElementChild);
                        }
                    }
                }
                nb.removeChild(nb.firstChild);
            }
        }

        //Ajout titre largeur par ligne
        var dimcolonne_h3 = document.createElement("h3");
        dimcolonne_h3.className = "selectLargeur";
        dimcolonne_h3.innerHTML = "Largeur";

        document.getElementById("diml" + nbLigne).appendChild(dimcolonne_h3);




        //creation des div de colonne par ligne

        for(var k = 1; k <= nbcolonne; k++){

            var colonne = document.createElement("div");
            colonne.id = "l" + nbLigne + "c" + k;
            colonne.className = "dropbox";
            colonne.ondrop = function () {drop(event)};
            colonne.ondragover = function () {allowDrop(event)};


            if(nbcolonne == 3){
                if(k == 1)
                    colonne.style.width = 34 + "%";
                else
                    colonne.style.width = 33 + "%";
            }
            else
                colonne.style.width = (100 / nbcolonneTemoin) + "%";

            document.getElementById("ligne" + nbLigne).appendChild(colonne);


            //creation des selecteur de largeurs par colonne
            var dimcolonne = document.getElementById("diml" + nbLigne);

            var dimcolonne_p = document.createElement("p");
            dimcolonne_p.className = "selectLargeur";
            dimcolonne_p.innerHTML = "Colonne " + k;


            var dimcolonne_input = document.createElement("input");
            dimcolonne_input.type = "number";
            dimcolonne_input.id = "selectLargeurl" + nbLigne + "c" + k;
            dimcolonne_input.name = "selectLargeurl" + nbLigne + "c" + k;
            dimcolonne_input.className = "selectLargeur";
            dimcolonne_input.value = 100;
            dimcolonne_input.max = 100 / nbcolonne * 2;
            dimcolonne_input.min = 0;
            dimcolonne_input.value = Math.round(document.getElementById("l" + nbLigne + "c" + k).clientWidth / 720 * 100);
            dimcolonne_input.setAttribute("onchange", "changerLargeur("+nbLigne+"," + k +")");

            dimcolonne.appendChild(dimcolonne_p);
            dimcolonne.appendChild(dimcolonne_input);

        }
    }
}

function changerHauteur(numLigne) {

    var l = document.getElementById("nbLigne");
    var nbLigne = l.options[l.selectedIndex].value;

    var dimension = document.getElementById("selectDimensionl" + numLigne).value;
    if(dimension > 100/ nbLigne * 2) {
        alert("Dimension trop grande");
        document.getElementById("selectDimensionl" + (numLigne)).value = Math.round(document.getElementById("ligne" + numLigne).clientHeight / 480 * 100);
        return;
    }
    else if(dimension < 0) {
        alert("Dimension négative impossible");
        document.getElementById("selectDimensionl" + (numLigne)).value = Math.round(document.getElementById("ligne" + numLigne).clientHeight / 480 * 100);
        return;
    }

    if (document.getElementById("ligne" + (numLigne + 1))) {
        var ligneCourante = Math.round(document.getElementById("ligne" + (numLigne )).clientHeight /480 * 100);
        var ligneInferieur = Math.round(document.getElementById("ligne" + (numLigne + 1)).clientHeight /480 * 100);
        var pct1 = parseInt(ligneCourante) + parseInt(ligneInferieur);

        document.getElementById("ligne" + numLigne).style.height = dimension + "%";
        document.getElementById("selectDimensionl" + (numLigne + 1)).value = pct1 - dimension;
        document.getElementById("ligne" + (numLigne + 1)).style.height = pct1 - dimension + "%"
    }

    else if (document.getElementById("ligne" + (numLigne - 1))) {
        var ligneCourante1 = Math.round(document.getElementById("ligne" + (numLigne )).clientHeight /480 * 100);
        var ligneSuperieur = Math.round(document.getElementById("ligne" + (numLigne - 1)).clientHeight /480 * 100);
        var pct2 = parseInt(ligneCourante1) + parseInt(ligneSuperieur);
        document.getElementById("ligne" + numLigne).style.height = dimension + "%";
        document.getElementById("selectDimensionl" + (numLigne - 1)).value = pct2 - dimension;
        document.getElementById("ligne" + (numLigne - 1)).style.height = pct2 - dimension + "%"
    }
    else {
        alert("Redimmensionnage impossible car il n'y a qu'une seule ligne");
        document.getElementById("selectDimensionl" + (numLigne)).value = Math.round(document.getElementById("ligne" + numLigne).clientHeight / 480 * 100);
    }
}

//Changer Largeur des colonnes
function changerLargeur(numLigne, numColonne) {

    var c = document.getElementById("selectColonne" + numLigne);
    var nbcolonne = c.options[c.selectedIndex].value;

    var dimension = document.getElementById("selectLargeurl" + numLigne + "c" + numColonne).value;
    //Condition pour verifier que la largeur ne soit pas trop grande
    if(dimension > 100/ nbcolonne * 2) {
        alert("Dimension trop grande");
        document.getElementById("selectLargeurl" + numLigne + "c" + numColonne).value = Math.round(document.getElementById("l" + numLigne + "c" + (numColonne)).clientWidth / 720 * 100);
        return;
    }
    else if(dimension < 0) {
        alert("Dimension négative impossible");
        document.getElementById("selectLargeurl" + numLigne + "c" + numColonne).value = Math.round(document.getElementById("l" + numLigne + "c" + (numColonne)).clientWidth / 720 * 100);
        return;
    }


    //si la colonne possède une colonne à sa droite
    if (document.getElementById("l" + numLigne + "c" + (numColonne + 1))) {
        var colonneCourante = Math.round(document.getElementById("l" + numLigne + "c" + (numColonne)).clientWidth /720 * 100);
        var colonneInferieur = Math.round(document.getElementById("l" + numLigne + "c" + (numColonne + 1)).clientWidth /720 * 100);
        var pct1 = parseInt(colonneCourante) + parseInt(colonneInferieur);

        document.getElementById("l" + numLigne + "c" + (numColonne)).style.width = dimension + "%";
        document.getElementById("selectLargeurl" + numLigne + "c" + (numColonne + 1)).value = pct1 - dimension;
        document.getElementById("l" + numLigne + "c" + (numColonne + 1)).style.width = pct1 - dimension + "%"
    }

    //si la colonne possède une colonne à sa gauche
    else if (document.getElementById("l" + numLigne + "c" + (numColonne - 1))) {
        var colonneCourante1 = Math.round(document.getElementById("l" + numLigne + "c" + (numColonne)).clientWidth /720 * 100);
        var colonneSuperieur = Math.round(document.getElementById("l" + numLigne + "c" + (numColonne - 1)).clientWidth /720 * 100);
        var pct2 = parseInt(colonneCourante1) + parseInt(colonneSuperieur);

        document.getElementById("l" + numLigne + "c" + (numColonne)).style.width = dimension + "%";
        document.getElementById("selectLargeurl" + numLigne + "c" + (numColonne - 1)).value = pct2 - dimension;
        document.getElementById("l" + numLigne + "c" + (numColonne - 1)).style.width = pct2 - dimension + "%"
    }
    else {
        alert("Redimmensionnage impossible car il n'y a qu'une seule colonne");
        document.getElementById("selectLargeurl" + numLigne + "c" + numColonne).value = Math.round(document.getElementById("l" + numLigne + "c" + numColonne).clientWidth / 720 * 100);
    }
}

$(document).ready( function() {

    $("#clayout").submit(function () {
        $.ajax({
            url : 'http://ptuttv.alwaysdata.net/wp-content/plugins/tv-plugin/templates/traitementLayout.php',
            method: "POST",
            dataType: "json",
            data: $(this).serialize(),
        }).done(function (data) {
            if(data === true){
                //quand le layout est enregistrer
            }
            else {
                alert("Erreur BDD");
            }
        });
        return false;
    })
});




