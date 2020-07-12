(function ($) {
    $(document).ready(function () {

        function __construct() {
            deslect_radio();
            //auto_title();
            // auto_generateCase();
            // permalink_changer();
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
            $label = $('#title-prompt-text');
            $case_number = $('[data-name="case_number"] input');
            $procedure = $('[name="tax_input[procedure][]"]');

            $procedure.on('change', function () {

                $procedureVal = $(this).parent().text();

                $title.val($procedureVal + ':' + $case_number.val());

                if ($title.val() != '') {
                    $label.addClass('screen-reader-text');
                } else {
                    $label.removeClass('screen-reader-text');
                }
            });

            $case_number.on('input', function () {

                $case_numberVal = $(this).val();

                $title.val(''+ $('[name="tax_input[procedure][]"]:checked').parent().text() +':'+ $case_numberVal+' ');


            });

        }

        function auto_generateCase() {

            $case_number = jQuery('[data-name="case_number"] input');
            console.log($case_number.val());
            var a = Math.floor(1000000 + Math.random() * 9000000);
            a = String(a);
            a = a.substring(0, 8);
            if ($case_number.val() == '') {
                $case_number.val(a);
            }


        }


        /** Instantiate */
        __construct();

    });
})(jQuery);
