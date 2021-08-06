<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Account;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $loans = Loan::all();

        if($user->id === 1){

            return response() ->json([
                'success' => true,
                'data' => $loans,
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
                'account_id' => 'required',
                'description' => 'required',
                'loan_money' => 'required',
                'paid_money' => 'required',
                'start_date' => 'required',
                'final_date' => 'required',
            ]);
    
            $loan = Loan::create ([
    
                'account_id' => $request -> account_id,
                'description' => $request -> description,
                'loan_money' => $request -> loan_money,
                'paid_money' => $request -> paid_money,
                'start_date' => $request -> start_date,
                'final_date' => $request -> final_date,

            ]);
    
            if($loan){

                $account = Account::find($request -> account_id);
                $total = $account->balance + $loan->loan_money ;

                $updated = $account->update([
                    'balance' => $total
                ]);

                if($updated){

                    return response() ->json([
                        'success' => true,
                        'data' => $loan
                    ], 200);

                } else {
                    return response() ->json([
                        'success' => false,
                        'message' => 'Loan can not be created',
                    ], 500);
                }
                
            }
    
            return response() ->json([
                'success' => false,
                'message' => 'Loan could not be created',
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
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = auth()->user();

        $account = Account::where('user_id', '=', $user->id)->get();

        $loan = Loan::where('account_id', '=', $account[0]->id)->get();

        if(!$loan){

            return response() ->json([
                'success' => false,
                'message' => 'Accounts not found',
            ], 400);

        } else if ($loan->isEmpty()) {
            
            return response() ->json([
                'success' => false,
                'message' => 'Accounts not found',
                ], 400);

        } 

        return response() ->json([
            'success' => true,
            'data' => $loan,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();

        if($user->id === 1){

            $loan = Loan::where('id', '=', $id);

            if($loan -> delete()) {
                return response() ->json([
                    'success' => true,
                    'message' => 'Loan deleted',
                ], 200);
                
            } else {
                return response() ->json([
                    'success' => false,
                    'message' => 'Loan can not be deleted',
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
