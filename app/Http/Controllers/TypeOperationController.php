<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeOperation;


class TypeOperationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $datas = TypeOperation::all();

        return view('type_operations.index', ['datas' => $datas]);
    }

    public function create()
    {
        return view('type_operations.form', [
            'url' => route('type-operation.store')
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->all();

        TypeOperation::create($params);

        return redirect(route('type-operation.index'));
    }

    public function edit($id)
    {
        $item = TypeOperation::find($id);

        return view('type_operations.form', [
            'object' => $item,
            'page_title' => 'Modifier le type d\'opération ' . $item->designation,
            'url' => route('type-operation.update', ['id' =>  $item->id]),
            'method' => 'PUT'
        ]);
    }

    public function update(Request $request, $id)
    {
        $params = $request->all();
        $item = TypeOperation::find($id);

        $item->update($params);

        return redirect(route('type-operation.index'));
    }

    public function delete($id)
    {
        $item = TypeOperation::find($id);

        $item->delete();

        return redirect(route('type-operation.index'));
    }
}
