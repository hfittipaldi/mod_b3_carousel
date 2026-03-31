/*
 * Example logic (using a basic implementation, not a full plugin)
 * This logic must be placed after jQuery and Bootstrap JS are loaded.
 *
 * https://stackoverflow.com/questions/37147658/bootstrap-carousel-with-swipe-using-touchswipe-on-two-pages-does-not-swipe#40742609
 */
window.addEventListener('load', () => {
    jQuery(".b3Carousel").on("touchstart", function(event) {
        var xClick = event.originalEvent.touches[0].pageX;
        jQuery(this).one("touchmove", function(event) {
            var xMove = event.originalEvent.touches[0].pageX;
            var sensitivity = 5; // Adjust as needed
            if ( Math.floor(xClick - xMove) > sensitivity ) {
                jQuery(this).carousel('next');
            }
            else if ( Math.floor(xClick - xMove) < -sensitivity ) {
                jQuery(this).carousel('prev');
            }
        });
        jQuery(".carousel").on("touchend", function() {
            jQuery(this).off("touchmove");
        });
    });
});
