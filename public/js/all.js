/**
 * jquery.clearable.js
 *
 * Adapted from http://stackoverflow.com/questions/6258521/clear-icon-inside-input-text
 * Requires the following CSS:
 .clearable {
        background: #fff url(data:image/gif;base64,R0lGODlhBwAHAIAAAP///5KSkiH5BAAAAAAALAAAAAAHAAcAAAIMTICmsGrIXnLxuDMLADs=) no-repeat right -10px center;
        border: 1px solid #999;
        padding: 3px 24px 3px 4px; // Second value must match settings.offset
        border-radius: 3px;
    }
 .clearable.x  { background-position: right 10px center; }
 .clearable.onX{ cursor: pointer; }
 .clearable::-ms-clear {display: none; width:0; height:0;}

 */

(function ($) {
    $.fn.clearable = function (options) {
        var settings = $.extend({
            animate: false,
            offset: 24, // Pixels of offset from right end of input
            // Optional callbacks
            onInput: function() {},
            onClear: function() {}
        }, options);

        // Add class to target if not present
        this.addClass('clearable');
        // Events
        this.on('input', function (evt) {
            if (settings.animate) {
                $(this).css({ transition: 'background 0.4s' })
            }
            $(this)[_toggle(this.value)]('x');
            settings.onInput($(this));
        }).on('mousemove', function(evt){
            $(this)[_toggle(_isOnX(evt))]('onX');
        }).on('touchstart click', function(evt){
            evt.preventDefault();
            if (_isOnX(evt)) {
                settings.onClear($(this));
                $(this).removeClass('x onX').val('').change();
            }
        });

        // Determine whether user's mouse is over the 'X'
        function _isOnX(evt) {
            return (evt.target.offsetWidth - settings.offset) < (evt.clientX - evt.target.getBoundingClientRect().left);
        }

        // Add or remove classes based on value
        function _toggle(value) {
            return value ? 'addClass' : 'removeClass';
        }

        return this;
    };


}(jQuery));
/* Support for Invoice list page */
$(document).ready(function ($) {
    if ($('.invoice-list').is('*')) {
        $('.invoice-list tbody tr').on('click', function () {
            var id = $(this).attr('data-id');
            document.location = appSpace.baseUrl + '/invoice/details/' + id;
        });

        var mainInvoiceList = $('#main_invoice_list').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]], // Number of entries to show
            iDisplayLength: 25, // Default to this number per page
            aaSorting: [],
            fnDrawCallback: function() {
                // Hide pagination buttons of only one page is showing
                var $paginates = $('.dataTables_paginate').find('.paginate_button');
                $('.dataTables_paginate').toggle($paginates.length > 3);
            },
            initComplete: function () {
                var $search = $($(this).selector + '_filter').find('input[type="search"]');
                // Add 'clearable' x to search field, and callback to restore table on clear
                $search.addClass('clearable').clearable({
                    onClear: function() {
                        // Refresh table
                        mainInvoiceList.search( '' ).columns().search( '' ).draw();
                    }
                });

            }
        });
    }
});

/*
* app.js
*
* Custom Javascript code used throughout the application
*
*/

//# sourceMappingURL=all.js.map
