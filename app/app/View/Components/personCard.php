<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class personCard extends Component
{

    public $personID;
    public $name;
    public $knownForArray;
    public $image;

    public function __construct($personID, $name, $knownForArray, $image)
    {
        $this->personID = $personID;
        $this->name = $name;
        $this->knownForArray = $knownForArray;
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.person-card');
    }
}
