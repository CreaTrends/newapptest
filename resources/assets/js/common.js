(function ( $ ) {
 
    console.log('esto es el plugin');

    elWidth = $('#element').parent().width();
    console.log($( document ).height());


 
}( jQuery ));
$(document).ready(function()
{
notifications = {
    markAsRead: function(notification,url)
    {
        

        var $el = $('div[data-notification=' + notification[0] + ']');
        axios.get(url,
            {
                params:
                {
                    nid: notification[0] || null,
                    uid: notification[1] || null,
                }
            }).then(function(response)
        {
            $container.fadeOut(300, function()
            {
                $container.remove();
            });
            console.log('respuest : ' + response.data.status);
        }).catch(error =>
        {
            console.log('tuvimos error');
        });
    },
    markAllAsRead: function(url)
    {
       
        var $el = $(this).data('notification');
        
        console.log($el);
        axios.get(url,
            {
                params:
                {
                    uid: '',
                }
            }).then(function(response)
        {
            $('#drop-notification-list').find(".notification-item").removeClass('is-active');
            $('.notification').addClass('d-none');
            console.log('respuest : ' + response.data.message);
        }).catch(error =>
        {
            console.log('tuvimos error');
        });
    },
    deleteNotification: function(notification,url)
    {
       

        var $el = $('div[data-notification=' + notification[0] + ']');
        
        $container = $('div[data-notification=' + notification[0] + ']')
        axios.get(url,
            {
                params:
                {
                    nid: notification[0],
                    uid: notification[1],
                }
            }).then(function(response)
        {
            $container.fadeOut(300, function()
            {
                $container.remove();
            });
            $('.notification').text(response.data.count);
            if(response.data.html != null){
                $('#drop-notification-list').html(response.data.html);
                $('#drop-notification-list').find(".notification-item").removeClass('is-active');
                $('.notification').addClass('d-none');

            }
            console.log('respuest : ' + response.data.html);
        }).catch(error =>
        {
            console.log('tuvimos error');
        });
    }
}

});

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

