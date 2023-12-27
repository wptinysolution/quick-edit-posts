;(function ($) {
    jQuery(document).ready(function ($) {
        // Add a click event listener to the button with the class 'edit-button'.
        $('#wpbody').on('click', '.edit-button', function (event) {
            event.preventDefault();
            // Get the URL from the 'data-url' attribute.
            var url = $(this).data('url') + '&window=openedwindow';
            // Create a new popup window
            var popupWindow = window.open( url, '_blank', 'width=1000,height=600' );
            setTimeout(function () {
                var form = $(popupWindow.document.body).find('#post').html();
                $(popupWindow.document.body).find('#adminmenumain').remove();

                $(popupWindow.document.body).find('#woocommerce-embedded-root').remove();
                $(popupWindow.document.body).find('#wpcontent').css({
                    margin: 0,
                });
                form = '<form name="post" action="post.php" method="post" id="post"> ' + form + ' </form>';
                $(popupWindow.document.body).find('#wpbody-content').html(form);
                popupWindow.document.close();
            }, 1000); // You can adjust the delay time as needed


        });
    });


})(jQuery);
