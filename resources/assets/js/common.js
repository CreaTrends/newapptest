(function ( $ ) {
 
    console.log('esto es el plugin');

    elWidth = $('#element').parent().width();
    console.log($( document ).height());
 
}( jQuery ));


$('.dropdown-menu .body .menu').slimscroll({
        height: '254px',
        color: 'rgba(0,0,0,0.5)',
        size: '4px',
        alwaysVisible: false,
        borderRadius: '0',
        railBorderRadius: '0'
    });

$('.is-dropdown-container').slimscroll({
        height: '180px',
        color: 'rgba(0,0,0,0.5)',
        size: '4px',
        alwaysVisible: false,
        borderRadius: '0',
        railBorderRadius: '0'
    });

$('#mf-view-modal > .modal-body').slimscroll({
        height: 'auto',
        color: 'rgba(0,0,0,.8)',
        size: '4px',
        alwaysVisible: false,
        borderRadius: '0',
        railBorderRadius: '0'
    });

