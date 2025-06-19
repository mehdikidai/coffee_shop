<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Search extends Component
{

    public $search = null;


    public function boot()
    {
        if (!Auth::check()) {
            abort(403);
        }
    }


    public function render()
    {

        $search = $this->search;

        $results = $this->search
            ? Product::where('name', 'like', "%{$this->search}%")->limit(15)->get()
            : collect();

        return view('livewire.search', compact('search', 'results'));
    }
}
