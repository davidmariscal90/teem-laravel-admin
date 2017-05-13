<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Subsport;
use App\Model\Sports;
//use Yajra\Datatables\Facades\Datatables;
use Session;
use Redirect;

class SubsportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('subsport.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sport=Sports::all();
        $sport=$sport->pluck('title','_id');
        return view('subsport.add',compact('sport'));
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
        'title' => 'required',
        'sportid' => 'required',
        'value' => 'required',
        ]);

        $input= $request->except(['_token']);
        $input['sportid']=new \MongoDB\BSON\ObjectID($input['sportid']);
       
        $subsport=Subsport::create($input);

        if($subsport){
            Session::flash('addsubsport', 'Subsport create successful!');
            return redirect()->route("subsport.index");
        }else{
            Session::flash('addsubsporterr', 'Subsport not create');
            return redirect()->route("subsport.create");
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subsportid=new \MongoDB\BSON\ObjectID($id);
        $subsport=Subsport::find($subsportid);
        $subsport->toArray();

        $sport=Sports::all();
        $sport=$sport->pluck('title','_id');

        return view('subsport.edit',compact('subsport','sport'));
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
        $input= $request->except(['_token']);
        $subsportid=new \MongoDB\BSON\ObjectID($id);
        $input['sportid']=new \MongoDB\BSON\ObjectID($input['sportid']);;
 
        $subsportupdate=Subsport::where('_id','=',$subsportid)
                        ->update($input);

        if($subsportupdate){
            Session::flash('addsubsport', 'Subsport Update successful!');
            return redirect()->route("subsport.index");
        }else{
            Session::flash('addsubsporterr', 'Subsport not update');
            return Redirect::back();
        }   
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $subsportid=new \MongoDB\BSON\ObjectID($id);
       $subsport=Subsport::where('_id','=',$subsportid)->delete();
       if($subsport){
            return response()->json(array('message'=>"Subsport delete successfully "),200);
       }else{
            return response()->json(array('message'=>"Subsport not found "),400);
       }
    }

    public function subsportList(Request $request){
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
                                'sportdetail.title' =>$regex
                            ),
                        array(
                            'title' =>$regex
                        ),       
                        array(
                            'value' =>$regex
                        )       
                      );

         $subsport=Subsport::raw(function ($collection) use ($orArr,$sortOrderArray,$iDisplayStart,$iDisplayLength) {
            return $collection->aggregate(array(
                                    array(
                                            '$lookup' => array(
                                                "from" => "sport",
                                                "localField" => "sportid",
                                                "foreignField" => "_id",
                                                "as" => "sportdetail"
                                             )
                                           ),
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

        $sportcount=Subsport::raw(function ($collection) use ($orArr) {
                return $collection->aggregate(array(
                                         array(
                                            '$lookup' => array(
                                                "from" => "sport",
                                                "localField" => "sportid",
                                                "foreignField" => "_id",
                                                "as" => "sportdetail"
                                             )
                                           ),
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

            foreach($subsport as $spkey=>$spObj){
                foreach($spObj->sportdetail as $sport ){
                    $subsport[$spkey]['sportdetail.title']=$sport['title'];
                }
            }
            
        $totalCount = Subsport::count();
         $output = array(
            "sEcho" => intval($input['sEcho']),
            "iTotalRecords" => $totalCount,
            "iTotalDisplayRecords" => $sportcount,
            "aaData" => $subsport->toArray()
            );
       return response()->json($output);
    }
}
