;(function ($) {
    jQuery(document).ready(function ($) {
        // Add a click event listener to the button with the class 'edit-button'.
        $('#wpbody').on('click', '.edit-button', function (event) {
            event.preventDefault();

            // Get the URL from the 'data-url' attribute.
            var url = $(this).data('url');

            // Create a new popup window
            var popupWindow = window.open('', '_blank', 'width=1000,height=600');

            // Fetch the content of the page with id "adminmenuwrap" using AJAX
            $.ajax({
                url: url,
                dataType: 'html',
                success: function (data) {
                    // Remove the content of the adminmenuwrap section
                    // var data = $(data).find('#adminmenuwrap').remove();

                    // Write the remaining content into the popup window document
                    popupWindow.document.write(data);
                    // Add a load event listener to the popup window's document
                    // setTimeout(function () {
                    //
                    //     console.log( 'Hello' );
                    //     // Remove the content of the adminmenuwrap section
                    //     popupWindow.document.body.find('#adminmenuwrap').remove();
                    //     // Close the document to finish writing
                    //     popupWindow.document.close();
                    // }, 1000); // You can adjust the delay time as needed

                }
            });
        });
    });
})(jQuery);
