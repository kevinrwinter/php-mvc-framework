<?php
/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */
class Core
{
    protected $current_controller = 'Pages';
    protected $current_method     = 'index';
    protected $params             = [];

    public function __construct()
    {
        // print_r($this->getUrl());

        $url = $this->getUrl();

        // Check if URL matches file in controllers directory
        if (isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            // Set as controller
            $this->current_controller = ucwords($url[0]);
            // Unset 0 index
            unset($url[0]);
        }

        // Require the controller
        require_once '../app/controllers/' . $this->current_controller . '.php';

        // Create instance of controller class
        $this->current_controller = new $this->current_controller;

        // Check for second part or URL
        if (isset($url[1])) {
            // Check if method exists in controller
            if (method_exists($this->current_controller, $url[1])) {
                $this->current_method = $url[1];
                // Unset 1 index
                unset($url[1]);
            }
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        // Callback with array of params
        call_user_func_array([$this->current_controller, $this->current_method], $this->params);
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }
    }
}
