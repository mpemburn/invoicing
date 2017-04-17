<div id="lineitem_modal" class="lineitem-modal modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Line Item</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body lineitem-modal">
                <header id="lineitem_header">
                    {{ Form::open(array('url' => 'foo/bar')) }}
                    {{ Form::hidden('invoice_id', (!is_null($invoice->id)) ? $invoice->id : '0')}}
                    {{ Form::hidden('id', null)}}
                    {{ Form::hidden('item_number', null)}}
                    <div class="">
                        <label for="transaction_type" class="col-md-1 text-right control-label">Type</label>
                        {{ Form::select('transaction_type', $transactions, null, ['class' => 'col-md-2'])}}
                        <label for="service_type" class="col-md-2 text-right control-label">Service</label>
                        {{ Form::select('service_type', $services, null, ['class' => 'col-md-3'])}}
                        <label for="hours" class="col-md-2 text-right control-label">Hours</label>
                        {{ Form::text('hours', null, ['class' => 'col-md-1 required']) }}
                    </div>
                    {{ Form::close()}}
                </header>
                <article>
                    {{ Form::textarea('description', null, ['id' => 'lineitem_description', 'class' => 'col-md-12']) }}
                </article>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>