;
(function ($, w, d, h, b) {

    var app = {

        details_show : function(){

                $viewAll =  $('.gallery-view-all');
                $viewOnce   = $('.gallery-view-once');

                $viewAll.on('click', function (e) {

                    e.preventDefault();

                    $('.aios-gallery-md-procedures').fadeIn();
                });

                
                $viewOnce.on('click', function (e) {

                        e.preventDefault();
                        $('.aios-gallery-md-procedures').fadeOut();

                        var activeTab = $(this).data("trigger");
                        $("."+activeTab).fadeIn();

                })






        },
        hero: function () {

            var $main = $('.aios-gallery-md-procedures-slideshow');

            $main.each(function ( i, v ) {
                $(v).slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: false,
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
                autoplay:false,
                arrows: true,
                prevArrow: $('.aios-gallery-prev'),
                nextArrow: $('.aios-gallery-next'),
                responsive: [
                    {
                      breakpoint: 992,
                      settings: {
                        slidesToShow: 1
                      }
                    }
                ]
            });
        },
        video_section: function () {
            $('.aios-video-thumb a').on('click', function(e){
                e.preventDefault();
                $('.aios-gallery-video-preview iframe').attr('src', $(this).attr('href'));
            });
            $('.aios-gallery-video-thumbnails').slick({
                dots: false,
                arrows: false,
                vertical: true,
                slidesToShow: 3,
                slidesToScroll: 3,
                verticalSwiping: true,
                 responsive: [
                    {
                      breakpoint: 992,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                           vertical: false,
                      }
                    },

                ]
            });
        },
        init: function () {
            this.hero();
            this.details_show();
            this.testimonials();
            this.video_section();
        }
    }

    $(document).ready(function () {
        /* Initialize all app functions */

        app.init();
    });

    /** 
     * Please do add your custom script functions similar to the current file structure.
     * You may also add your uncategorized script functions inside the `app.others` function.
     *
     */
})(jQuery, window, document, 'html', 'body');