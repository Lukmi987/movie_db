<?php
class Movie {
    private $film_id;
    private $title;
    private $description;
    private $releaseyear;
    private $length;

    // constructor
    public function __construct($film_id,$title, $description, $releaseyear, $length) {
        $this->film_id = $film_id;
        $this->title = $title;
        $this->description = $description;
        $this->releaseyear = $releaseyear;
        $this->length = $length;
    }

    // setter
    public function setFilmId($film_id) { $this->film_id = $film_id; }
    public function setTitle($title) { $this->title = $title; }
    public function setDescription($description) { $this->description = $description; }
    public function setReleaseYear($releaseyear) { $this->releaseyear = $releaseyear; }
    public function setLength($length) { $this->length = $length; }

    // getter
    public function getFilmId() { return $this->film_id; }
    public function getTitle() { return $this->title; }
    public function getDescription() { return $this->description; }
    public function getReleaseYear() { return $this->releaseyear; }
    public function getLength() { return $this->length;}
}

?>
