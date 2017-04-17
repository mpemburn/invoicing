/* Support for Invoice Detail page */

var InvoiceDetail = {
    clientSelectList: null,
    clientModal: null,
    lineitemModal: null,
    invoiceId: 0,
    dateItem: null,
    detailsUrl: '',
    updateUrl: '',
    selectedClientId: 0,
    selectedLineitemId: 0,
    init: function (options) {
        $.extend(this, options);

        this.initClientTable();
        // Auto-display the client modal if this is a new invoice
        if (this.invoiceId == 0) {
            this.initClientModal();
        }
        //this.initLineitemModal();
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
        this.clientModal = $('#client_selector');
        this.clientModal.modal().on('hidden.bs.modal', function () {
            if (self.selectedClientId != null) {
                self.retrieveClient();
            }
        });
    },
    initLineitemModal: function() {
        var self = this;
        this.lineitemModal = $('#lineitem_modal');
        this.lineitemModal.modal()
            .on('hidden.bs.modal', function () {
                if (self.selectedLineitemId != null) {
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
    retrieveLineitem: function() {
        var self = this;
        if (this.selectedLineitemId != null) {
            $.ajax({
                type: "GET",
                url: appSpace.baseUrl + '/invoice/get_lineitem/' + appSpace.invoiceId + '/' + this.selectedLineitemId,
                dataType: 'json',
                success: function (response) {
                    self.initLineitemModal();
                },
                error: function (response) {
                    var foo = 'bar';
                }
            })
        }
    },
    saveData: function() {
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
    setEvents: function() {
        var self = this;
        this.selectClientEvent();

        $('#edit_client').on('click', function() {
            self.initClientModal();
        });

        $('#lineitem_add').on('click', function() {
            self.retrieveLineitem();
        });

        this.setupDatepickers();
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
    setupDatepickers: function() {
        var self = this;

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
                    appSpace.invoiceDetail.saveData();
                })
                .focus();
            if (!isVisible) {
                $dateInput.attr('readonly', 'readonly');
            } else {
                $dateInput.attr('readonly', 'readonly');
            }
        });
        // Override the click behavior
        $('[data-datetype] input').on('click', function(evt) {
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
