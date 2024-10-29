<?php

class Aar {
    public $id;
    public $title;
    public $description;
    public $created_at;
    public $user_id;
    public $slug;
    public $isVisible;

    public function __construct($id, $title, $description, $created_at, $user_id, $slug, $isVisible) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->created_at = $created_at;
        $this->user_id = $user_id;
        $this->slug = $slug;
        $this->isVisible = $isVisible;
    }
}
