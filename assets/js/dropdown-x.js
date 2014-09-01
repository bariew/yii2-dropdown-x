/*!
 * @copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @version 1.0.0
 *
 * Dropdown menu for Bootstrap 3 supporting submenu drilldown.
 * 
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */
(function ($) {
    $(document).ready(function () {
        $('ul.dropdown-menu [data-toggle=dropdown]').on('mouseenter', function (event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).parent().siblings().removeClass('open');
            $(this).parent().addClass('open');
        });
        $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function (event) {
            if (!$(this).prop('href').length) {
                return;
            }
            event.preventDefault();
            event.stopPropagation();
            window.location.href = $(this).prop('href');
        });
    });
})(jQuery);