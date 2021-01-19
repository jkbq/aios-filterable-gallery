;( function($, w, d, h, b) {
	var app = {

		beforeAfterSlider: function () {
            var _this = this;

            _this.resizeItem = function ($guide, $target) {
                $target.css({
                    width: $guide[0].getBoundingClientRect().width + 'px',
                });
            }

            _this.slider = function () {
                var $sliders = $('.ba-slider');


                $sliders.each(function (i, v) {
                    var $slider = $(v);
                    
                    var $before = $slider.find('.ba-col.before');
                    var $after = $slider.find('.ba-col.after');

                    _this.resizeItem($after.find('.ba-item'), $before.find('.ba-item'));

                    $(w).on('load resize orientationchange', function () {
                    	  setTimeout(function () {

                        _this.resizeItem($after.find('.ba-item'), $before.find('.ba-item'));
                          console.log("The orientation has changed!");
    }, 200);
                    });
                });
            }

            _this.handler = function () {
                var $range = $('.ba-range input');

                $range.on('input change', function () {
                    var $this = $(this);
                    var value = $this.val();
                    var $parentWrapper = $this.parents('.ba-slider-wrap');

                    var $before = $parentWrapper.find('.ba-col.before');
                    $before.css({
                        width: value + '%',
                    });

                    var $handler = $parentWrapper.find('.ba-handler');
                    $handler.css({
                        left: value + '%',
                    });
                });
            }

			_this.handler();
			_this.slider();
        },
		aios_ion_slider: function() {
			$(".js-range-slider").ionRangeSlider({
				 skin: "round",
				  onChange: function (data) {
					$('#age').val(''+data['from']+','+data['to']+'');
				}
			});
		},

		aios_render_cases: function() {
				$.post( ajaxurl, {
					'action' 	: 'aios_medical_post_filter',
					'data'		: jQuery('.aios-gallery-form input').filter(function () {
							return !!this.value;
						}).serialize(),
				}, function(response) {
					$('.aios-gallery-lists .row').append(response);
					$('#loader').fadeOut();
					$('.aios-gallery-lists .row').animate({
						opacity: 1,
					});
					app.beforeAfterSlider();
					jQuery('.aios-gallery-list-wrap').slick({
						dots: true,
						infinite: false,
						speed: 300,
						swipe: false,
						slidesToShow: 1,
						slidesToScroll: 1,
					});

				} ).done( function() {

				} );

		},
		aios_search_func: function () {
			let button = $('.aios-gallery-submit-bttn input');

			button.on('click', function (e) {
				e.preventDefault();
				e.stopPropagation();
				$('#loader').fadeIn();
				$('.aios-gallery-lists .row').empty();
				app.aios_render_cases();
			});
		},
		aios_sort: function () {

			sort = $('.aios-sort-by select');

			sort.on('change', function () {

					$('#loader').fadeIn();
					$('.aios-gallery-lists .row').empty();
					$('input[name="sorts"]').val($(this).val());
					app.aios_render_cases();
			})
		},
		 aios_pagination: function() {

			  var current = $(".aios-gallery-numbers").text();

				  $(".aios-gallery-pagination-prev").on("click", function() {
					current = current - 1;
					$(".aios-gallery-numbers").text(current);
					$('#loader').fadeIn();
					$('.aios-gallery-lists .row').empty();
					$('#paginate-value').val(current);
					app.aios_render_cases();
				  });
				  $(".aios-gallery-pagination-next").on("click", function() {
						current = parseInt(current) + parseInt(1);
						$(".aios-gallery-numbers").text(current);
						$('#loader').fadeIn();
						$('.aios-gallery-lists .row').empty();
						$('#paginate-value').val(current);
						app.aios_render_cases();
				  });


		},
		taxonomy_quick_search: function () {

			taxonomy 	= $('.aios-toxonomy-quick-search input');
			procedure	= $('input[name="procedure"]');

			 taxonomy.click(function () {
				$("[name="+$(this).prop('name')+"]").prop("checked", false);
				$(this).prop("checked", true);
				$('#loader').fadeIn();
				$('.aios-gallery-lists .row').empty();

				if ($(this).is(':checked')) {
					procedure.val($(this).val());

				}else{
						procedure.val('');
				}
				app.aios_render_cases();
			});

		},

        others: function () {
            /** Put your uncategorized functions/scripts here */
        },
		init: function() {
			this.beforeAfterSlider();
			this.aios_ion_slider();
			this.aios_render_cases();
			this.aios_search_func();
			this.aios_sort();
			this.aios_pagination();
			this.taxonomy_quick_search();


		},
	}

	$(document).ready( function() {
        /* Initialize all app functions */
        app.init();
	});

    /**
    *
    * Please do add your custom script functions similar to the current file structure.
    * You may also add your uncategorized script functions inside the `app.others` function.
    *
    */
})(jQuery, window, document, 'html', 'body');