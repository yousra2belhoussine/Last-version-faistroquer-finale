<?php

namespace App\Policies;

use App\Models\Proposition;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropositionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the proposition.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposition  $proposition
     * @return bool
     */
    public function view(User $user, Proposition $proposition)
    {
        return $user->id === $proposition->user_id || $user->id === $proposition->ad->user_id;
    }

    /**
     * Determine whether the user can send messages in the proposition.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposition  $proposition
     * @return bool
     */
    public function message(User $user, Proposition $proposition)
    {
        return $this->view($user, $proposition) && !$proposition->isCompleted() && !$proposition->isRejected();
    }

    /**
     * Determine whether the user can accept the proposition.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposition  $proposition
     * @return bool
     */
    public function accept(User $user, Proposition $proposition)
    {
        return $user->id === $proposition->ad->user_id && $proposition->isPending();
    }

    /**
     * Determine whether the user can reject the proposition.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposition  $proposition
     * @return bool
     */
    public function reject(User $user, Proposition $proposition)
    {
        return $user->id === $proposition->ad->user_id && $proposition->isPending();
    }

    /**
     * Determine whether the user can cancel the proposition.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposition  $proposition
     * @return bool
     */
    public function cancel(User $user, Proposition $proposition)
    {
        return ($user->id === $proposition->user_id || $user->id === $proposition->ad->user_id) &&
            ($proposition->isPending() || $proposition->isAccepted());
    }

    /**
     * Determine whether the user can complete the proposition.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposition  $proposition
     * @return bool
     */
    public function complete(User $user, Proposition $proposition)
    {
        return $user->id === $proposition->ad->user_id && $proposition->isAccepted();
    }

    /**
     * Determine whether the user can update the meeting details.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposition  $proposition
     * @return bool
     */
    public function updateMeeting(User $user, Proposition $proposition)
    {
        return $this->view($user, $proposition) && $proposition->isAccepted() && !$proposition->isCompleted();
    }
} 