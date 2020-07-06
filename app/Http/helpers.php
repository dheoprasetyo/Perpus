<?php
function getRoleNames(App\User $user): string
{
    if ($user) {
        return ucwords($user->roles->pluck('name')->implode(', '));
    }
    return '';
}