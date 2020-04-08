;
(function ($, w, d, h, b) {

    var app = {
        beforeAfterSlider: function () {
            var x, i;
            /*find all elements with an "overlay" class:*/
            x = document.getElementsByClassName("img-comp-overlay");
            for (i = 0; i < x.length; i++) {
                /*once for each "overlay" element:
                pass the "overlay" element as a parameter when executing the compareImages function:*/
                compareImages(x[i]);
            }

            function compareImages(img) {
                var slider, img, clicked = 0,
                    w, h;
                /*get the width and height of the img element*/
                w = img.offsetWidth;
                h = img.offsetHeight;
                /*set the width of the img element to 50%:*/
                img.style.width = (w / 2) + "px";
                /*create slider:*/
                slider = document.createElement("DIV");
                slider.setAttribute("class", "img-comp-slider");
                /*insert slider*/
                img.parentElement.insertBefore(slider, img);
                /*position the slider in the middle:*/
                slider.style.top = (h / 2) - (slider.offsetHeight / 2) + "px";
                slider.style.left = (w / 2) - (slider.offsetWidth / 2) + "px";
                /*execute a function when the mouse button is pressed:*/
                slider.addEventListener("mousedown", slideReady);
                /*and another function when the mouse button is released:*/
                window.addEventListener("mouseup", slideFinish);
                /*or touched (for touch screens:*/
                slider.addEventListener("touchstart", slideReady);
                /*and released (for touch screens:*/
                window.addEventListener("touchstop", slideFinish);

                function slideReady(e) {
                    /*prevent any other actions that may occur when moving over the image:*/
                    e.preventDefault();
                    /*the slider is now clicked and ready to move:*/
                    clicked = 1;
                    /*execute a function when the slider is moved:*/
                    window.addEventListener("mousemove", slideMove);
                    window.addEventListener("touchmove", slideMove);
                }

                function slideFinish() {
                    /*the slider is no longer clicked:*/
                    clicked = 0;
                }

                function slideMove(e) {
                    var pos;
                    /*if the slider is no longer clicked, exit this function:*/
                    if (clicked == 0) return false;
                    /*get the cursor's x position:*/
                    pos = getCursorPos(e)
                    /*prevent the slider from being positioned outside the image:*/
                    if (pos < 0) pos = 0;
                    if (pos > w) pos = w;
                    /*execute a function that will resize the overlay image according to the cursor:*/
                    slide(pos);
                }

                function getCursorPos(e) {
                    var a, x = 0;
                    e = e || window.event;
                    /*get the x positions of the image:*/
                    a = img.getBoundingClientRect();
                    /*calculate the cursor's x coordinate, relative to the image:*/
                    x = e.pageX - a.left;
                    /*consider any page scrolling:*/
                    x = x - window.pageXOffset;
                    return x;
                }

                function slide(x) {
                    /*resize the image:*/
                    img.style.width = x + "px";
                    /*position the slider:*/
                    slider.style.left = img.offsetWidth - (slider.offsetWidth / 2) + "px";
                }
            }
        },
        hero: function () {
            var $main = $('.aios-filterable-hero-slider');
            var $thumbnail = $('.aios-filterable-hero-thumbnail');

            if ($main.length) {
                app.beforeAfterSlider();

                $main.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: false,
                    dots: false,
                    arrows: false,
                    swipe: false,
                    asNavFor: $thumbnail
                });
            }

            if ($thumbnail.length) {
                $thumbnail.slick({
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    autoplay: false,
                    dots: false,
                    prevArrow: '.aios-filterable-hero-prev',
                    nextArrow: '.aios-filterable-hero-next',
                    asNavFor: $main,
                    focusOnSelect: true,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 5,
                                slidesToScroll: 1,
                            }
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 1,
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1,
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1,
                            }
                        },
                    ]
                });
            }
        },
        video: function () {
            var target = '.aios-filterable-video-player video';

            if ($(target).length) {
                const $player = new Plyr(target);
            }
        },
        caseSlider: function () {
            var $slider = $('.aios-filterable-case-slider');

            if ($slider.length) {
                $slider.slick({
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    autoplay: false,
                    dots: false,
                    prevArrow: '.aios-filterable-case-prev',
                    nextArrow: '.aios-filterable-case-next',
                    responsive: [
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            }
                        }
                    ]
                });
            }
        },
        others: function () {
            /** Custom Scripts Here */
        },
        init: function () {
            this.hero();
            this.video();
            this.caseSlider();
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