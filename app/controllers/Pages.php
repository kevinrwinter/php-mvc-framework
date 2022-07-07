<?php
class Pages extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {

        $data = [
            'title' => 'PHP MVC Framework',
        ];

        $this->loadView('pages/index', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About page',
        ];

        $this->loadView('pages/about', $data);
    }
}
