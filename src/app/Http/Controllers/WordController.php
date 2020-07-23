<?php

namespace App\Http\Controllers;

use App\Word;
use Illuminate\Http\Request;
use App\Group;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $words=Group::with('words');

        if(request()->has('search') && !empty(request()->get('search'))){
            $words->where('name','like','%'.request()->get('search').'%');
        }

        $words->orderBy('created_at','desc')->paginate(100);

        return response()->json(['words'=>$words]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:words',
            'group_id'=> 'required'
        ]);

        Word::create($request->all());

        return response()->json(['message'=>'word_created']);
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
        $request->validate([
            'name'=>'required|unique:words',
            'group_id'=>'required'
        ]);

        $word=Word::findOrFail($id);

        $word->name=$request->name;
        $word->group_id=$request->group_id;
        $word->save();

        return response()->json(['message'=>'word_updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Word::where('id',$id)->delete();

        return response()->json(['message'=>'word_deleted']);
    }
}
