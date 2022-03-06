$(document).ready(() => {
    if ($('li.wp-has-submenu.wp-menu-open').length > 0) {
        document.querySelector('li.wp-has-submenu.wp-menu-open').scrollIntoView({behavior: "smooth", block: "start"});
    }

    if ($('li.current.menu-top').length > 0) {
        document.querySelector('li.current.menu-top').scrollIntoView({behavior: "smooth", block: "start"});
    }


    $('li.wp-has-submenu a.wp-has-submenu').removeAttr('href');
    $('li.wp-has-submenu.wp-menu-open').find('.wp-submenu').slideDown();

    $('li.wp-has-submenu').click(function() {
        $(this).siblings().find('.wp-submenu').slideUp();
        $(this).find('.wp-submenu').slideDown();
    });

});