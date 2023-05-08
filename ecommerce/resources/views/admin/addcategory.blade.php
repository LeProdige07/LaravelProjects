{!! Form::open(['action' => 'App\Http\Controllers\CaterogyController@savecategory', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
@csrf
<div class="modal fade text-left" id="ModalCreate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Création de la catégorie</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Nom') }}:</strong>
                        {!! Form::text('category_name', null, ['placeholder' => 'Category Name', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn gray btn-outline-secondary"
                    data-dismiss="modal">{{ __('quitter') }}</button>
                <button type="submit" class="btn btn-success">{{ __('Ajouter') }}</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
<!-- .container-fluid -->
{!! Form::open(['action' => 'App\Http\Controllers\RoleController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
@csrf
<div class="modal fade text-left" id="ModalCreate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Création du role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Nom') }}:</strong>
                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn gray btn-outline-secondary"
                    data-dismiss="modal">{{ __('quitter') }}</button>
                <button type="submit" class="btn btn-success">{{ __('Ajouter') }}</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
<!-- .container-fluid -->
