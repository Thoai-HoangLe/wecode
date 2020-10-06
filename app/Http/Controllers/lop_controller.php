<?php

namespace App\Http\Controllers;

use App\Lop;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class lop_controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); // phải login
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // if ( ! in_array( Auth::user()->role->name, ['admin', 'head_instructor', 'instructor']) )
        //     abort(403);
        return view('admin.lops.list', ['lops' => Lop::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if ( ! in_array( Auth::user()->role->name, ['admin', 'head_instructor', 'instructor']) )
            abort(403);
        return view('admin.lops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( ! in_array( Auth::user()->role->name, ['admin', 'head_instructor', 'instructor']) )
            abort(403);
        //
        // var_dump($request->input());die();
        $a = $request->only('name');
        $a['open'] = $request->input('open') === 'on';

        $new = Lop::create($a);
        $usernames = preg_split("/[\s,]+/", $request->input('user_list'));
        if($usernames != []){
            $users = User::WhereIn('username', $usernames)->get();
            $userids = $users->reduce(function($carry, $i){
                array_push($carry, $i->id);
                return $carry;
            }, []);
            
            $new->users()->sync($userids);
        }
        return redirect()->route('lops.show', ['lop' => $new]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lop  $lop
     * @return \Illuminate\Http\Response
     */
    public function show(Lop $lop)
    {
        //
        // if ( ! in_array( Auth::user()->role->name, ['admin', 'head_instructor', 'instructor']) )
            // abort(403);
        return view('admin.lops.edit', ['lop' => $lop]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lop  $lop
     * @return \Illuminate\Http\Response
     */
    public function edit(Lop $lop)
    {
        if ( ! in_array( Auth::user()->role->name, ['admin', 'head_instructor', 'instructor']) )
            abort(403);
        return view('admin.lops.edit', ['lop' => $lop]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lop  $lop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lop $lop)
    {
        //
        if ( ! in_array( Auth::user()->role->name, ['admin', 'head_instructor', 'instructor']) )
            abort(403);
        $data = $request->only('name');
        $data['open'] = $request->input('open') == 'on';

        $lop->update($data);

        // var_dump($request->input());die();

        $remove = $request->input('remove');
        if($remove != NULL){
            $lop->users()->detach($remove);
        }

        $usernames = preg_split("/[\s,]+/", $request->input('user_list'));
        if($usernames != []){
            $users = User::WhereIn('username', $usernames)->get();
            $userids = $users->reduce(function($carry, $i){
                array_push($carry, $i->id);
                return $carry;
            }, []);
            
            $lop->users()->attach($userids);
        }

        return redirect()->route('lops.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lop  $lop
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 
        if ( ! in_array( Auth::user()->role->name, ['admin', 'head_instructor']) )
            abort(403);
        elseif ($id === NULL)
			$json_result = array('done' => 0, 'message' => 'Input Error');
        else
        {
            Lop::destroy($id);
            $json_result = array('done' => 1);
        }
        header('Content-Type: application/json; charset=utf-8');  
        return ($json_result);
    }

    public function enrol(Request $request, Lop $lop, $in){
        if($in == 1){
            if ($lop->open == 1) $lop->users()->attach(Auth::user()->id);
        }
        else {
            $lop->users()->detach(Auth::user()->id);
        }
        return redirect()->back();
    }
}
