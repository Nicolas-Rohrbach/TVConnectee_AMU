let count = 0;

function addButton() {
    count = count + 1;
    $.ajax({
        url: '/wp-content/plugins/TeleConnecteeAmu/views/js/utils/allCodes.php',
    }).done(function(data) {
        let select = $('<select >', {
            id: count,
            name: 'selectTv[]',
            class: 'form-control'
        }).append(data).appendTo('#registerTvForm');
        let button = $('<input >', {
            id: count,
            type: 'button',
            onclick: 'deleteRow(this.id)',
            value: 'Supprimer'
        }).appendTo('#registerTvForm')
    });
}

function deleteRow(id) {
    let dele = document.getElementById(id);
    dele.remove();
    let dele2 = document.getElementById(id);
    dele2.remove();
}