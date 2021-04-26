$(document).find('.redelivery_tab').on('click', function () {
    var _this = $(this).find('input:radio:checked').val();
    switch (_this) {
        case '0': {
            $(document).find('.redelivery-div').addClass('hidden');
        }
            break;

        case '1': {
            $(document).find('.redelivery-div').removeClass('hidden');
        }
            break;
    }
});