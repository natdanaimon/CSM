function closeStep(id) {
    if ($('#step' + id).css('display') == 'block') {
        $('#step' + id).attr('style', 'display:none');
    } else {
        $('#step' + id).attr('style', 'display:block');
    }
}
