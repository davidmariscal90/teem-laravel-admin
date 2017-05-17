<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Invitation;
use Carbon\Carbon;
use DateTime;
class InvitationController extends Controller
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
       return view('invitation.index');
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
    public function invitationList(Request $request){
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
                            'senderuserdetail.username' =>$regex
                        ),
                         array(
                            'receiveruserdetail.username' =>$regex
                        )        
                      );

         $invitation=Invitation::raw(function ($collection) use ($orArr,$sortOrderArray,$iDisplayStart,$iDisplayLength) {
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
                                                "localField" => "inviterid",
                                                "foreignField" => "_id",
                                                "as" => "senderuserdetail"
                                             )
                                           ),
                                      array(
                                            '$lookup' => array(
                                                "from" => "user",
                                                "localField" => "userid",
                                                "foreignField" => "_id",
                                                "as" => "receiveruserdetail"
                                             )
                                           ),           
                                       array(
                                           '$match'=>array(
                                                 '$or' => $orArr,
                                                 '$and'=>array(array('accepted'=>'no'))
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

     
        $invitationcount=Invitation::raw(function ($collection) use ($orArr) {
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
                                                "localField" => "inviterid",
                                                "foreignField" => "_id",
                                                "as" => "senderuserdetail"
                                             )
                                           ),
                                      array(
                                            '$lookup' => array(
                                                "from" => "user",
                                                "localField" => "userid",
                                                "foreignField" => "_id",
                                                "as" => "receiveruserdetail"
                                             )
                                        ),
                                         array(
                                           '$match'=>array(
                                                 '$or' => $orArr,
                                                 '$and'=>array(array('accepted'=>'no'))
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

            foreach ($invitationcount as $key => $value) {
                $invitationcount=$value->count;
            }
            //echo '<pre>';
            foreach($invitation as $invikey=>$inviObj){
                $name=$inviObj['matchdetail']['sportcenterdetail'][0]['name'];
                $address=$inviObj['matchdetail']['sportcenterdetail'][0]['address'];
                $date=$inviObj['matchdetail']['matchtime'];
                 
                $invitation[$invikey]['matchdetail.matchtime']=date('m-d-Y',($date."")/1000);
                $invitation[$invikey]['matchdetail.sportcenterdetail.name']=$name;
                $invitation[$invikey]['matchdetail.sportcenterdetail.address']=$address;
                
                foreach($inviObj->senderuserdetail as $suser){
                     $invitation[$invikey]['senderuserdetail.username']=$suser['username'];
                }
                foreach($inviObj->receiveruserdetail as $iuser){
                     $invitation[$invikey]['receiveruserdetail.username']=$iuser['username'];
                }

            }
            
        $totalCount = Invitation::count();
         $output = array(
            "sEcho" => intval($input['sEcho']),
            "iTotalRecords" => $totalCount,
            "iTotalDisplayRecords" => $invitationcount,
            "aaData" => $invitation->toArray()
            );
       return response()->json($output);
    }
}
