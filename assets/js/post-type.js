(function ($) {
    $(document).ready(function () {

        function __construct() {
            deslect_radio();
            auto_title();
            permalink_changer();
        }


		function deslect_radio() {
			var radioButtons = $("input[type='radio']");
			var radioStates = {};
			$.each(radioButtons, function(index, rd) {
				radioStates[rd.value] = $(rd).is(':checked');
			});

			radioButtons.click(function() {

				var val = $(this).val();
				$(this).attr('checked', (radioStates[val] = !radioStates[val]));

				$.each(radioButtons, function(index, rd) {
					if(rd.value !== val) {
						radioStates[rd.value] = false;
					}
				});
			});
		}

        function permalink_changer() {
            $oldTitle = $('#title').val();
            
            $('#publishing-action #publish').on('click', function (e) {
                // New Title Value
                $newTitle = $('#title').val();
                
                if ( $newTitle != $oldTitle ) {
                    // Trigger edit button on permalink
                    $edit = $('.edit-slug');
                    $edit.trigger('click');

                    // Gets edit elements after click
                    $ok = $('#edit-slug-buttons .save.button');
                    $input = $('#new-post-slug');

                    // replace old permalink with the title value
                    $input.val($newTitle);

                    // saves the new permalink
                    $ok.trigger('click');
                }
            });
        }

        function auto_title() {

            $title = $('#title');
            $case_number = $('#acf-field_5f0cd64365929');


            $case_number.on('change', function () {

                $case_val = $(this).val();

                $title.val($case_val);

            });




        }

        /** Instantiate */
        __construct();

    });
})(jQuery);
