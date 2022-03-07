@extends('layouts.app')

@section('content')
<script>
    var billetsNominal = JSON.parse("{{ json_encode($billetsNominal) }}");
    var piecesNominal = JSON.parse("{{ json_encode($piecesNominal) }}");
    var centimesNominal = JSON.parse("{{ json_encode($centimesNominal) }}");
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="{{ $url }}">
                <div class="card">
                    <div class="card-header">
                        {{ __('Entrée de fond de caisse') }}
                    </div>

                    <div class="card-body">
                            @csrf
                            @if(isset($method))
                                @method("PUT")
                            @endif

                            <div class="row mb-3">
                                <label for="type_operation_id" class="col-md-4 col-form-label text-md-end">{{ __('Type d\'opération') }}</label>

                                <div class="col-md-6">

                                    <select name="type_operation_id" id="type_operation_id" class="form-control">
                                        @foreach ($typeOperations as $id => $designation)
                                            <option value="{{ $id }}" {{ (isset($object) && $object->type_operation_id == $id)? "selected" : '' }}>{{ $designation }}</option> 
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="date" class="col-md-4 col-form-label text-md-end">{{ __('Date') }}</label>

                                <div class="col-md-6">
                                    <input id="datepicker" type="text" class="form-control" name="date" value="{{ old('date', isset($object) ? $object->date : '') }}">

                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="comment" class="col-md-4 col-form-label text-md-end">{{ __('Note') }}</label>

                                <div class="col-md-6">
                                    <textarea id="comment" type="text" class="form-control" name="comment" >{{ old('comment', isset($object) ? $object->comment : '') }}</textarea>

                                    @error('comment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <span class="total">0</span>€
                        
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        {{ __('Billets') }}
                    </div>

                    <div class="card-body">
                        <div class="row mb-0">
                            <div class="col-md-12">
                                <div class="block-nominal-wrapper billets">
                                    @if(isset($object) && isset($object->saisieDetailBillets) && count($object->saisieDetailBillets))
                                        @foreach ($object->saisieDetailBillets as $index => $item)

                                            <div class="block-nominal" data-number="0">
                                                <div class="d-inline-block col-md-5">
                                                    <label for="nominal" class="col-md-4 col-form-label text-md-end">{{ __('Nominal') }}</label>
                    
                                                    <div class="col-md-6">
                                                        <select name="billets[{{ $index }}][nominal]" id="nominal" class="form-control nominal">
                                                            @foreach ($billetsNominal as $billetNominal)
                                                                <option value="{{ $billetNominal }}" {{ (isset($item->nominal) && $item->nominal == $billetNominal) ? "selected" : '' }}>{{ $billetNominal }}</option> 
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="d-inline-block col-md-5">
                                                    <label for="quantity" class="col-md-4 col-form-label text-md-end">{{ __('Quantité') }}</label>
                    
                                                    <div class="col-md-6">
                                                        <input id="quantity" type="number" class="form-control quantity" name="billets[{{ $index }}][quantity]" value="{{ isset($item->quantity) ? $item->quantity : null }}">
                                                    </div>
                                                </div>
                                                <span class="subtotal">0</span>€
                                                @if($index > 0)
                                                    <span class="close-nominal">X</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="block-nominal" data-number="0">
                                            <div class="d-inline-block col-md-5">
                                                <label for="nominal" class="col-md-4 col-form-label text-md-end">{{ __('Nominal') }}</label>
                
                                                <div class="col-md-6">
                                                    <div class="col-md-6">
                                                        <select name="billets[0][nominal]" id="nominal" class="form-control nominal">
                                                            @foreach ($billetsNominal as $billetNominal)
                                                                <option value="{{ $billetNominal }}">{{ $billetNominal }}</option> 
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-inline-block col-md-5">
                                                <label for="quantity" class="col-md-4 col-form-label text-md-end">{{ __('Quantité') }}</label>
                
                                                <div class="col-md-6">
                                                    <input id="quantity" type="number" class="form-control quantity" name="billets[0][quantity]" value="">
                                                </div>
                                            </div>
                                            <span class="subtotal">0</span>€
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-success add-nominal" data-block="billets">
                                    Ajouter
                                </button>
                            </div>
                        </div>
                        {{-- <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __(isset($object) ? 'Enregistrer' : 'Créer') }}
                                </button>
                                <a href="{{ route('saisies.index') }}" class="btn btn-secondary" >Annuler</a>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        {{ __('Pièces') }}
                    </div>

                    <div class="card-body">
                        <div class="row mb-0">
                            <div class="col-md-12">
                                <div class="block-nominal-wrapper pieces">
                                    @if(isset($object) && isset($object->saisieDetailPieces) && count($object->saisieDetailPieces))
                                        @foreach ($object->saisieDetailPieces as $index => $item)

                                            <div class="block-nominal" data-number="0">
                                                <div class="d-inline-block col-md-5">
                                                    <label for="nominal" class="col-md-4 col-form-label text-md-end">{{ __('Nominal') }}</label>
                    
                                                    <div class="col-md-6">
                                                        <select name="pieces[{{ $index }}][nominal]" id="nominal" class="form-control nominal">
                                                            @foreach ($piecesNominal as $pieceNominal)
                                                                <option value="{{ $pieceNominal }}" {{ (isset($item->nominal) && $item->nominal == $pieceNominal) ? "selected" : '' }}>{{ $pieceNominal }}</option> 
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="d-inline-block col-md-5">
                                                    <label for="quantity" class="col-md-4 col-form-label text-md-end">{{ __('Quantité') }}</label>
                    
                                                    <div class="col-md-6">
                                                        <input id="quantity" type="number" class="form-control quantity" name="pieces[{{ $index }}][quantity]" value="{{ isset($item->quantity) ? $item->quantity : null }}">
                                                    </div>
                                                </div>
                                                <span class="subtotal">0</span>€
                                                @if($index > 0)
                                                    <span class="close-nominal">X</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="block-nominal" data-number="0">
                                            <div class="d-inline-block col-md-5">
                                                <label for="nominal" class="col-md-4 col-form-label text-md-end">{{ __('Nominal') }}</label>
                
                                                <div class="col-md-6">
                                                    <div class="col-md-6">
                                                        <select name="pieces[0][nominal]" id="nominal" class="form-control nominal">
                                                            @foreach ($piecesNominal as $pieceNominal)
                                                                <option value="{{ $pieceNominal }}">{{ $pieceNominal }}</option> 
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-inline-block col-md-5">
                                                <label for="quantity" class="col-md-4 col-form-label text-md-end">{{ __('Quantité') }}</label>
                
                                                <div class="col-md-6">
                                                    <input id="quantity" type="number" class="form-control quantity" name="pieces[0][quantity]" value="">
                                                </div>
                                            </div>
                                            <span class="subtotal">0</span>€
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-success add-nominal" data-block="pieces">
                                    Ajouter
                                </button>
                            </div>
                        </div>
                        {{-- <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __(isset($object) ? 'Enregistrer' : 'Créer') }}
                                </button>
                                <a href="{{ route('saisies.index') }}" class="btn btn-secondary" >Annuler</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        {{ __('Centimes') }}
                    </div>

                    <div class="card-body">
                        <div class="row mb-0">
                            <div class="col-md-12">
                                <div class="block-nominal-wrapper centime">
                                    @if(isset($object) && isset($object->saisieDetailCentimes) && count($object->saisieDetailCentimes))
                                        @foreach ($object->saisieDetailCentimes as $index => $item)

                                            <div class="block-nominal" data-number="0">
                                                <div class="d-inline-block col-md-5">
                                                    <label for="nominal" class="col-md-4 col-form-label text-md-end">{{ __('Nominal') }}</label>
                    
                                                    <div class="col-md-6">
                                                        <select name="centimes[{{ $index }}][nominal]" id="nominal" class="form-control nominal centimes">
                                                            @foreach ($centimesNominal as $centimeNominal)
                                                                <option value="{{ $centimeNominal }}" {{ (isset($item->nominal) && $item->nominal == $centimeNominal) ? "selected" : '' }}>{{ $centimeNominal }}</option> 
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="d-inline-block col-md-5">
                                                    <label for="quantity" class="col-md-4 col-form-label text-md-end">{{ __('Quantité') }}</label>
                    
                                                    <div class="col-md-6">
                                                        <input id="quantity" type="number" class="form-control quantity centimes" name="centimes[{{ $index }}][quantity]" value="{{ isset($item->quantity) ? $item->quantity : null }}">
                                                    </div>
                                                </div>
                                                <span class="subtotal">0</span>€
                                                @if($index > 0)
                                                    <span class="close-nominal">X</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="block-nominal" data-number="0">
                                            <div class="d-inline-block col-md-5">
                                                <label for="nominal" class="col-md-4 col-form-label text-md-end">{{ __('Nominal') }}</label>
                
                                                <div class="col-md-6">
                                                    <div class="col-md-6">
                                                        <select name="centimes[0][nominal]" id="nominal" class="form-control nominal centimes">
                                                            @foreach ($centimesNominal as $centimeNominal)
                                                                <option value="{{ $centimeNominal }}">{{ $centimeNominal }}</option> 
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-inline-block col-md-5">
                                                <label for="quantity" class="col-md-4 col-form-label text-md-end">{{ __('Quantité') }}</label>
                
                                                <div class="col-md-6">
                                                    <input id="quantity" type="number" class="form-control quantity centimes" name="centimes[0][quantity]" value="">
                                                </div>
                                            </div>
                                            <span class="subtotal">0</span>€
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-success add-nominal" data-block="centimes">
                                    Ajouter
                                </button>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn  {{ isset($object) ? 'btn-primary' : 'btn-success' }}">
                                    {{ __(isset($object) ? 'Enregistrer' : 'Créer') }}
                                </button>
                                <a href="{{ route('saisies.index') }}" class="btn btn-secondary" >Annuler</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
