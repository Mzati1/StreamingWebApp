<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class showImageSnapshot extends Component
{
    /**
     * Create a new component instance.
     */

     public $imageURL;
     public $imageHeight;
     public $imageWidth;


    public function __construct($imageURL, $imageHeight, $imageWidth)
    {
        $this->imageURL = $imageURL;
        $this->imageHeight = $imageHeight;
        $this->imageWidth = $imageWidth;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.movie-image-snapshot');
    }
}
