function initImagesSortable() {
    $('body').find("#product-images").sortable({
        update: function (event, ui) {
            var ordering = [];
            $("#product-images > li").each(function () {
                ordering.push($(this).data('id'));
            });
            if (ordering.length) {
                $.ajax({
                    url: $('body').find("#product-images").data('sortable-url'),
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        ordering: ordering
                    }
                });
            }
        }
    });
    $('body').find("#product-images").disableSelection();
}

window.wAjax = (function (window, document, undefined) {
    var wa = Object.create(null),
        b = $('body');

    /**
     * Option for toastr messages
     */
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    /**
     * Method that try to do anything
     * @param options
     * @param form
     */
    wa.start = function (options, form) {
        if (!options) {
            return false;
        }
        $.each(options, function (key, value) {
            if (value.action && wa[value.action] !== undefined) {
                wa[value.action](value, form);
            }
        });
    };

    /**
     * PopUp message success|warning
     * @param options [text, type, time]
     * @returns {boolean}
     */
    wa.message = function (options) {
        if (!options.content) {
            return false;
        }
        var type = options.type || 'default';
        message(options.content, type);
    };

    /**
     * Reset form to start
     * @param options
     * @param form
     */
    wa.reset_form = function (options, form) {
        if (form == undefined){
            form = $(options.selector).length ? $(options.selector): undefined;
        }
        if (form != undefined) {
            form[0].reset();
            form.find('select').trigger('change');
        }
    };

    /**
     * Redirect user to somewhere or reload page
     * @param options
     */
    wa.redirect = function (options) {
        if (window.location.href == options.link) {
            window.location.reload();
        } else {
            window.location.href = options.link;
        }
    };

    /**
     * Insert part of HTML in DOM
     * @param options
     */
    wa.insertion = function (options) {
        if (!options.selector || options.content == undefined) {
            return false;
        }
        var method = options.method || 'html';
        switch (method) {
            case 'counter':
                wAPI.setCounter(options.selector, options.content);
                break;
            case 'prependTo':
            case 'insertAfter':
            case 'insertBefore':
                $(options.content)[method](options.selector);
                break;
            case 'append':
            case 'prepend':
            case 'after':
            case 'before':
            case 'appendTo':
            case 'text':
            case 'html':
            case 'replaceWith':
                $(options.selector)[method](options.content);
                break;
        }
    };

    /**
     * Remove, empty, detach, unwrap element
     * @param options
     * @returns {boolean}
     */
    wa.remove = function (options) {
        if (!options.selector) {
            return false;
        }
        var method = options.method || 'remove';
        switch (method) {
            case 'empty':
            case 'detach':
            case 'unwrap':
            case 'remove':
                b.find(options.selector)[method]();
                break;
            case 'removeWithFade':
                b.find(options.selector).fadeOut(400, function () {
                    b.find(options.selector).remove();
                });
                break;
        }
    };

    /**
     * Manipulations with attributes
     * @param options
     * @returns {boolean}
     */
    wa.attributes = function (options) {
        if (!options.selector || options.value === undefined) {
            return false;
        }
        var method = options.method || 'toggleClass';
        switch (method) {
            case 'addClass':
            case 'removeAttr':
            case 'removeClass':
            case 'toggleClass':
            case 'height':
            case 'width':
                $(options.selector)[method](options.value);
                break;
            case 'attr':
            case 'prop':
            case 'data':
                $(options.selector)[method](options.attribute, options.value);
                break;
        }
    };

    /**
     * Styles to element
     * @param options
     * @returns {boolean}
     */
    wa.css = function (options) {
        if (!options.selector || !options.styles) {
            return false;
        }
        $(options.selector).css(options.styles);
    };

    /**
     * Trigger element
     * @param options
     * @returns {boolean}
     */
    wa.trigger = function (options) {
        if (!options.selector || !options.trigger) {
            return false;
        }

        if(options.trigger == 'click') {
            $(options.selector).click();
        } else if(options.trigger == 'magnificClick'){
            setTimeout(function(){
                $(options.selector).click();
            }, 500);
        } else {
            $(options.selector).trigger(options.trigger);
        }
    };

    /**
     * Hide, show, toggle
     * @param options
     * @returns {boolean}
     */
    wa.visibility = function (options) {
        if (!options.selector) {
            return false;
        }
        var method = options.method || 'toggle';
        var duration = options.time || 'slow';
        switch (method) {
            case 'hide':
            case 'show':
            case 'toggle':
                b.find(options.selector)[method]();
                break;
            case 'fadeIn':
            case 'fadeOut':
            case 'fadeToggle':
            case 'slideUp':
            case 'slideDown':
            case 'slideToggle':
                b.find(options.selector)[method](duration);
                break;
        }
    };

    /**
     * Animation
     * @param options
     * @returns {boolean}
     */
    wa.animate = function (options) {
        if (!options.selector) {
            return false;
        }
        var config = options.config || {};
        var time = options.time || 500;
        b.find(options.selector).animate(config, time, function () {});
    };

    /**
     * Init plugins
     * @param options
     */
    wa.init = function (options) {
        if (options.plugin === 'image-sortable') {
            if (options.timeout) {
                setTimeout(function () {
                    initImagesSortable();
                }, options.timeout);
            } else {
                initImagesSortable();
            }
        }
    };

    /**
     * Magnific popup
     * @param options
     */
    wa.magnific = function (options) {
        var method = options.method || 'close';
        switch (method) {
            case 'close':
                $.magnificPopup.close();
                break;

            case 'open':
                setTimeout(function () {
                    $.magnificPopup.open({
                    items: [{
                        src: options.content, // can be a HTML string, jQuery object, or CSS selector
                        type: 'inline'
                    }],
                    fixedContentPos: false,
                    fixedBgPos: true,
                    overflowY: 'auto',
                    closeBtnInside: true,
                    preloader: false,
                    midClick: true,
                    removalDelay: 300,
                    mainClass: 'my-mfp-slide-bottom my-mfp-popup',
                    callbacks: {
                        open: function() {
                            // wHTML.validation();
                            // wAPI.checkForDatapickers();
                            // datepickInit('.js-datetimepicker-popup');
                        }
                    }
                });
            },350);
        break;
    }
    };

    /**
     * Console log
     * @param options
     */
    wa.log = function (options) {
        console.log(options.content);
    };

    return wa;
})(this, this.document);