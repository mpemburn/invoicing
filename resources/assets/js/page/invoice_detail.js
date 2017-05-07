/* Support for Invoice Detail page */


var InvoiceLineitem = {
    invoiceId: 0,
    lineitemModal: null,
    selectedLineitemId: 0,
    numeric: null,
    init: function (options) {
        $.extend(this, options);

        this.numeric = Object.create(Numeric);
        this._setEvents();
    },
    _initLineitemModal: function () {
        var self = this;
        this.lineitemModal = $('#lineitem_modal');
        this.lineitemModal.modal();
    },
    _calculateAmount: function () {
        var billing_rate = $('#billing_rate_id option:selected').text();
        var hours = $('#hours').val();
        var amount = 0;
        if (billing_rate && hours) {
            amount = (parseFloat(billing_rate) * parseFloat(hours));
        }
        $('#amount').val(amount.toFixed(2));
        $('#amount_display').html(this.numeric.toDollar(amount.toFixed(2)));
    },
    _clearForm: function () {
        $('#update_lineitem').each(function () {
            $(this).find('input, select, textarea').val('');
        });
        this._calculateAmount();
    },
    _hydrateLineitem: function (data) {
        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                var value = (data[key] != null) ? data[key] : '';
                var $field = $('#' + key);
                if ($field.length > 0) {
                    $field.val(value);
                }
            }
        }
    },
    _retrieveLineitem: function (lineitemId) {
        var self = this;
        this.selectedLineitemId = lineitemId;
        if (lineitemId != 0) {
            $.ajax({
                type: "GET",
                url: appSpace.baseUrl + '/invoice/get_lineitem/' + appSpace.invoiceId + '/' + lineitemId,
                dataType: 'json',
                success: function (response) {
                    self._hydrateLineitem(response.data);
                    self._calculateAmount();
                    self._initLineitemModal();
                },
                error: function (response) {
                    var foo = 'bar';
                }
            });
        } else {
            this._clearForm();
            this._setupNewLineitem();
            this._initLineitemModal();
        }
    },
    _saveLineitem: function() {
        $.ajax({
            type: "GET",
            url: appSpace.baseUrl + '/invoice/update_lineitem',
            data: $('form[name=update_lineitem]').serialize(),
            dataType: 'json',
            success: function (response) {
                var foo = 'bar';
                //self._hydrateLineitem(response.data);
                //self._calculateAmount();
                //self._initLineitemModal();
            },
            error: function (response) {
                var foo = 'bar';
            }
        });
    },
    _setEvents: function () {
        var self = this;
        $('#lineitem_add').on('click', function () {
            self._retrieveLineitem(0);
        });

        $('#lineitem_save').on('click', function () {
            if (self.selectedLineitemId != null) {
                self._saveLineitem();
            }
        });

        $('tr.lineitem').on('click', function () {
            var itemId = $(this).attr('data-id');
            self._retrieveLineitem(itemId);
        });

        $('#billing_rate_id, #hours').on('change keyup', function () {
            self._calculateAmount();
        });

    },
    _setupNewLineitem: function() {
        $('#id').val('0');
        $('#invoice_id').val(this.invoiceId);
    }
};

var InvoiceDetail = {
    itemManager: null,
    clientSelectList: null,
    clientModal: null,
    invoiceId: 0,
    dateItem: null,
    detailsUrl: '',
    updateUrl: '',
    selectedClientId: 0,
    init: function (options) {
        $.extend(this, options);
        // Instantiate the lineitem manager
        this.itemManager = Object.create(InvoiceLineitem);
        this.itemManager.init({ 'invoiceId': this.invoiceId });

        this._initClientTable();
        // Auto-display the client modal if this is a new invoice
        if (this.invoiceId == 0) {
            this._initClientModal();
        }
        this._setEvents();
    },
    _initClientTable: function () {
        var self = this;
        this.clientSelectList = $('#select_client_list').DataTable({
            iDisplayLength: 10, // Default to this number per page
            aaSorting: [],
            fnDrawCallback: function () {
                self._selectClientEvent();
                // Hide pagination buttons of only one page is showing
                var $paginates = $('.dataTables_paginate').find('.paginate_button');
                $('.dataTables_paginate').toggle($paginates.length > 3);
            },
            initComplete: function () {
                var $search = $($(this).selector + '_filter').find('input[type="search"]');
                // Add 'clearable' x to search field, and callback to restore table on clear
                $search.addClass('clearable').clearable({
                    onClear: function () {
                        // Refresh table
                        self.clientSelectList.search('').columns().search('').draw();
                    }
                });
                $('#select_client_list_length').hide();
            }
        });
    },
    _initClientModal: function () {
        var self = this;
        this.clientModal = $('#client_selector');
        this.clientModal.modal();
    },
    _hideDates: function () {
        var self = this;
        $('[data-datetype]').each(function () {
            if (this != self.dateItem) {
                $(this).find('div').show();
                $(this).find('input').hide();
            }
        });

    },
    _hydrateClient: function (data) {
        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                var value = (data[key] != null) ? data[key] : '';
                var $field = $('#' + key);
                if (value.length != 0) {
                    $field.html(value)
                        .removeClass('hidden')
                        .show();
                }
            }
        }
    },
    _retrieveClient: function () {
        var self = this;
        if (this.selectedClientId != null) {
            $.ajax({
                type: "GET",
                url: appSpace.baseUrl + '/invoice/set_client/' + appSpace.invoiceId + '/' + this.selectedClientId,
                dataType: 'json',
                success: function (response) {
                    if (response.client_info) {
                        self._hydrateClient(response.client_info);
                    }
                    // If this is a new invoice, reload
                    if (response.invoice_id) {
                        document.location = self.detailsUrl + response.invoice_id;
                    }
                },
                error: function (response) {
                    var foo = 'bar';
                }
            })
        }
    },
    _saveData: function () {
        $.ajax({
            type: "GET",
            url: this.updateUrl,
            data: $('form[name=details_form]').serialize(),
            dataType: 'json',
            success: function (response) {
                var foo = 'bar';
            },
            error: function (response) {
                var foo = 'bar';
            }
        })
    },
    _setEvents: function () {
        var self = this;
        this._selectClientEvent();

        $('#edit_client').on('click', function () {
            self._initClientModal();
        });

        $('#select_client').on('click', function () {
            if (self.selectedClientId != null) {
                self._retrieveClient();
            }
        });

        this._setupDatepickers();
    },
    _selectClientEvent: function () {
        var self = this;
        $('.client_row').on('click', function () {
            $('.client_row').removeClass('selected');
            self.selectedClientId = $(this).attr('data-id');
            $(this).addClass('selected');
            $('.btn-primary').attr('data-dismiss', 'modal');
        });
    },
    _setupDatepickers: function () {
        var self = this;

        $('[data-datetype]').on('click', function () {
            var $dateItem = $(this).find('div');
            var $dateInput = $(this).find('input');
            var isVisible = $dateInput.is(':visible');
            // Hide dates except for the current one
            self.dateItem = this;
            self._hideDates();
            // Toggle visibility of just this date item
            $dateItem.toggle(isVisible);
            $dateInput.toggle(!isVisible);
            $dateInput.datepicker({
                    format: 'm/d/yyyy',
                    showClose: true,
                })
                .on('changeDate', function () {
                    // Write the value from the input to the div
                    var $dateItem = $(this).prev('div');
                    var $dateInput = $(this);
                    $dateItem.html($dateInput.val())
                        .show();
                    $dateInput.hide();
                    $(this).datepicker('hide');
                    appSpace.invoiceDetail._saveData();
                })
                .focus();
            if (!isVisible) {
                $dateInput.attr('readonly', 'readonly');
            } else {
                $dateInput.attr('readonly', 'readonly');
            }
        });
        // Override the click behavior
        $('[data-datetype] input').on('click', function (evt) {
            evt.preventDefault();
            return false;
        });
    }
};

$(document).ready(function ($) {
    if ($('#select_client_list').is('*')) {
        appSpace.invoiceDetail = Object.create(InvoiceDetail);
        appSpace.invoiceDetail.init({
            invoiceId: appSpace.invoiceId,
            detailsUrl: appSpace.baseUrl + '/invoice/details/',
            updateUrl: appSpace.baseUrl + '/invoice/update/'
        });
    }
});
