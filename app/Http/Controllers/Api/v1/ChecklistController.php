<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Checklist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChecklistApiRequest;

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

        if(!isset($data) || !$data){
            return Requests_Exception_HTTP_500;
        }

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

        return $this->show($checklist);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function show(Checklist $checklist)
    {
        $domain = \explode('.',request()->route()->getName())[0];

        return [
            'type' => $domain,
            'id' => $checklist->id,
            'attributes' => $checklist,
            'links' => [
                'self' => url('api/v1/'.$domain, $checklist->id)
            ]
        ] ;
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
    public function update(Request $request, Checklist $checklist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checklist $checklist)
    {
        //
    }
}
