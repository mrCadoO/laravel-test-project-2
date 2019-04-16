<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Gate;
use Corp\User;
use Auth;
use Corp\Role;

class IndexController extends AdminController {

    public function __construct(){
        parent::__construct();

        $this->template = env('THEME') . '.admin.index';
    }


    public function index(){
        $this->title = 'Пынель администратора';
        return $this->renderOutput();
    }



}
