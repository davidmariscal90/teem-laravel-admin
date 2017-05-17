<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Field;
use App\Model\Subsport;
use App\Model\Sportcenter;

class FieldController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('field.index');
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
        $field=Field::find($id);
        $response=$field->delete();

        if ($response) {
            $message="Field delete successfully";
            $code=200;
        } else {
            $message="Someting went wrong try again";
            $code=400;
        }
        
        return response()->json(array('message'=>$message), $code);
    }
    public function fieldList(Request $request)
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

        //$searchText = $input['sSearch'];

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

        $searchData=$input['searchdata'];

        $regex=new \MongoDB\BSON\Regex($searchData, "^i");

        $orArr=array(
                        array(
                                'name' =>$regex
                            ),
                        array(
                            'price' =>$regex
                        ),
                        array(
                            'sportcenterdetail.name' =>$regex
                        ),
                         array(
                            'sportcenterdetail.address' =>$regex
                        )
                      );

        $field=Field::raw(function ($collection) use ($orArr) {
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
                                            '$unwind'=>array(
                                                "path"=>'$sportcenterdetail',
                                                "preserveNullAndEmptyArrays"=>true
                                            )
                                     ),
                                     array(
                                            '$lookup' => array(
                                                "from" => "user",
                                                "localField" => "sportcenterdetail.userid",
                                                "foreignField" => "_id",
                                                "as" => "sportcenterdetail.userdetail"
                                             )
                                           ),
                                    array(
                                           '$match'=>array(
                                                 '$or' => $orArr
                                            )
                                        ),
                                ));
        });

        $fieldcount=Field::raw(function ($collection) use ($orArr) {
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
                                            '$unwind'=>array(
                                                "path"=>'$sportcenterdetail',
                                                "preserveNullAndEmptyArrays"=>true
                                            )
                                     ),
                                     array(
                                            '$lookup' => array(
                                                "from" => "user",
                                                "localField" => "sportcenterdetail.userid",
                                                "foreignField" => "_id",
                                                "as" => "sportcenterdetail.userdetail"
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
        foreach ($fieldcount as $key => $value) {
            $fieldcount=$value->count;
        }
      
        
        foreach ($field as $fieldKey=>$fieldObj) {
            $sportArrObj=array();
            // print_r($fieldObj['name']);
            // print_r($fieldObj['price']);

             $sportArr=explode(',', $fieldObj['sport']);
            
            foreach ($sportArr as $subObj) {
                $sportArrObj[]=new \MongoDB\BSON\ObjectID($subObj);
            }
         
            $subsport=Subsport::raw(function ($collection) use ($sportArrObj) {
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
                                                 '_id'=>array('$in' => $sportArrObj)
                                            )
                                        )
                                )
                                );
            });
            $sportString="";
       
            foreach ($subsport as $subkey=>$sportsub) {
                $sportString.="<span class='badge label-success' style='border-radius:5px'>".$sportsub['sportdetail'][0]['title']." ".$sportsub['title']."</span> ";
            }
            $field[$fieldKey]['sport']=$sportString;
        }
        $totalCount = Field::count();
        $output = array(
            "sEcho" => intval($input['sEcho']),
            "iTotalRecords" => $totalCount,
            "iTotalDisplayRecords" => $fieldcount,
            "aaData" => $field->toArray()
            );
        return response()->json($output);
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

        //$searchText = $input['sSearch'];

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

        $searchData=$input['searchdata'];

        $regex=new \MongoDB\BSON\Regex($searchData, "^i");

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

        $sportcenter=Sportcenter::raw(function ($collection) use ($orArr) {
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

    public function sportcenterDestroy($id)
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
}
