<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $users = User::all();

        if($user->id === 1){

            return response() ->json([
                'success' => true,
                'data' => $users,
            ]);

        } else {

            return response() ->json([
                'success' => false,
                'message' => 'You do not have permision.',
            ], 400);

        }
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = auth()->user();

        $user1 = User::where('id', '=', $user->id)->get();

        if(!$user){

            return response() ->json([
                'success' => false,
                'message' => 'User not found',
            ], 400);

        } else if ($user1->isEmpty()) {
            
            return response() ->json([
                'success' => false,
                'message' => 'User not found',
                ], 400);

        } 

        return response() ->json([
            'success' => true,
            'data' => $user1,
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
