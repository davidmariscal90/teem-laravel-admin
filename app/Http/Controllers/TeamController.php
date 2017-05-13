<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Team;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('team.index');
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
    public function teamList(Request $request){
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
                                'matchdetail.sportcenterdetail.name' =>$regex
                            ),
                        array(
                            'matchdetail.sportcenterdetail.address' =>$regex
                        ),       
                        array(
                            'userdetail.username' =>$regex
                        )
                      );

         $team=Team::raw(function ($collection) use ($orArr,$sortOrderArray,$iDisplayStart,$iDisplayLength) {
            return $collection->aggregate(array(
                                    array(
                                            '$lookup' => array(
                                                "from" => "match",
                                                "localField" => "matchid",
                                                "foreignField" => "_id",
                                                "as" => "matchdetail"
                                             )
                                           ),
                                    array(
                                            '$unwind'=>array(
                                                "path"=>'$matchdetail',
                                                "preserveNullAndEmptyArrays"=>true
                                            )
                                     ),
                                     array(
                                            '$lookup' => array(
                                                "from" => "sportcenter",
                                                "localField" => "matchdetail.scid",
                                                "foreignField" => "_id",
                                                "as" => "matchdetail.sportcenterdetail"
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

     
        $teamcount=Team::raw(function ($collection) use ($orArr) {
                return $collection->aggregate(array(
                                         array(
                                            '$lookup' => array(
                                                "from" => "match",
                                                "localField" => "matchid",
                                                "foreignField" => "_id",
                                                "as" => "matchdetail"
                                             )
                                           ),
                                    array(
                                            '$unwind'=>array(
                                                "path"=>'$matchdetail',
                                                "preserveNullAndEmptyArrays"=>true
                                            )
                                     ),
                                     array(
                                            '$lookup' => array(
                                                "from" => "sportcenter",
                                                "localField" => "matchdetail.scid",
                                                "foreignField" => "_id",
                                                "as" => "matchdetail.sportcenterdetail"
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

            foreach ($teamcount as $key => $value) {
                $teamcount=$value->count;
            }
            //echo '<pre>';
            foreach($team as $teamkey=>$teamObj){
                $name=$teamObj['matchdetail']['sportcenterdetail'][0]['name'];
                $address=$teamObj['matchdetail']['sportcenterdetail'][0]['address'];
              
                $team[$teamkey]['matchdetail.sportcenterdetail.name']=$name;
                $team[$teamkey]['matchdetail.sportcenterdetail.address']=$address;
                
                foreach($teamObj->userdetail as $suser){
                     $team[$teamkey]['userdetail.username']=$suser['username'];
                }

                if($teamObj['teamid']==1)
                    $team[$teamkey]['teamid']="RED ARROWS";
                else 
                    $team[$teamkey]['teamid']="BLUE ARROWS";    
            }
            
        $totalCount = Team::count();
         $output = array(
            "sEcho" => intval($input['sEcho']),
            "iTotalRecords" => $totalCount,
            "iTotalDisplayRecords" => $teamcount,
            "aaData" => $team->toArray()
            );
       return response()->json($output);
    }
}
