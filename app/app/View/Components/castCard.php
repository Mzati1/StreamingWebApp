<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class castCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $profileImage;
    public $actorName;
    public $characterName;

    public function __construct( $profileImage, $actorName, $characterName)
    {
        $this->profileImage = $profileImage;
        $this->actorName = $actorName;
        $this->characterName = $characterName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cast-card');
    }
}
