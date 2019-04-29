function updateDiv() {

    $.ajax({
        url: 'views/js/utils/generateUrlADE.php'
    }).success(function(data) {
        let divC = $('<div >', {class:'container'}).appendTo(main);
        //let divR = $('<div >', {class:'row'}).appendTo(divC);
        $(divC).append(data);
    });

}

updateDiv();