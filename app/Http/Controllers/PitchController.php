<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Field;
use App\Model\Subsport;
use App\Model\Sportcenter;
use App\Model\Sports;
use Session;
use Redirect;

class PitchController extends Controller
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
		return view('pitch.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

		$sportcenterArr = Sportcenter::all();

		$sports  = Subsport::raw(function ($collection) {
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
											'$project' => array(
												"_id" => 1,
												"sportid" => 1,
												"title" => 1,
												"value" => 1,
												"sportdetail._id" =>1,
												"sportdetail.title" =>1,
												"sportdetail.imageurl" =>1,
											)
										)
										   ));
		});
		$sportArr = array();
		$sporttitle="";
		foreach ($sports as $key => $value) {
			if($sporttitle == (string)$value['sportdetail'][0]->title){
				$sportArr.push((string)$value['sportdetail'][0]->title);
				$sporttitle = (string)$value['sportdetail'][0]->title;
			}
			$sportArr[(string)$value['sportdetail'][0]->title][$value->_id] = (string)$value['sportdetail'][0]->title. " ".$value->title;
		}

		$sportcenters = Sportcenter::all();
		$sportCenterArr = $sportcenters->pluck('name','_id');

        return view('pitch.add',compact('sportArr','sportCenterArr'));
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
        'scid' => 'required',
        'name' => 'required',
        'covering' => 'required',
        'lights' => 'required',
        'surface' => 'required',
        'sport' => 'required',
        'price' => 'required',
        ]);

        $input=$request->all();
		$input=$request->except('_token');
		
		$subsportfull = Subsport::find($input['sport'][0]);
		$sportfull = Sports::find($subsportfull['sportid']);

		$input['sportname'] = $sportfull['title'];
		$input['scid']=new \MongoDB\BSON\ObjectID($input['scid']);
		$input['sport']=array_unique($input['sport']);
		$input['sport'] = implode(',',$input['sport']);
		$input['ispublic'] = true;
		$input['isreviewed'] = true;

        $pitchResult=Field::create($input);

        if($pitchResult){
            Session::flash('addsport', 'Pitch create successful!');
            return redirect()->route("pitch.index");
        }else{
            Session::flash('addsporterr', 'Pitch not create');
            return redirect()->route("pitch.create");
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
       $field=Field::find($id);
		$sportcenterArr = Sportcenter::all();		
		$sports  = Subsport::raw(function ($collection) {           
			 return $collection->aggregate(array(
				 array(
					 	'$lookup' => array( 
							  "from" => "sport",
							  "localField" => "sportid",
							  "foreignField" => "_id",
							  "as" => "sportdetail")
							  ),
							  array(
								  '$project' => array(
									  "_id" => 1,
									  "sportid" => 1,
									  "title" => 1,
									  "value" => 1,
									  "sportdetail._id" =>1,
									  "sportdetail.title" =>1,
									  "sportdetail.imageurl" =>1,
								  )
						  )	
				 ));
			});		
			$sportArr = array();		
			$sporttitle="";		
			foreach ($sports as $key => $value) {
				if($sporttitle == (string)$value['sportdetail'][0]->title)
				{	
					$sportArr.push((string)$value['sportdetail'][0]->title);
					$sporttitle = (string)$value['sportdetail'][0]->title;
				}

				$sportArr[(string)$value['sportdetail'][0]->title][$value->_id] = (string)$value['sportdetail'][0]->title. " ".$value->title;
			}

					$sportcenters = Sportcenter::all();
					$sportCenterArr = $sportcenters->pluck('name','_id');

					$field['sport']=explode(',',$field['sport']);

					//echo '<pre>'; print_r($field); exit;
        return view("pitch.edit",compact('field','sportArr','sportCenterArr'));
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
        $fieldid=new \MongoDB\BSON\ObjectID($id);
		$input=$request->except('_token','_method');
		$subsportfull = Subsport::find($input['sport'][0]);
		
		$sportfull = Sports::find($subsportfull['sportid']);
		$input['sportname'] = $sportfull['title'];
		$input['scid']=new \MongoDB\BSON\ObjectID($input['scid']);

		$input['sport']=array_unique($input['sport']);
		$input['sport'] = implode(',',$input['sport']);		
		$input['ispublic']=true;
		$input['isreviewed']=true;

		$field=Field::where('_id','=',$fieldid)
						->update($input);

		if($field){
			 	Session::flash('pitch', 'Pitch update successful!');
            	return redirect()->route("pitch.index");
        }else{
            	Session::flash('pitcherr', 'Pitch not update');
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
        $field=Field::find($id);
        $response=$field->delete();

        if ($response) {
            $message="Pitch delete successfully";
            $code=200;
        } else {
            $message="Someting went wrong try again";
            $code=400;
        }
        
        return response()->json(array('message'=>$message), $code);
    }


	public function getSports(){
		
		// return response()->json($sportArr);
	}

	public function pitchList(Request $request){
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
                            'name' =>$regex
                        ),       
                        array(
                            'covering' =>$regex
                        ),
                        array(
                            'lights' =>$regex
                        ),
						array(
                            'surface' =>$regex
                        ),
						array(
                            'price' =>$regex
                        )
				         
                      );


        $field=Field::raw(function ($collection) use ($orArr,$sortOrderArray,$iDisplayStart,$iDisplayLength) {
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

        $fieldcount=Field::raw(function ($collection) use ($orArr,$sortOrderArray,$iDisplayStart,$iDisplayLength) {
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

	public function pitchPublicStatus($id){
		$field=Field::find($id);
		if($field['ispublic']==false)
			$field->ispublic=true;
		else
			$field->ispublic=false;

		$status=$field->save();
		
		if($status){
			$message="Pitch update successfully";
            $code=200;
        } else {
            $message="Someting went wrong try again";
            $code=400;
        }
		return response()->json(array('message'=>$message), $code);
	}

	
}
