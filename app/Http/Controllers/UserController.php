<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use Session;
use Redirect;

class UserController extends Controller
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
		return view("user/index");
	    }
	
	
	/**
	* Show the form for creating a new resource.
	     *
	     * @return \Illuminate\Http\Response
	     */
	    public function create()
	    {

		return view("user/add");
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
            $userid=new \MongoDB\BSON\ObjectID($id);
            $user=User::find($userid);
            $user->toArray();
            return view('user/edit',compact('user'));
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
             $userid=new \MongoDB\BSON\ObjectID($id);
        
            $input=$request->all();

            $user=User::where('email','=',$input['email'])
                ->orWhere('username','=',$input['username'])
                ->where('_id','!=',$userid)
                ->get(); 

            if(count($user)==1){
                Session::flash('addusererr', 'Email or Username already exists');
                return Redirect::back();

            }else{
                
                 if(isset($input['isactive']) && $input['isactive']==1)
                        $input['isactive']=true;
                 else
                        $input['isactive']=false;
                

                $userupdate=User::where('_id','=',$userid)
                                ->update($input);

                if($userupdate){
                    Session::flash('adduser', 'User Update successful!');
                    return redirect()->route("user.index");
                }else{
                    Session::flash('addusererr', 'User not update');
                    return Redirect::back();
                }                       
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
            $userid=new \MongoDB\BSON\ObjectID($id);
            $user=User::where('_id','=',$userid)->delete();
            if($user){
                return response()->json(array('message'=>"User delete successfully "),200);
            }else{
                return response()->json(array('message'=>"User not found "),400);
            }
	}

	public function userList(Request $request){
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
                                'firstname' =>$regex
                            ),
                        array(
                                'lastname' =>$regex
                            ),
                        array(
                                'email' =>$regex
                            ),
                        array(
                                'username' =>$regex
                            ),
                        array(
                            'city' =>$regex
                        )  
                      );

        $userdetail=User::raw(function ($collection) use ($orArr,$sortOrderArray,$iDisplayStart,$iDisplayLength) {
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

            //count
             $usercount=User::raw(function ($collection) use ($orArr) {
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

             foreach ($usercount as $key => $value) {
                $usercount=$value->count;
            }

        $totalCount = User::count();
         $output = array(
            "sEcho" => intval($input['sEcho']),
            "iTotalRecords" => $totalCount,
            "iTotalDisplayRecords" => $usercount,
            "aaData" => $userdetail
            );
            //sleep(50);
        return response()->json($output);
	}
}
