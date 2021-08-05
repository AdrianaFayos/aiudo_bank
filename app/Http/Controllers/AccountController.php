<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $accounts = Account::all();

        if($user->id === 1){

            return response() ->json([
                'success' => true,
                'data' => $accounts,
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
        
        $user = auth()->user();

        if($user->id === 1){

            $this->validate( $request , [
                'user_id' => 'required',
                'name' => 'required',
                'description' => 'required',
                'iban' => 'required',
                'balance' => 'required',
                'maintenance_price' => 'required',
               

            ]);
    
            $account = Account::create ([
    
                'user_id' => $request -> user_id,
                'name' => $request -> name,
                'description' => $request -> description,
                'iban' => $request -> iban,
                'balance' => $request -> balance,
                'maintenance_price' =>  $request -> maintenance_price,

            ]);
    
            if($account){
    
                return response() ->json([
                    'success' => true,
                    'data' => $account
                ], 200);
    
            }
    
            return response() ->json([
                'success' => false,
                'message' => 'Account not created',
            ], 500);

        } else {

            return response() ->json([
                'success' => false,
                'message' => 'You do not have permision.',
            ], 400);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = auth()->user();

        $account = Account::where('user_id', '=', $user->id)->get();

        if(!$user){

            return response() ->json([
                'success' => false,
                'message' => 'Accounts not found',
            ], 400);

        } else if ($account->isEmpty()) {
            
            return response() ->json([
                'success' => false,
                'message' => 'Accounts not found',
                ], 400);

        } 

        return response() ->json([
            'success' => true,
            'data' => $account,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();

        if($user->id === 1){

            $account = Account::where('id', '=', $id);

            if($account -> delete()) {
                return response() ->json([
                    'success' => true,
                    'message' => 'Account deleted',
                ], 200);
                
            } else {
                return response() ->json([
                    'success' => false,
                    'message' => 'Account can not be deleted',
                ], 500);
            }
     

        } else {

            return response() ->json([
                'success' => false,
                'message' => 'You do not have permision.',
            ], 400);

        }
    }
}
