function addButton() {
    $('<input >').append("oui").appendTo('#registerTvForm');
    $('<h1 >', {text:'Mes offres/Demandes', class:'text-center'}).appendTo('body');

    $.ajax({
        url: '/wp-content/plugins/TeleConnecteeAmu/views/js/utils/allCodes.php',
    }).done(function(data) {
        let divC = $('<div >', {class:'container'}).appendTo('body');
        $(data).appendTo(divC);
        $(divC).hide();
        $(divC).fadeIn(1000);
    });

}