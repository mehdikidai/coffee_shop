<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavItem extends Component
{


    public string $route;
    public string $icon;
    public string $label;
    public ?string $routeIs;

    public function __construct(string $route, string $icon, string $label, string $routeIs = null)
    {
        $this->route = $route;
        $this->icon = $icon;
        $this->label = $label;
        $this->routeIs = $routeIs;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav-item');
    }
}
