<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Checklist;
use App\Models\Item;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChecklistApiRequest;
use App\Http\Requests\ChecklistPatchRequest;

use App\Http\Resources\Checklist as ChecklistResource;

use Log;


class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_limit = $request->page_limit ?? 10;
        // $page_offset = $request->page_offset ?? 0;

        $query = Checklist::query();

        if($request->include == 'items'){
            $query = $query->with('items');
        }

        if($request->filter){
            foreach ($request->filter as $key => $value) {
                $query = $query->where($key,'like',"%".$value."%");
            }
        }

        $data = new ChecklistResource($query->paginate($page_limit));

        // if(!isset($data) || !$data){
        //     return Requests_Exception_HTTP_500;
        // }

        return $data;

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
    public function store(ChecklistApiRequest $request)
    {
        $data = $request->data['attributes'];

        unset($data['items']);

        $checklist = Checklist::create($data);

        // saving items : optional
        try {
            $items_data = $request->data['attributes']['items'];

            if($items_data !== []){
                foreach ($items_data as $key => $value) {
                    $items[] = new Item([
                        'description' => $value
                    ]);
                }
                $checklist = Checklist::find($checklist->id);
                $checklist->items()->saveMany($items);
            }
        } catch (\Throwable $th) {
            Log::info($th);
        }


        return response()->json([
            'data' => $this->transformData($checklist)
        ], 201);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function show(Checklist $checklist)
    {
        $data = $this->transformData($checklist);
        return response()->json([
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function edit(Checklist $checklist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function update(ChecklistPatchRequest $request, Checklist $checklist)
    {
        $data = $request->data['attributes'];

        unset($data['items']);

        $checklist->update($data);

        $data = $this->transformData($checklist);
        return response()->json([
            'data' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checklist $checklist)
    {
        $checklist->delete();
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
    public function transformData(Checklist $checklist)
    {
        $domain = \explode('.',request()->route()->getName())[0];

        return [
            'type' => $domain,
            'id' => $checklist->id,
            'attributes' => Checklist::with('items')->find($checklist->id),
            'links' => [
                'self' => url('api/v1/'.$domain, $checklist->id)
            ]
        ];
    }
}
