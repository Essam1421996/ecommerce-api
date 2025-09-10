<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Order $order)
    {
        return $user->role === 'admin' || 
               $user->role === 'seller' || 
               $order->customer_id === $user->id;
    }

    public function create(User $user)
    {
        return $user->role === 'customer';
    }

    public function update(User $user, Order $order)
    {
        return $user->role === 'admin' || $user->role === 'seller';
    }

    public function delete(User $user, Order $order)
    {
        return $user->role === 'admin' || 
               ($user->role === 'customer' && $order->customer_id === $user->id);
    }
}