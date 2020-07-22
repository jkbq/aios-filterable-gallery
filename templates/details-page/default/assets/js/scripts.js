;
(function ($, w, d, h, b) {

    var app = {

        hero: function () {

            var $main = $('.aios-gallery-md-procedures-slideshow');

            $main.each(function ( i, v ) {
                $(v).slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    dots: true,
                    arrows: true,
                    swipe: false,
                });
            });



        },
        testimonials: function () {
            $('.aios-filterable-testi-wrap').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 3,
                arrows: true,
                prevArrow: $('.aios-gallery-prev'),
                nextArrow: $('.aios-gallery-next'),
                responsive: [
                    {
                      breakpoint: 768,
                      settings: {
                        slidesToShow: 1
                      }
                    },
                    {
                      breakpoint: 480,
                      settings: {
                        slidesToShow: 1
                      }
                    }
                ]
            });
        },
        init: function () {
            this.hero();
        }
    }

    $(document).ready(function () {
        /* Initialize all app functions */
        app.testimonials();
        app.init();
    });

    /** 
     * Please do add your custom script functions similar to the current file structure.
     * You may also add your uncategorized script functions inside the `app.others` function.
     *
     */
})(jQuery, window, document, 'html', 'body');