<?php

namespace MVC\controllers;

use MVC\core\controller;

class PageController extends controller{

    public function aboutUs()
    {
        return $this->view('pages/about-us',[]);
    }

    public function fqa()
    {
        return $this->view('pages/fqa',[]);
    }

    public function termsAndConditions()
    {
        return $this->view('pages/terms-and-conditions',[]);
    }

    public function privacyPolicy()
    {
        return $this->view('pages/privacy-policy',[]);
    }
}