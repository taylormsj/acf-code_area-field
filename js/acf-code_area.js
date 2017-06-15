(function ($) {

    function initialize_field($el) {

        var $element = $($el).find('textarea');
        if ($element.length === 0) return false;

        var lang = $element.attr('data-language'),
            theme = $element.attr('data-theme');

        var editor = CodeMirror.fromTextArea($element[0], {
            lineNumbers: true,
            styleActiveLine: true,
            autoCloseTags: true,
            tabmode: 'indent',
            matchTags: {bothTags: true},
            mode: lang,
            theme: theme,
            viewportMargin: Infinity,
            tabSize: 4,
            indentUnit: 4,
            indentWithTabs: true,
            showTrailingSpace: true,
            lineWrapping: true,
            extraKeys: {
                "Ctrl-J": "toMatchingTag",
                "F11": function (cm) {
                    cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                },
                "Esc": function (cm) {
                    if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                },
                "Ctrl-Space": "autocomplete",
                "Alt-F": "findPersistent"
            }
        });


    }

    if (typeof acf.add_action !== 'undefined') {

        /*
         *  ready append (ACF5)
         *
         *  These are 2 events which are fired during the page load
         *  ready = on page load similar to $(document).ready()
         *  append = on new DOM elements appended via repeater field
         *
         *  @type	event
         *  @date	20/07/13
         *
         *  @param	$el (jQuery selection) the jQuery element which contains the ACF fields
         *  @return	n/a
         */

        acf.add_action('ready append', function ($el) {

            acf.get_fields({type: 'code_area'}, $el).each(function () {

                initialize_field($(this));

            });

        });


    } else {


        /*
         *  acf/setup_fields (ACF4)
         *
         *  This event is triggered when ACF adds any new elements to the DOM.
         *
         *  @type	function
         *  @since	1.0.0
         *  @date	01/01/12
         *
         *  @param	event		e: an event object. This can be ignored
         *  @param	Element		postbox: An element which contains the new HTML
         *
         *  @return	n/a
         */

        $(document).on('acf/setup_fields', function (e, postbox) {
            $(postbox).find('.field[data-field_type="code_area"]').each(function () {
                initialize_field($(this));
            });
        });

    }

})(jQuery);