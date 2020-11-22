<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Checklist;
use App\Models\Item;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChecklistApiRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Resources\Checklist as ChecklistResource;

use Log;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Checklist $checklist, Item $item)
    {

        // todo : add item and checklist validation
        // dd($item);
        if( !$item->id || !$checklist->id ){
            throw new ModelNotFoundException;
        }
        // $data = $this->transformData($item);
        return response()->json([
            'data' => $item
        ], 200);

        $data = $this->transformData($item);
        return response()->json([
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }

     /**
     * Transform data to API standar.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return Array
     */
    public function transformData(Item $item)
    {
        $domain = \explode('.',request()->route()->getName())[0];

        return [
            'type' => $domain,
            'id' => $item->id,
            'attributes' => Checklist::with('items')->find($item->id),
            'links' => [
                'self' => url('api/v1/'.$domain, $item->id)
            ]
        ];
    }
}
