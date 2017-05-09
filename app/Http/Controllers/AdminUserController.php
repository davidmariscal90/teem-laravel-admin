<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Admin;
use Session;
use Redirect;
use Hash;

class AdminUserController extends Controller
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
        return view('adminuser/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminuser/add');
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
        'email' => 'required|unique:admin|max:255',
        'name' => 'required',
        'password'=>'required'
        ]);

        $request->except('confirmpassword');
        $input=$request->all();
        
        $admin=Admin::create( [
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password'])
            ]);

        if($admin){
            Session::flash('addadmin', 'Admin create successful!');
            return redirect()->route("admin.index");
        }else{
            Session::flash('addadminerr', 'Admin not create');
            return redirect()->route("admin/create");
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
        $adminid=new \MongoDB\BSON\ObjectID($id);
        $adminuser=Admin::find($adminid);
        $adminuser->toArray();
       
        return view('adminuser/edit',compact('adminuser'));
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
        $adminid=new \MongoDB\BSON\ObjectID($id);
        
        $input=$request->all();

        $admin=Admin::where('email','=',$input['email'])
                ->where('_id','!=',$adminid)
                ->get(); 

        if(count($admin)==1){
                Session::flash('addadminerr', 'Email alreay exist');
                return Redirect::back();
         }else{

            $adminuser=Admin::find($adminid);

            if (Hash::check($input['oldpassword'], $adminuser->password))
            {
                $adminuser->name=$input['name'];
                $adminuser->email=$input['email'];
                 
                if(isset($input['password'])){
                    $adminuser->password=bcrypt($input['password']);
                 }
                
                $adminupdate = $adminuser->save();
                
                if($adminupdate){
                    Session::flash('addadmin', 'Admin Update successful!');
                    return redirect()->route("admin.index");
                }else{
                    Session::flash('addadminerr', 'Admin not update');
                    return redirect()->route("admin.edit");   
                }

            }else{
                 Session::flash('addadminerr', 'Old password not match');
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
       $adminid=new \MongoDB\BSON\ObjectID($id);
       $admin=Admin::where('_id','=',$adminid)->delete();
       if($admin){
            return response()->json(array('message'=>"Admin delete successfully "),200);
       }else{
            return response()->json(array('message'=>"Admin not delete "),400);
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
                                'name' =>$regex
                            ),
                        array(
                            'email' =>$regex
                        ),       
                      );

        $admindetail=Admin::raw(function ($collection) use ($orArr,$sortOrderArray,$iDisplayStart,$iDisplayLength) {
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
             $usercount=Admin::raw(function ($collection) use ($orArr) {
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

        $totalCount = Admin::count();
         $output = array(
            "sEcho" => intval($input['sEcho']),
            "iTotalRecords" => $totalCount,
            "iTotalDisplayRecords" => $usercount,
            "aaData" => $admindetail
            );

        return response()->json($output);
	}
}
