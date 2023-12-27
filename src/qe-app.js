;(function ($) {
    jQuery(document).ready(function ($) {

        setTimeout(function () {
            const isWindowOpen = window.location.search.includes('window=open_window');
            if( isWindowOpen ) {
                var form = $(document.body).find('#post').html();
                $(document.body).find('#adminmenumain').remove();

                $(document.body).find('#woocommerce-embedded-root').remove();
                $(document.body).find('#wpcontent').css({
                    margin: 0,
                });
                form = '<form name="post" action="post.php" method="post" id="post"> ' + form + ' </form>';
                $(document.body).find('#wpbody-content').html(form);
                $(document.body).removeClass('opacity-0');
            }
        }, 1000); // You can adjust the delay time as needed

        // Initialize a variable to store the reference to the opened window
        let popupWindow = null;
        // Add a click event listener to the button with the class 'edit-button'.
        $('#wpbody').on('click', '.edit-button', function (event) {
            event.preventDefault();
            // Check if the window is already open
            if (popupWindow && !popupWindow.closed) {
                // If open, focus on the existing window instead of opening a new one
                popupWindow.focus();
            } else {
                // Get the URL from the 'data-url' attribute.
                var url = $(this).data('url') + '&window=open_window';
                // Create a new popup window
                popupWindow = window.open( url, '_blank', 'width=1000,height=600' );
                setTimeout(function () {
                    var form = $(popupWindow.document.body).find('#post').html();
                    $(popupWindow.document.body).find('#adminmenumain').remove();

                    $(popupWindow.document.body).find('#woocommerce-embedded-root').remove();
                    $(popupWindow.document.body).find('#wpcontent').css({
                        margin: 0,
                    });
                    form = '<form name="post" action="post.php" method="post" id="post"> ' + form + ' </form>';
                    $(popupWindow.document.body).find('#wpbody-content').html(form);
                    $(popupWindow.document.body).removeClass('opacity-0');
                    popupWindow.document.close();
                }, 1000); // You can adjust the delay time as needed

            }

        });
    });


})(jQuery);
