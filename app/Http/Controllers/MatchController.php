<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Match;

class MatchController extends Controller
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
        return view('match.index');
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
		 $match=Match::find($id);
         $response=$match->delete();

        if ($response) {
            $message="Match delete successfully";
            $code=200;
        } else {
            $message="Someting went wrong try again";
            $code=400;
        }
        
        return response()->json(array('message'=>$message), $code);
    
    }
	public function matchList(Request $request){
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
                                'sportcenterdetail.name' =>$regex
                            ),
                        array(
                            'sportcenterdetail.address' =>$regex
                        ),       
                        array(
                            'userdetail.username' =>$regex
                        ),
                        array(
                            'sportdetail.title' =>$regex
                        ),
						array(
                            'subsportdetail.title' =>$regex
                        )
				         
                      );

         $match=Match::raw(function ($collection) use ($orArr,$sortOrderArray,$iDisplayStart,$iDisplayLength) {
            return $collection->aggregate(array(
                                     array(
                                            '$lookup' => array(
                                                "from" => "sportcenter",
                                                "localField" => "scid",
                                                "foreignField" => "_id",
                                                "as" => "sportcenterdetail"
                                             )
                                           ),
                                      array(
                                            '$lookup' => array(
                                                "from" => "user",
                                                "localField" => "userid",
                                                "foreignField" => "_id",
                                                "as" => "userdetail"
                                             )
                                           ),
									array(
                                            '$lookup' => array(
                                                "from" => "fields",
                                                "localField" => "fieldid",
                                                "foreignField" => "_id",
                                                "as" => "fielddetail"
                                             )
                                           ),	   
									array(
                                            '$lookup' => array(
                                                "from" => "sport",
                                                "localField" => "sport",
                                                "foreignField" => "_id",
                                                "as" => "sportdetail"
                                             )
                                           ),	   		   
                                      array(
                                            '$lookup' => array(
                                                "from" => "subsport",
                                                "localField" => "subsportid",
                                                "foreignField" => "_id",
                                                "as" => "subsportdetail"
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

        $matchcount=Match::raw(function ($collection) use ($orArr) {
                return $collection->aggregate(array(
                                         array(
                                            '$lookup' => array(
                                                "from" => "sportcenter",
                                                "localField" => "scid",
                                                "foreignField" => "_id",
                                                "as" => "sportcenterdetail"
                                             )
                                           ),
                                      array(
                                            '$lookup' => array(
                                                "from" => "user",
                                                "localField" => "userid",
                                                "foreignField" => "_id",
                                                "as" => "userdetail"
                                             )
                                           ),
									array(
                                            '$lookup' => array(
                                                "from" => "fields",
                                                "localField" => "fieldid",
                                                "foreignField" => "_id",
                                                "as" => "fielddetail"
                                             )
                                           ),	   
									array(
                                            '$lookup' => array(
                                                "from" => "sport",
                                                "localField" => "sport",
                                                "foreignField" => "_id",
                                                "as" => "sportdetail"
                                             )
                                           ),	   		   
                                      array(
                                            '$lookup' => array(
                                                "from" => "subsport",
                                                "localField" => "subsportid",
                                                "foreignField" => "_id",
                                                "as" => "subsportdetail"
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

            foreach ($matchcount as $key => $value) {
                $matchcount=$value->count;
            }
            // echo '<pre>';
			// print_r($match); exit;
            foreach($match as $matchkey=>$matchiObj){
                $name=$matchiObj['sportcenterdetail'][0]['name'];
                $address=$matchiObj['sportcenterdetail'][0]['address'];
                $date=$matchiObj['matchtime'];
                $sporttitle=$matchiObj['sportdetail'][0]['title'];
                $subsporttitle=$matchiObj['subsportdetail'][0]['title'];
                 
                $match[$matchkey]['matchtime']=date('m-d-Y',($date."")/1000);
                $match[$matchkey]['sportcenterdetail.name']=$name;
                $match[$matchkey]['sportcenterdetail.address']=$address;
                $match[$matchkey]['sportdetail.title']=$sporttitle;
                $match[$matchkey]['subsportdetail.title']=$subsporttitle;
                
                foreach($matchiObj->userdetail as $suser){
                     $match[$matchkey]['userdetail.username']=$suser['username'];
                }
           
            }
            
        $totalCount = Match::count();
         $output = array(
            "sEcho" => intval($input['sEcho']),
            "iTotalRecords" => $totalCount,
            "iTotalDisplayRecords" => $matchcount,
            "aaData" => $match->toArray()
            );
       return response()->json($output);
	}
}
