<?php

namespace App\View\Components;

use Illuminate\View\Component;

class window extends Component
{
    public $title;
    public $poster;
    public $genre;
    public $rating;

    /**
     * Create a new component instance.
     *
     * @param  string  $title
     * @param  string  $poster
     * @param  string  $genre
     * @param  float  $rating
     * @return void
     */
    public function __construct($title, $poster, $genre, $rating)
    {
        $this->title = $title;
        $this->poster = $poster;
        $this->genre = $genre;
        $this->rating = $rating;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.window');
    }
}
