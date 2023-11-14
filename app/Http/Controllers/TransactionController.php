<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //show all deposit
        $data = User::find(Auth::user()->id)->tansactions;
        return view('transaction.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //new deposit view
        return view('transaction.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // store transaction
        $validated = $request->validate([
            'amount' => 'required|numeric'
        ]);

        // monthly total Transaction
        $monthWithDrawalTransaction = User::find(Auth::user()->id)
            ->tansactions()
            ->where('transaction_type', '=', 'withdrawal')
            ->whereMonth('date', Carbon::now()->month)
            ->sum('amount');

        // total Transaction
        $totalWithDrawalTransaction = User::find(Auth::user()->id)
            ->tansactions()
            ->where('transaction_type', '=', 'withdrawal')
            ->sum('amount');

        $transaction                    = new Transaction();
        $transaction->user_id           = Auth::user()->id;
        $transaction->transaction_type  = $request->transaction_type;

        if ($request->transaction_type == 'withdrawal') {
            if (Auth::user()->balance < $request->amount) {
                return redirect()->back()
                    ->with('errorMsg', 'Insufficient Balance!');
            } else {
                $transaction->amount = $request->amount;
            }
            if (Auth::user()->account_type == 'individual') {
                if (date('l') == "Friday") {
                    $transaction->fee = 0;
                } elseif ($monthWithDrawalTransaction <= 5000) {
                    $transaction->fee = 0;
                } elseif ($request->amount <= 1000) {
                    $transaction->fee = 0;
                } else {
                    $request->amount - 1000 / 100 * 0.015;
                }
            } else {
                if (date('l') == "Friday") {
                    $transaction->fee = 0;
                } else {

                    if ($totalWithDrawalTransaction >= 50000) {
                        $transaction->fee = $request->amount / 100 * 0.015;
                    } elseif ($monthWithDrawalTransaction <= 5000) {
                        $transaction->fee = 0;
                    } elseif ($request->amount <= 1000) {
                        $transaction->fee = 0;
                    } else {
                        $transaction->fee  = $request->amount - 1000 / 100 * 0.025;
                    }
                }
            }
        } else {

            $transaction->amount = $request->amount;
            $transaction->fee = 0;
        }
        $transaction->date = date("Y-m-d");
        $transaction       = $transaction->save();

        $deposit = User::find(Auth::user()->id)
            ->tansactions()
            ->where('transaction_type', '=', 'deposit')
            ->sum('amount');
        $withdrawal = User::find(Auth::user()->id)
            ->tansactions()
            ->where('transaction_type', '=', 'withdrawal')
            ->sum('amount');
        $fee = User::find(Auth::user()->id)
            ->tansactions()
            ->sum('fee');
        $total_withdraw = $withdrawal + $fee;
        $balance        = $deposit - $total_withdraw;
        //dd($withdrawal);
        $user          = User::find(Auth::user()->id);
        $user->balance =  $balance;
        $user->update();
        //dd($monthTransaction);
        if ($transaction) {
            return redirect('/transaction')
                ->with('successMsg', 'Successed Transaction!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
