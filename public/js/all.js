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
/* Support for Invoice Detail page */

var InvoiceDetail = {
    clientSelectList: null,
    clientModal: null,
    invoiceId: 0,
    dateItem: null,
    detailsUrl: '',
    selectedClientId: null,
    init: function (options) {
        $.extend(this, options);

        this.clientModal = $('#client_selector');
        this.initClientTable();
        // Auto-display the client modal if this is a new invoice
        if (this.invoiceId == 0) {
            this.initClientModal();
        }
        this.setEvents();
    },
    initClientTable: function() {
        var self = this;
        this.clientSelectList = $('#select_client_list').DataTable({
            iDisplayLength: 10, // Default to this number per page
            aaSorting: [],
            fnDrawCallback: function() {
                self.selectClientEvent();
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
                        self.clientSelectList.search( '' ).columns().search( '' ).draw();
                    }
                });
                $('#select_client_list_length').hide();
            }
        });
    },
    initClientModal: function() {
        var self = this;
        this.clientModal.modal().on('hidden.bs.modal', function () {
            if (self.selectedClientId != null) {
                self.retrieveClient();
            }
        });
    },
    hideDates: function() {
        var self = this;
        $('[data-datetype]').each(function() {
            if (this != self.dateItem) {
                $(this).find('div').show();
                $(this).find('input').hide();
            }
        });

    },
    hydrateClient: function(data) {
        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                var value = (data[key] != null) ? data[key] : '';
                var $field = $('#' + key);
                $field.hide();
                if (value.length != 0) {
                    $field.html(value)
                        .removeClass('hidden')
                        .show();
                }
            }
        }
    },
    retrieveClient: function() {
        var self = this;
        if (this.selectedClientId != null) {
            $.ajax({
                type: "GET",
                url: appSpace.baseUrl + '/invoice/set_client/' + appSpace.invoiceId + '/' + this.selectedClientId,
                dataType: 'json',
                success: function (response) {
                    if (response.client_info) {
                        self.hydrateClient(response.client_info);
                    }
                    // If this is a new invoice, reload
                    if (response.invoice_id) {
                        document.location = self.detailsUrl +  response.invoice_id;
                    }
                },
                error: function (response) {
                    var foo = 'bar';
                }
            })
        }
    },
    setEvents: function() {
        var self = this;
        this.selectClientEvent();

        $('#edit_client').on('click', function() {
            self.initClientModal();
        });

        $('[data-datetype]').on('click', function() {
            var $dateItem = $(this).find('div');
            var $dateInput = $(this).find('input');
            var isVisible = $dateInput.is(':visible');
            // Hide dates except for the current one
            self.dateItem = this;
            self.hideDates();
            // Toggle visibility of just this date item
            $dateItem.toggle(isVisible);
            $dateInput.toggle(!isVisible);
            $dateInput.datepicker()
                .on('changeDate', function () {
                    // Write the value from the input to the div
                    var $dateItem = $(this).prev('div');
                    var $dateInput = $(this);
                    $dateItem.html($dateInput.val())
                        .show();
                    $dateInput.hide();
                    $(this).datepicker('hide');
                })
                .focus();
        });
        $('[data-datetype] input').on('click', function(evt) {
            evt.preventDefault();
            return false;
        });
    },
    selectClientEvent: function() {
        var self = this;
        $('.client_row').on('click', function () {
            $('.client_row').removeClass('selected');
            self.selectedClientId = $(this).attr('data-id');
            $(this).addClass('selected');
            $('.btn-primary').attr('data-dismiss','modal');
        });
    },
};

$(document).ready(function ($) {
    if ($('#select_client_list').is('*')) {
        var invoiceDetail = Object.create(InvoiceDetail);
        invoiceDetail.init({
            invoiceId: appSpace.invoiceId,
            detailsUrl: appSpace.baseUrl + '/invoice/details/'
        });
    }
});

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
