<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class onlyAdmin extends Component
{
    /**
     * Create a new component instance.
     */
    public function shouldRender(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.only-admin');
    }
}
