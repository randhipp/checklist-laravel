<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChecklistApiRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Checklist;
use App\Models\Item;

use App\Http\Resources\Item as ItemResource;

use Log;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $page_limit = $request->page_limit ?? 10;
        // $page_offset = $request->page_offset ?? 0;

        $query = Item::query();

        if($request->filter){
            foreach ($request->filter as $key => $value) {
                $query = $query->where($key,'like',"%".$value."%");
            }
        }

        $data = new ItemResource($query->paginate($page_limit));

        return $data;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Checklist $id)
    {
        if( !$id ){
            throw new ModelNotFoundException;
        }

        return response()->json([
            'data' => $this->transformData(Checklist::with('items')->find($id->id))
        ], 200);
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Checklist $id, Item $item)
    {

        if( !$item || !$id ){
            throw new ModelNotFoundException;
        }

        if( $item->checklist_id !== $id->id ){
            throw new ModelNotFoundException;
        }

        return response()->json([
            'data' => $item
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
    public function transformData(Checklist $checklist)
    {
        $domain = \explode('.',request()->route()->getName())[0];

        return [
            'type' => $domain,
            'id' => $checklist->id,
            'attributes' => $checklist,
            'links' => [
                'self' => url('api/v1/'.$domain, $checklist->id.'/items')
            ]
        ];
    }
}
