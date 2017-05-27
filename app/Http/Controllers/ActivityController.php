<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Activity;
use Session;

class ActivityController extends Controller
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
       return view('activity.index');
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
        //
    }

	public function activityList(Request $request) {
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
                                'userdetail.username' =>$regex
                            ),
                        array(
                                'activitydate' =>$regex
                            ),
                        array(
                                'activitytype' =>$regex
                            ),
                        array(
                                'onitem' =>$regex
                            ),
                        array(
                                'onactivityid' =>$regex
                            ),
                      );

        $activityDetails=Activity::raw(function ($collection) use ($orArr,$sortOrderArray,$iDisplayStart,$iDisplayLength) {
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

            //count
             $activitycount=Activity::raw(function ($collection) use ($orArr) {
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

             foreach ($activitycount as $key => $value) {
                $activitycount=$value->count;
             }
           
        $totalCount = Activity::count();
         $output = array(
            "sEcho" => intval($input['sEcho']),
            "iTotalRecords" => $totalCount,
            "iTotalDisplayRecords" => $activitycount,
            "aaData" => $activityDetails
            );
            sleep(1);
        return response()->json($output);
	}

	public function getActivities(Request $request,$nextPageNo, $perPage) {

		$iDisplayLength=$perPage;

        $iDisplayStart=($nextPageNo-1)*$perPage;

		$totalCount = Activity::count();

		$activities=Activity::raw(function ($collection) use ($iDisplayStart,$iDisplayLength) {
                return $collection->aggregate(array(
										array(
											'$lookup' => array(
                                                "from" => "user",
                                                "localField" => "userid",
                                                "foreignField" => "_id",
                                                "as" => "userdetail"
                                             )
										),
                                        // array(
                                        //         '$match'=>array(
                                        //              '$or' => $orArr
                                        //          )
                                        // ),
                                        array(
                                            '$sort'=> array(
												'_id' => -1
											)
                                        ),
                                        array(
                                            '$skip' => intval($iDisplayStart),
                                            ) ,
                                        array(
                                            '$limit'=>intval($iDisplayLength)
                                            )

                                    ));
            });
			$activityDetails = array(
				"active" => $nextPageNo,
				"totalCount" => $totalCount,
				"activities" => $activities
			);
		return $activityDetails;
	}
}
