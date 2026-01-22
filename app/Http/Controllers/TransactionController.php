<?php

namespace App\Http\Controllers;

use App\Models\ProcessedTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Check if transaction ID has been processed
    public function checkTransaction($transactionId)
    {
        $processed = ProcessedTransaction::where('transaction_id', $transactionId)->exists();
        return response()->json(['processed' => $processed]);
    }

    // Mark the transaction as processed
    public function markTransactionProcessed(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|string|unique:processed_transactions',
        ]);

        ProcessedTransaction::create(['transaction_id' => $request->transaction_id]);

        return response()->json(['success' => true]);
    }
}
