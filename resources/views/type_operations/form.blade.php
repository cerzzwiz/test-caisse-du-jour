@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __($page_title ?? 'Créer un type d\'opération') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ $url }}">
                        @csrf
                        @if(isset($method))
                            @method("PUT")
                        @endif
                        <div class="row mb-3">
                            <label for="designation" class="col-md-4 col-form-label text-md-end">{{ __('Désignation') }}</label>

                            <div class="col-md-6">
                                <input id="designation" type="text" class="form-control" name="designation" value="{{ old('designation', isset($object) ? $object->designation : '') }}">

                                @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="action" class="col-md-4 col-form-label text-md-end">{{ __('Action') }}</label>

                            <div class="col-md-6">

                                <select name="action" id="action" class="form-control">
                                    <option value="1" {{ (isset($object) && $object->action == 1)? "selected" : '' }}>Ajoute à la caisse</option>
                                    <option value="2" {{ (isset($object) && $object->action == 2)? "selected" : '' }}>Retire de la caisse</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn {{ isset($object) ? 'btn-primary' : 'btn-success' }}">
                                    {{ __(isset($object) ? 'Enregistrer' : 'Créer') }}
                                </button>
                                <a href="{{ route('type-operation.index') }}" class="btn btn-secondary" >Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
