@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Liste des type d\'opération') }}
                    <a href="{{ route('type-operation.create') }}" class="btn btn-success" >Ajouter</a>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th >ID</th>
                                <th >Désignation</th>
                                <th >Action</th>
                                <th >_</th>
                                <th >_</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->designation }}</td>
                                    <td>{{ \App\Models\TypeOperation::ACTIONS[$item->action] }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('type-operation.edit', ['id' => $item->id])}}">Modifier</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('type-operation.delete', ['id' => $item->id]) }}" method="post">
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
