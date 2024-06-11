<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TvCard extends Component
{
    public $imageURL;
    public $title;
    public $date;
    public $genreArray;
    public $rating;
    public $tvID;
    public $genreMap;

    public function __construct($imageURL, $title, $date, $genreArray, $rating, $tvID, $genreMap)
    {
        $this->imageURL = $imageURL;
        $this->title = $title;
        $this->date = $date;
        $this->genreArray = $genreArray;
        $this->tvID = $tvID;
        $this->genreMap = $genreMap;
        $this->rating = round($rating * 10, 2);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tv-card');
    }
}
