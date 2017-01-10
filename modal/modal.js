function showUrlModal(url) {
    $('.modal').modal('show');

    $.get(url)
        .done(function(data) {
            $('.modal').find('.modal-content').html(data);
        })
        .fail(function() {
            $('.modal').find('.modal-content').html('error');
        });

}