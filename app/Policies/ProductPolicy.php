<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Product $product)
    {
        return true;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'seller']);
    }

    public function update(User $user, Product $product)
    {
        return $user->role === 'admin' || 
               ($user->role === 'seller' && $product->seller_id === $user->id);
    }

    public function delete(User $user, Product $product)
    {
        return $user->role === 'admin' || 
               ($user->role === 'seller' && $product->seller_id === $user->id);
    }
}
