<div id="client_selector" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Select Client</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body client-modal">
                <table id="select_client_list">
                    <thead>
                        <tr>
                            <td width="10%">ID</td>
                            <td width="40%">Client</td>
                            <td width="50%">Company</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $client)
                        <tr class="client_row" data-id="{{ $client->id }}">
                            <td>{{ $client->id }}</td>
                            <td>{{ $client->full_name }}</td>
                            <td>{{ $client->company }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Select</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>