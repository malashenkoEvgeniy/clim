<script>
    jQuery(document).ready(function() {
        $("<?php echo $validator['selector']; ?>").validate({
            errorElement: 'span',
            errorClass: 'help-block error-help-block',
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length ||
                    element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                    error.appendTo(element.closest('.form-group'));
                    // else just place the validation message immediatly after the input
                } else {
                    error.insertAfter(element);
                }
            },

            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
                var $block = $(element).closest('.nav-tabs-custom');
                if ($block.length) {
                    var index = $(element).closest('.tab-pane').index();
                    $block.find('.nav-tabs').children().eq(index).addClass('has-errors');
                }
            },

            // Uncomment this to mark as validated non required fields
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                var $block = $(element).closest('.nav-tabs-custom');
                if ($block.length) {
                    var $tab = $(element).closest('.tab-pane');
                    if ($tab.find('.has-error').length === 0) {
                        var index = $tab.index();
                        $block.find('.nav-tabs').children().eq(index).removeClass('has-errors');
                    }
                }
            },

            <?php if (isset($validator['ignore']) && is_string($validator['ignore'])): ?>
                ignore: "<?php echo $validator['ignore']; ?>",
            <?php else: ?>
                ignore: "[type=hidden]",
            <?php endif; ?>

            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
            },

            focusInvalid: false, // do not focus the last invalid input
            <?php if (Config::get('jsvalidation.focus_on_error')): ?>
                invalidHandler: function(form, validator) {

                    if (!validator.numberOfInvalids())
                        return;

                    $('html, body').animate({
                        scrollTop: $(validator.errorList[0].element).offset().top
                    }, <?php echo Config::get('jsvalidation.duration_animate') ?>);
                    $(validator.errorList[0].element).focus();

                },
            <?php endif; ?>

            rules: <?php echo json_encode($validator['rules']); ?>,
            
            submitHandler: function(form) {
                if ($(form).hasClass('ajax-form')) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize()
                    });
                    return false;
                }
                return true;
            }
        });
    });
</script>
