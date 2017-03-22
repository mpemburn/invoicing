/* Support for Invoice Detail page */

var InvoiceDetail = {
    clientSelectList: null,
    clientModal: null,
    invoiceId: 0,
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
