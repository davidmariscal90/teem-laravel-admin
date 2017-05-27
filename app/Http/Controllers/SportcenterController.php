<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Sportcenter;
use Session;

class SportcenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
     {
         $this->middleware('auth');
     }
    public function index()
    {
        return view('sportcenter.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sportcenter.add');
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
            'name' => 'required',
            'address' => 'required',
            'phone'=>'required',
            'description'=>'required',
            'lat'=>'required',
            'long'=>'required'
        ]);

        $input=$request->except(['_token','_method']);
        $input['userid']='';
        $input['lat']=(double)$input['lat'];
        $input['long']=(double)$input['long'];
        $input['ispublic']=true;
        $input['isreviewed']=true;

        $sportcenter=Sportcenter::create($input);

        if ($sportcenter) {
            Session::flash('sportcenter', 'Sportcenter create successful!');
            return redirect()->route("sportcenter.index");
        } else {
            Session::flash('sportcentererr', 'Sportcenter not create');
            return redirect()->route("sportcenter/create");
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
        $scid=new \MongoDB\BSON\ObjectID($id);
        $sportcenter=Sportcenter::find($scid);
        $sportcenter->toArray();
       
        return view('sportcenter/edit', compact('sportcenter'));
    }

   
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone'=>'required',
            'description'=>'required',
            'lat'=>'required',
            'long'=>'required'
        ]);

        $input=$request->except(['_token','_method']);
        $input['userid']='';
        $input['lat']=(double)$input['lat'];
        $input['long']=(double)$input['long'];
        
        $scid=new \MongoDB\BSON\ObjectID($id);

        $sportcenter=Sportcenter::where('_id', '=', $scid)
                                ->update($input);

        if ($sportcenter) {
            Session::flash('sportcenter', 'Sportcenter update successful!');
            return redirect()->route("sportcenter.index");
        } else {
            Session::flash('sportcentererr', 'Sportcenter not update');
            return redirect()->back();
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
        $sportcenter=Sportcenter::find($id);
        
        $response=$sportcenter->delete();

        if ($response) {
            $message="Sportcenter delete successfully";
            $code=200;
        } else {
            $message="Someting went wrong try again";
            $code=400;
        }
        
        return response()->json(array('message'=>$message), $code);
    }
    public function sportcenterList(Request $request)
    {
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
                                'name' =>$regex
                            ),
                        array(
                            'address' =>$regex
                        ),
                        array(
                            'phone' =>$regex
                        ),
                         array(
                            'description' =>$regex
                        ),
                        array(
                            'userdetail.username' =>$regex
                        )
                      );

        $sportcenter=Sportcenter::raw(function ($collection) use ($orArr, $sortOrderArray, $iDisplayStart, $iDisplayLength) {
            return $collection->aggregate(array(
                                    array(
                                            '$lookup' => array(
                                                "from" => "user",
                                                "localField" => "userid",
                                                "foreignField" => "_id",
                                                "as" => "userdetail"
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

        $sportcentercount=Sportcenter::raw(function ($collection) use ($orArr) {
            return $collection->aggregate(array(
                                    array(
                                            '$lookup' => array(
                                                "from" => "user",
                                                "localField" => "userid",
                                                "foreignField" => "_id",
                                                "as" => "userdetail"
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

        foreach ($sportcentercount as $key => $value) {
            $sportcentercount=$value->count;
        }

        foreach ($sportcenter as $sckey => $scObj) {
            foreach ($scObj['userdetail'] as $userkey=> $userObj) {
                $sportcenter[$sckey]['userdetail.username']=$userObj['username'];
                $sportcenter[$sckey]['userdetail.profileimage']=$userObj['profileimage'];
            }
        }

        $totalCount = Sportcenter::count();

        $output = array(
            "sEcho" => intval($input['sEcho']),
            "iTotalRecords" => $totalCount,
            "iTotalDisplayRecords" => $sportcentercount,
            "aaData" => $sportcenter->toArray()
            );

        return response()->json($output);
    }

    public function sportcenterPublicStatus($id)
    {
        $sportcenter=Sportcenter::find($id);
        if ($sportcenter['ispublic']==false) {
            $sportcenter->ispublic=true;
        } else {
            $sportcenter->ispublic=false;
        }

        $status=$sportcenter->save();
        
        if ($status) {
            $message="Sportcenter update successfully";
            $code=200;
        } else {
            $message="Someting went wrong try again";
            $code=400;
        }
        return response()->json(array('message'=>$message), $code);
    }

	public function viewSportCentre(Request $request, $id) {
		$sportCentreDetails = Sportcenter::where('_id', '=', $id)->get();
		// print_r($userDetails);
		return view("sportcenter/view",compact('sportCentreDetails'));
	}
}

