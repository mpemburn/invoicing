<div id="top_line">{{ $client->top_line }}</div>
<div id="address_1">{{ $client->address_1 }}</div>
<div id="address_2" class="{{ empty($client->address_2) ? 'hidden' : '' }}">{{ empty($client->address_2) ? '' : $client->address_2 }}</div>
<div id="city_state_zip">{{ $client->city_state_zip }}</div>
<div id="attention" class="attn {{ empty($client->attention) ? 'hidden' : '' }}">{{ empty($client->attention) ? '' : $client->attention }}</div>
<div id="project" class="project {{ empty($client->project) ? 'hidden' : '' }}">{{ empty($invoice->project) ? '' : 'Project: ' . $invoice->project }}</div>
