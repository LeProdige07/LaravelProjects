<div class="modal fade" id="ModalShow{{ $client->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Détails de l'utilisateur</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Name') }}:</strong>
                        {{ $client->name }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Email') }}:</strong>
                        {{ $client->email }}
                    </div>
                </div>
                {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Roles') }}:</strong>
                        <label class="badge badge-success">{{ $client->getRolesclient() }}</label>
                    </div>
                </div> --}}
            </div>
            <!-- .col-md-12 -->
        </div>
    </div>
</div>

