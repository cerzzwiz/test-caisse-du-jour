@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ __('Total caisse:') }}                    
                </div>
                <div class="card-body">
                    <span class="total-caisse">{{ $total }}€</span>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Opération du jour') }}
                    <a href="{{ route('saisies.create') }}" class="btn btn-success" >Ajouter</a>
                    
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th >ID</th>
                                <th >Date</th>
                                <th >Type</th>
                                <th >Montant</th>
                                <th >_</th>
                                <th >_</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->total }}€</td>
                                    <td>
                                        <a href="{{ route('saisies.edit', ['id' => $item->id])}}" class="btn btn-primary">Modifier</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('saisies.delete', ['id' => $item->id]) }}" method="post">
                                            {{ method_field('delete') }}
                                            @csrf
                                            <button class="btn btn-danger" type="submit">Suprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
