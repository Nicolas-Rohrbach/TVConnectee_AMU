function  form(data) {
    var ImageProfil=$('<div/>').addClass("ImageProfil");
    ImageProfil.css("background-image", "url('.."+data+"')");
    ImageProfil.click(function () {
        $('input[type=file]').click();
    });
    return $('<div />').addClass("InscriptionForm").append(
        $('<h1/>').html("Informations"),
        $('<p />').html("Changer vos informations"),
        $('<form />')
            .attr('action', 'php/changeProfil.php')
            .attr('method', 'post')
            .attr('enctype', 'multipart/form-data')
            .append(
                ImageProfil,
                $('<input />').attr('name', 'avatar').attr('type', 'file'),
                $('<br />'),
                $('<button />').attr('type', 'submit').html('Valider'),
                $('<br/>')
            ).submit(function(e) {
            $.ajax({
                url: 'php/changeProfil.php',
                method: 'post',
                enctype: 'multipart/form-data',
                dataType: 'json',
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
            }).success(function (data) {
                if(data.hasOwnProperty('message')){
                    $('.messageErreur').html(data.message);
                }
                if(data.success===true){
                    window.location.reload(true);
                }
            }).fail(erreurCritique);
            return false;
        }),
        $('<p/>').addClass('messageErreur')
    );
};