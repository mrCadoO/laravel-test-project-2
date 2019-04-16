<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use \Auth;
use \Menu;
use \Gate;

class AdminController extends \Corp\Http\Controllers\Controller {

    protected $p_rep;
    protected $a_rep;
    protected $user;
    protected $template;
    protected $content;
    protected $title;
    protected $vars;


    public function __construct(){
        //****define**a**closure**based**middleware****//fix session(auth) related bug
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            //****authentication**check****//
            if(!$this->user){
                abort(403);
            }

            //****roles**check****//
            if(Gate::denies('VIEW_ADMINS')) {
                abort(403);
            }

           return $next($request);
        });


    }


    public function renderOutput(){
        $this->vars = array_add($this->vars, 'title', $this->title);

        $menu = $this->getMenu();
        $navigation = view(env('THEME').'.admin.navigation')->with('menu', $menu)->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        $footer = view(env('THEME').'.admin.footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars);
    }




    public function getMenu(){
        return Menu::make('adminMenu', function($menu){
            $menu->add('Статьи', ['route' => 'admin.articles.index']);
            $menu->add('Меню', ['route' => 'admin.menus.index']);
            $menu->add('Пользователи', ['route' => 'admin.users.index']);
            $menu->add('Привилегии', ['route' => 'admin.permissions.index']);
        });
    }



}
