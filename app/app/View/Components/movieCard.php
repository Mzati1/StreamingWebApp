<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class movieCard extends Component
{
    public $imageURL;
    public $title;
    public $date;
    public $genreArray;
    public $rating;
    public $movieID;
    public $genreMap;

    public function __construct($imageURL, $title, $date, $genreArray, $rating, $movieID, $genreMap)
    {
        $this->imageURL = $imageURL;
        $this->title = $title;
        $this->date = $date;
        $this->genreArray = $genreArray;
        $this->movieID = $movieID;
        $this->genreMap = $genreMap;
        $this->rating = round($rating * 10,1);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.movie-card');
    }
}
