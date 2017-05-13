<?php

namespace App\Http\Controllers;

use App\Model\Sports;
use Illuminate\Http\Request;
//use Yajra\Datatables\Facades\Datatables;
use Session;
use Redirect;

class SportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('sport.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sport.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'title' => 'required|unique:sport',
        'imageurl' => 'required',
        ]);

        $input=$request->all();

        $sport=Sports::create($input);

        if($sport){
            Session::flash('addsport', 'Sport create successful!');
            return redirect()->route("sport.index");
        }else{
            Session::flash('addsporterr', 'Sport not create');
            return redirect()->route("sport.create");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $sportid=new \MongoDB\BSON\ObjectID($id);
        $sport=Sports::find($sportid);
        $sport->toArray();
       
        return view('sport/edit',compact('sport'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sportid=new \MongoDB\BSON\ObjectID($id);
        
        $input=$request->all();

        $sport=Sports::where('title','=',$input['title'])
                ->where('_id','!=',$sportid)
                ->get(); 

        if(count($sport)==1){
                Session::flash('addsporterr', 'Sport title already exists');
                return Redirect::back();
         }else{
            $sportupdate=Sports::where('_id','=',$sportid)
                                ->update($input);

              if($sportupdate){
                    Session::flash('addsport', 'Sport Update successful!');
                    return redirect()->route("sport.index");
                }else{
                    Session::flash('addsporterr', 'Sport not update');
                    return Redirect::back();
                }                       
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $sportid=new \MongoDB\BSON\ObjectID($id);
       $sport=Sports::where('_id','=',$sportid)->delete();
       
       if($sport){
            return response()->json(array('message'=>"Sport delete successfully "),200);
       }else{
            return response()->json(array('message'=>"Sport not delete "),400);
       }

    }

    public function sportList(Request $request){
         $input = $request->all();

        $iColumns = $input['iColumns'];

        $dataProps = array();
        for ($i = 0; $i < $iColumns; $i++) {
            $var = 'mDataProp_'.$i;
            if (!empty($input[$var]) && $input[$var] != 'null') {
                $dataProps[$i] = $input[$var];
            }
        }

        $searchText = $input['sSearch'];

        $sortOrderArray = array();

        if (isset($input['iSortCol_0'])) {
            for ($i = 0; $i < intval($input['iSortingCols']); $i++) {
                if ($input['bSortable_'.intval($input['iSortCol_'.$i])] == 'true') {
                    $field = $dataProps[intval($input['iSortCol_'.$i])];
                    $order = ($input['sSortDir_'.$i] == 'desc' ? -1 : 1);
                    $sortOrderArray[$field] = $order;
                }
            }
        }

        
        $iDisplayLength=$input['iDisplayLength'];

        $iDisplayStart=$input['iDisplayStart'];

        $regex=new \MongoDB\BSON\Regex($searchText, "^i");

        $orArr=array(
                       
                        array(
                            'title' =>$regex
                        ),       
                        array(
                            'imageurl' =>$regex
                        )       
                      );

    $sport=Sports::raw(function ($collection) use ($orArr,$sortOrderArray,$iDisplayStart,$iDisplayLength) {
            return $collection->aggregate(array(
                                           array(
                                                '$match'=>array(
                                                     '$or' => $orArr
                                                 )
                                        ),
                                         array(
                                            '$sort'=>$sortOrderArray
                                        ),
                                        array(
                                            '$skip' => intval($iDisplayStart),
                                            ) ,
                                        array(
                                            '$limit'=>intval($iDisplayLength)
                                            )
                                ));
        });

        $sportcount=Sports::raw(function ($collection) use ($orArr) {
                return $collection->aggregate(array(
                                        array(
                                                '$match'=>array(
                                                     '$or' => $orArr
                                                 )
                                        ),
                                        array(
                                        '$group' => array(
                                            '_id' =>null,
                                            'count' => array( '$sum' => 1 )
                                            )
                                        )

                                    ));
            });

         
             foreach ($sportcount as $key => $value) {
                $sportcount=$value->count;
            }

        $totalCount = Sports::count();
         $output = array(
            "sEcho" => intval($input['sEcho']),
            "iTotalRecords" => $totalCount,
            "iTotalDisplayRecords" => $sportcount,
            "aaData" => $sport
            );
       return response()->json($output);

    }
}
