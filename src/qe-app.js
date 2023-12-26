;(function ($) {

    jQuery(document).ready( ($) => {
        // Add a click event listener to the button with the class 'edit-button'.
        $('#wpbody').on('click', '.edit-button', function(event) {
            event.preventDefault();
            // Calculate the center position
            var width = 1000, height = 600;
            var left = (window.outerWidth - width) / 2;
            var top = (window.outerHeight - height) / 2;
            // Get the URL from the 'data-url' attribute.
            var url = $(this).data('url');
            // Open the URL in a new window or tab.
            window.open(url, '_blank', 'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top);
        });
    });

})(jQuery);
