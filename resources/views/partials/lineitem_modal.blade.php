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
                {{ Form::model($invoice, array('route' => array('update.lineitem', $invoice->id, 0), 'name' => 'update_lineitem', 'id' => 'update_lineitem')) }}
                <header id="lineitem_header">
                    {{ Form::hidden('invoice_id', (!is_null($invoice->id)) ? $invoice->id : '0', ['id' => 'invoice_id'])}}
                    {{ Form::hidden('id', 0, ['id' => 'id'])}}
                    {{ Form::hidden('item_number', 0, ['id' => 'item_number'])}}
                    <div class="col-md-12">
                        <label for="transaction_type" class="col-md-1 text-right control-label">Type</label>
                        {{ Form::select('transaction_type', $transactions, null, ['class' => 'col-md-2', 'id' => 'transaction_type'])}}
                        <label for="service_type" class="col-md-2 text-right control-label">Service</label>
                        {{ Form::select('service_type', $services, null, ['class' => 'col-md-3', 'id' => 'service_type'])}}
                    </div>
                    <div class="col-md-12">
                        <label for="billing_rate" class="col-md-1 text-right control-label">Rate</label>
                        {{ Form::select('billing_rate_id', $billing_rates, null, ['class' => 'col-md-2', 'id' => 'billing_rate_id'])}}
                        <label for="hours" class="col-md-2 text-right control-label">Hours</label>
                        {{ Form::text('hours', null, ['class' => 'col-md-1 required', 'id' => 'hours']) }}
                        <label for="amount" class="col-md-3 col-md-push-1 text-right control-label">Amount</label>
                        <div id="amount_display" class="col-md-2 col-md-push-1 text-bold"></div>
                        {{ Form::hidden('amount', null, ['id' => 'amount']) }}
                    </div>
                </header>
                <article>
                    {{ Form::textarea('description', null, ['class' => 'col-md-12', 'id' => 'description']) }}
                </article>
                {{ Form::close()}}
            </div>
            <div class="modal-footer">
                <button id="lineitem_save" type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>