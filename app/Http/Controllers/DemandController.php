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
        $demandRepository = new DemandRepository($this->demand);
        return response()->json($demandRepository->getResult(), 200);
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
    }
}
