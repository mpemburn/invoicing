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
