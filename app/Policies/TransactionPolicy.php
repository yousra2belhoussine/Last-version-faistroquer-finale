<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->user_id || $user->id === $transaction->ad->user_id;
    }

    public function complete(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->ad->user_id && $transaction->status === 'pending';
    }

    public function cancel(User $user, Transaction $transaction): bool
    {
        return ($user->id === $transaction->user_id || $user->id === $transaction->ad->user_id)
            && $transaction->status === 'pending';
    }
} 