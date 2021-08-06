<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Account;
use App\Models\Loan;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $payments = Payment::all();

        if($user->id === 1){

            return response() ->json([
                'success' => true,
                'data' => $payments,
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

        $account = Account::find($request->account_id);

        if ($user->id === $account->user_id) {

            $this->validate( $request , [
                'account_id' => 'required',
                'loan_id' => 'required',
                'concept' => 'required',
                'paid_money' => 'required',
            ]);

            $payment = Payment::create ([
                'account_id' => $request -> account_id,
                'loan_id' => $request -> loan_id,
                'concept' => $request -> concept,
                'paid_money' => $request -> paid_money,
            ]);

            if($payment){

                $loan = Loan::find($request -> loan_id);

                $total_account = $account->balance - $payment->paid_money ;

                $total_loan = $loan->paid_money + $payment->paid_money ;

                $updated_account = $account->update([
                    'balance' => $total_account
                ]);

                $updated_loan = $loan->update([
                    'paid_money' => $total_loan
                ]);

                if($updated_loan && $updated_account){

                    return response() ->json([
                        'success' => true,
                        'data' => $payment
                    ], 200);

                } else {
                    return response() ->json([
                        'success' => false,
                        'message' => 'Payment could not be created',
                    ], 500);
                }
            }

            return response() ->json([
                'success' => false,
                'message' => 'Payment could not be done',
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
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = auth()->user();

        $account = Account::where('user_id', '=', $user->id)->get();

        $payment = Payment::where('account_id', '=', $account[0]->id)->get();

        if(!$payment){

            return response() ->json([
                'success' => false,
                'message' => 'Payments not found',
            ], 400);

        } else if ($payment->isEmpty()) {
            
            return response() ->json([
                'success' => false,
                'message' => 'Payments not found',
                ], 400);

        } 

        return response() ->json([
            'success' => true,
            'data' => $payment,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
