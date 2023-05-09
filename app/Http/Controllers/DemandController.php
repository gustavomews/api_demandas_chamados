<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demand;
use App\Models\Interaction;
use App\Repositories\DemandRepository;

class DemandController extends Controller
{
    public function __construct(Demand $demand, Interaction $interaction) {
        $this->demand = $demand;
        $this->interaction = $interaction;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $demands = [];
        $demandsGet = $this->demand->with(['user', 'status'])->orderBy('status_id')->orderBy('id')->get();
        for($i = 0; $i < count($demandsGet); $i++) {
            $demands[$i]['id'] = $demandsGet[$i]['id'];
            $demands[$i]['title'] = $demandsGet[$i]['title'];
            $demands[$i]['datetime_open'] = $demandsGet[$i]['datetime_open'];
            $demands[$i]['user'] = $demandsGet[$i]['user']['name'];
            $demands[$i]['status'] = $demandsGet[$i]['status']['title'];
            $demands[$i]['status_codename'] = $demandsGet[$i]['status']['codename'];
        };
        return response()->json($demands, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ---------------------------------------------------------------------- Validate
        $request->validate($this->demand->rules(), $this->demand->feedback());

        // ---------------------------------------------------------------------- Create demand
        $demand = $request->all('title', 'description');
        $demand['user_id'] = auth()->user()->id;

        $demand = $this->demand->create($demand);
        $demand_id = $demand->id;

        // ---------------------------------------------------------------------- Create interaction
        $interaction['demand_id'] = $demand_id;
        $interaction['user_id'] = auth()->user()->id;
        $interaction['description'] = 'Demanda criada';

        $this->interaction->create($interaction);

        // ---------------------------------------------------------------------- Return response
        return response()->json(['demand' => $demand, 'interaction' => $interaction], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $demand = $this->demand->with(['user', 'status', 'interactions.user'])->find($id);
        if(!isset($demand->id)) {
            return response()->json(['error' => 'Demanda/Chamado não encontrado!'], 404);
        }

        return response()->json($demand, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $demand = $this->demand->find($id);
        if(!isset($demand->id)) {
            return response()->json(['error' => 'Demanda/Chamado não encontrado!'], 404);
        }

        // Dynamic Rules for Patch method
        if ($request->method() === 'PATCH') {
            $dynamicRules = array();

            foreach ($this->demand->rules() as $input => $rule) {
                if (array_key_exists($input, $request->all())) {
                    $dynamicRules[$input] = $rule;
                }
            }

            $request->validate($dynamicRules, $this->demand->feedback());
        } else {
            // All Rules for Put method
            $request->validate($this->demand->rules(), $this->demand->feedback());
        }
        

        // ---------------------------------------------------------------------- Update demand
        $demand->fill($request->all());
        $demand->save();

        // ---------------------------------------------------------------------- Create interaction
        $interaction['demand_id'] = $demand->id;
        $interaction['user_id'] = auth()->user()->id;
        $interaction['description'] = 'Demanda editada';
        $this->interaction->create($interaction);
        
        // ---------------------------------------------------------------------- Return view
        return response()->json(['demand' => $demand, 'interaction' => $interaction], 200);
    }

    /**
     * Update the specified demand set in progress in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function open($id)
    {
        // ---------------------------------------------------------------------- Open demand
        $demand = $this->demand->find($id);
        if(!isset($demand->id)) {
            return response()->json(['error' => 'Demanda/Chamado não encontrado!'], 404);
        }

        // ---------------------------------------------------------------------- Validating whether the demand is not pending
        if($demand->status_id != 1) {
            return response()->json(['error' => 'Demanda/Chamado deve estar pendente para realizar a abertura!'], 404);
        }

        // ---------------------------------------------------------------------- Open
        $demand->status_id = 2;
        $demand->save();

        // ---------------------------------------------------------------------- Create interaction
        $interaction['demand_id'] = $id;
        $interaction['user_id'] = auth()->user()->id;
        $interaction['description'] = 'Status alterado para: Em Andamento';
        $this->interaction->create($interaction);

        // ---------------------------------------------------------------------- Return index show
        return response()->json(['demand' => $demand, 'interaction' => $interaction], 200);
    }

    /**
     * Update the specified demand set conclude in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function conclude($id)
    {
        // ---------------------------------------------------------------------- Conclude demand
        $demand = $this->demand->find($id);
        if(!isset($demand->id)) {
            return response()->json(['error' => 'Demanda/Chamado não encontrado!'], 404);
        }

        // ---------------------------------------------------------------------- Validating whether the demand is not opened
        if($demand->status_id != 2) {
            return response()->json(['error' => 'Demanda/Chamado deve estar aberta para realizar a conclusão!'], 404);
        }

        // ---------------------------------------------------------------------- Conclude
        $demand->status_id = 3;
        $demand->datetime_end = date('Y-m-d H:i:s');
        $demand->save();

        // ---------------------------------------------------------------------- Create interaction
        $interaction['demand_id'] = $id;
        $interaction['user_id'] = auth()->user()->id;
        $interaction['description'] = 'Status alterado para: Concluído';
        $this->interaction->create($interaction);

        // ---------------------------------------------------------------------- Return index show
        return response()->json(['demand' => $demand, 'interaction' => $interaction], 200);
    }

    /**
     * Update the specified demand set cancel in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        // ---------------------------------------------------------------------- Cancel demand
        $demand = $this->demand->find($id);
        if(!isset($demand->id)) {
            return response()->json(['error' => 'Demanda/Chamado não encontrado!'], 404);
        }

        // ---------------------------------------------------------------------- Validating whether the demand is not opened
        if($demand->status_id != 2) {
            return response()->json(['error' => 'Demanda/Chamado deve estar aberta para realizar o cancelamento!'], 404);
        }

        // ---------------------------------------------------------------------- Cancel
        $demand->status_id = 4;
        $demand->datetime_end = date('Y-m-d H:i:s');
        $demand->save();

        // ---------------------------------------------------------------------- Create interaction
        $interaction['demand_id'] = $id;
        $interaction['user_id'] = auth()->user()->id;
        $interaction['description'] = 'Status alterado para: Cancelado';
        $this->interaction->create($interaction);

        // ---------------------------------------------------------------------- Return index show
        return response()->json(['demand' => $demand, 'interaction' => $interaction], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return response()->json(['error' => 'Operação não permitida!'], 401);
    }
}
