<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChecklistApiRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Checklist;
use App\Models\Item;

use App\Http\Resources\Item as ItemResource;
use App\Http\Requests\ItemStoreRequest;
use App\Http\Requests\ItemPatchRequest;
use App\Http\Requests\ItemIncompleteRequest;

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
    public function store(Checklist $id, ItemStoreRequest $request)
    {
        $request = json_decode(json_encode($request->data['attribute']));

        $item = new Item([
            'description' => $request->description,
            'due' => $request->due,
            'urgency' => $request->urgency,
            'assignee_id' => $request->assignee_id
        ]);

        $id->items()->save($item);

        return response()->json([
            'data' => $this->transformData($id,$item->id)
        ], 201);
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
     * Show the incomplete item(s)
     *
     * @param  json
     * @return \Illuminate\Http\Response
     */
    public function incomplete(ItemIncompleteRequest $request)
    {
        $items = Item::where('is_completed',0)->simplePaginate(10);

        if(!$items){
            return response()->json([
                'data' => []
            ], 200);
        }

        $items->transform(function ($item, $key) {
            return [
                'id' => (int)$item->id,
                'item_id' => (int)$item->id,
                'is_completed' => $item->is_completed,
                'checklist_id' => (string)$item->checklist_id
            ] ;
        });

        return response()->json($items, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(ItemPatchRequest $request, Checklist $id, Item $item)
    {
        if( !$item || !$id ){
            throw new ModelNotFoundException;
        }

        if( $item->checklist_id !== $id->id ){
            throw new ModelNotFoundException;
        }

        $data = $request->data['attribute'];

        $item->update($data);

        return response()->json([
            'data' => Item::find($item->id)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checklist $id, Item $item)
    {
        if( !$item || !$id ){
            throw new ModelNotFoundException;
        }

        if( (int)$item->checklist_id !== (int)$id->id ){
            throw new ModelNotFoundException;
        }

        $item->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Delete success!'
        ], 200);
    }

     /**
     * Transform data to API standar.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return Array
     */
    public function transformData(Checklist $checklist, $id = null)
    {
        $domain = 'checklists';

        if($id == null){
            return [
                'type' => $domain,
                'id' => $checklist->id,
                'attributes' => $checklist,
                'links' => [
                    'self' => url('api/v1/'.$domain, $checklist->id).'/items'
                ]
            ];
        }
        $item = Item::find($id);

        return [
            'type' => $domain,
            'id' => $item->id,
            'attributes' => $item,
            'links' => [
                'self' => url('api/v1/'.$domain, $checklist->id).'/items/'.$item->id
            ]
        ];
    }
}
