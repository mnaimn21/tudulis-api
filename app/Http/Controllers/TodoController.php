<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Auth;

class TodoController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $todo = Todo::where('user_id', $user_id)->get();
        
        return(
            response()->json([
                "success" => true,
                "message" => "Successfully retrieve user's todo list",
                "data" => $todo
            ],200)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $todo = Todo::create([
            'user_id' => $user_id,
            'title' => $request->title,
            'desc' => $request->desc,
        ]);
        return(
            response()->json([
                "success" => true,
                "message" => "Successfully create a todo",
                "data" => $todo
            ],201)
        );
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = Auth::user()->id;
        $todo = Todo::find($id);

        if(is_null($todo)){
            return(
                response()->json([
                    "success" => false,
                    "message" => "Data not found",
                    "data" => null
                ],404)
            );
        }

        if($user_id != $todo->user_id){
            return(
                response()->json([
                    "success" => false,
                    "message" => "You dont have the authority to do this",
                    "data" => null
                ],400)
            );
        }
        return(
            response()->json([
                "success" => true,
                "message" => "Successfully single todo data",
                "data" => $todo
            ],200)
        );


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
        $user_id = Auth::user()->id;
        $todo = Todo::find($id);

        if(is_null($todo)){
            return(
                response()->json([
                    "success" => false,
                    "message" => "Data not found",
                    "data" => null
                ],404)
            );
        }

        if($user_id != $todo->user_id){
            return(
                response()->json([
                    "success" => false,
                    "message" => "You dont have the authority to do this",
                    "data" => null
                ],400)
            );
        }

        $todo->update([
            'title' => $request->title,
            'desc' => $request->desc,
        ]);

        return(
            response()->json([
                "success" => true,
                "message" => "Successfully edit todo data",
                "data" => $todo
            ],200)
        );
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = Auth::user()->id;
        $todo = Todo::find($id);

        if(is_null($todo)){
            return(
                response()->json([
                    "success" => false,
                    "message" => "Data not found",
                    "data" => null
                ],404)
            );
        }

        if($user_id != $todo->user_id){
            return(
                response()->json([
                    "success" => false,
                    "message" => "You dont have the authority to do this",
                    "data" => null
                ],400)
            );
        }

        Todo::destroy($id);
        return(
            response()->json([
                "success" => true,
                "message" => "Successfully delete todo data",
                "data" => null
            ],204)
        );
    }

    public function toggleTaskCompletion($id){
        $user_id = Auth::user()->id;
        $todo = Todo::find($id);

        if(is_null($todo)){
            return(
                response()->json([
                    "success" => false,
                    "message" => "Data not found",
                    "data" => null
                ],404)
            );
        }

        if($user_id != $todo->user_id){
            return(
                response()->json([
                    "success" => false,
                    "message" => "You dont have the authority to do this",
                    "data" => null
                ],400)
            );
        }

        $todo->update([
            'is_done' => !$todo->is_done,
        ]);

        return(
            response()->json([
                "success" => true,
                "message" => $todo->is_done ? "Successfully completed the todo" : "Successfully revoke back todo completion",
                "data" => null
            ],200)
        );
    }
}
