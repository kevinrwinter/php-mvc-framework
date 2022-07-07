<?php
/*
 * Base controller – loads models and views
 */
class Controller
{
    // Load model
    public function loadModel($model)
    {
        // Require model file
        require_once '../app/models/' . $model . '.php';

        // Instantiate model
        return new $model();
    }

    // Load view
    public function loadView($view, $data = [])
    {
        // Check for file
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die('View does not exist');
        }
    }
}
