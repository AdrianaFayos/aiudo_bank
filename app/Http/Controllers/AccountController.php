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
    public function show(Account $account)
    {
        //
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
    public function destroy(Account $account)
    {
        //
    }
}
