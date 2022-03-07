<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saisie;
use App\Models\SaisieDetail;
use App\Models\TypeOperation;


class SaisieController extends Controller
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
        $datas = Saisie::all();
        $total = 0;

        if ($datas && count($datas)) {
            foreach ($datas as $data) {
                if ($data->typeOperation->action == 1) {
                    $total += $data->total;
                } elseif($data->typeOperation->action == 2) {
                    $total -= $data->total;
                }
            }
        }

        return view('saisies.index', [
            'datas' => $datas,
            'total' => $total
        ]);
    }

    public function create()
    {
        $typeOperations = TypeOperation::pluck('designation', 'id');
        $billetsNominal = $this->getListNominal('billets');
        $piecesNominal = $this->getListNominal('pieces');
        $centimesNominal = $this->getListNominal('centimes');

        return view('saisies.form', [
            'url' => route('saisies.store'),
            'typeOperations' => $typeOperations,
            'billetsNominal' => $billetsNominal,
            'piecesNominal' => $piecesNominal,
            'centimesNominal' => $centimesNominal
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $saisie = new Saisie();
        $saisie->type_operation_id = $params['type_operation_id'];
        $saisie->date = $params['date'];
        $saisie->comment = $params['comment'];
        $saisie->save();

        if (count($params['billets'])) {
            foreach ($params['billets'] as $item) {
                $saisieDetail = new SaisieDetail();
                $saisieDetail->saisie_id = $saisie->id;
                $saisieDetail->nominal = $item['nominal'];
                $saisieDetail->quantity = $item['quantity'];
                $saisieDetail->block_type = 1;
                $saisieDetail->save();
            }
        }
        if (count($params['pieces'])) {
            foreach ($params['pieces'] as $item) {
                $saisieDetail = new SaisieDetail();
                $saisieDetail->saisie_id = $saisie->id;
                $saisieDetail->nominal = $item['nominal'];
                $saisieDetail->quantity = $item['quantity'];
                $saisieDetail->block_type = 2;
                $saisieDetail->save();
            }
        }
        if (count($params['centimes'])) {
            foreach ($params['centimes'] as $item) {
                $saisieDetail = new SaisieDetail();
                $saisieDetail->saisie_id = $saisie->id;
                $saisieDetail->nominal = $item['nominal'];
                $saisieDetail->quantity = $item['quantity'];
                $saisieDetail->block_type = 3;
                $saisieDetail->save();
            }
        }

        return redirect(route('saisies.index'));
    }

    public function edit($id)
    {
        $item = Saisie::find($id);
        $typeOperations = TypeOperation::pluck('designation', 'id');
        $billetsNominal = $this->getListNominal('billets');
        $piecesNominal = $this->getListNominal('pieces');
        $centimesNominal = $this->getListNominal('centimes');

        return view('saisies.form', [
            'object' => $item,
            'page_title' => 'Modifier le type d\'opération ' . $item->designation,
            'url' => route('saisies.update', ['id' =>  $item->id]),
            'method' => 'PUT',
            'typeOperations' => $typeOperations,
            'billetsNominal' => $billetsNominal,
            'piecesNominal' => $piecesNominal,
            'centimesNominal' => $centimesNominal
        ]);
    }

    public function update(Request $request, $id)
    {
        $params = $request->all();
        $saisie = Saisie::find($id);

        $saisie->type_operation_id = $params['type_operation_id'];
        $saisie->date = $params['date'];
        $saisie->comment = $params['comment'];
        $saisie->save();

        if (count($saisie->saisieDetailBillets)) {
            foreach ($saisie->saisieDetailBillets as $saisieDetailBillet) {
                $saisieDetailBillet->delete();
            }
        }
        if (count($saisie->saisieDetailPieces)) {
            foreach ($saisie->saisieDetailPieces as $saisieDetailPiece) {
                $saisieDetailPiece->delete();
            }
        }
        if (count($saisie->saisieDetailCentimes)) {
            foreach ($saisie->saisieDetailCentimes as $saisieDetailCentime) {
                $saisieDetailCentime->delete();
            }
        }

        if (count($params['billets'])) {
            foreach ($params['billets'] as $item) {
                $saisieDetail = new SaisieDetail();
                $saisieDetail->saisie_id = $saisie->id;
                $saisieDetail->nominal = $item['nominal'];
                $saisieDetail->quantity = $item['quantity'];
                $saisieDetail->block_type = 1;
                $saisieDetail->save();
            }
        }
        if (isset($params['pieces']) && count($params['pieces'])) {
            foreach ($params['pieces'] as $item) {
                $saisieDetail = new SaisieDetail();
                $saisieDetail->saisie_id = $saisie->id;
                $saisieDetail->nominal = $item['nominal'];
                $saisieDetail->quantity = $item['quantity'];
                $saisieDetail->block_type = 2;
                $saisieDetail->save();
            }
        }
        if (isset($params['centimes']) && count($params['centimes'])) {
            foreach ($params['centimes'] as $item) {
                $saisieDetail = new SaisieDetail();
                $saisieDetail->saisie_id = $saisie->id;
                $saisieDetail->nominal = $item['nominal'];
                $saisieDetail->quantity = $item['quantity'];
                $saisieDetail->block_type = 3;
                $saisieDetail->save();
            }
        }

        return redirect(route('saisies.index'));
    }

    public function delete($id)
    {
        $item = Saisie::find($id);

        if (count($item->saisieDetailBillets)) {
            foreach ($item->saisieDetailBillets as $saisieDetailBillet) {
                $saisieDetailBillet->delete();
            }
        }
        if (count($item->saisieDetailPieces)) {
            foreach ($item->saisieDetailPieces as $saisieDetailPiece) {
                $saisieDetailPiece->delete();
            }
        }
        if (count($item->saisieDetailCentimes)) {
            foreach ($item->saisieDetailCentimes as $saisieDetailCentime) {
                $saisieDetailCentime->delete();
            }
        }

        $item->delete();

        return redirect(route('saisies.index'));
    }

    public function getListNominal($type)
    {
        $list = [
            'billets' => [
                5,
                10,
                20,
                50,
                100,
                200,
                500
            ],
            'pieces' => [
                1,
                2
            ],
            'centimes' => [
                1,
                2,
                5,
                10,
                20,
                50
            ]
        ];

        return $list[$type];
    }
}
