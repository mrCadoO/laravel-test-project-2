<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Corp\Repositories\MenusRepository;
use Menu;

class SiteController extends Controller
{
    protected $port_rep;
    protected $slider_rep;
    protected $art_rep;
    protected $menu_rep;
    protected $comm_rep;

    protected $keywords;
    protected $meta_descriprion;
    protected $title;

    protected $template;
    protected $vars;

    protected $contentRightBar = FALSE;
    protected $contentLeftBar = FALSE;
    protected $bar = 'no';



    public function __construct(MenusRepository $menu_rep){
        $this->menu_rep = $menu_rep;
    }


    public function renderOutput(){
        $menu = $this->getMenu();
        $navigation = view(env('THEME').'.navigation')->with('menu', $menu)->render();
        $this->vars = array_add($this->vars,'navigation', $navigation);

        $footer = view(env('THEME').'.footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);

        $this->vars = array_add($this->vars, 'keywords', $this->keywords);
        //$this->vars = array_add($this->vars, 'meta_description', $this->meta_description);
        $this->vars = array_add($this->vars, 'title', $this->title);

        if($this->contentRightBar){
            $rigthBar = view(env('THEME').'.rightBar')->with('content_rightBar', $this->contentRightBar)->render();
            $this->vars = array_add($this->vars,'rightBar', $rigthBar);
        }

        if($this->contentLeftBar){
            $leftBar = view(env('THEME').'.leftBar')->with('content_leftBar', $this->contentLeftBar)->render();
            $this->vars = array_add($this->vars,'leftBar', $leftBar);
        }

        $this->vars = array_add($this->vars,'bar', $this->bar);

        return view($this->template)->with($this->vars);
    }



    public function getMenu(){
        $menu = $this->menu_rep->get();
        $m_builder = Menu::make('MyNav', function($m) use($menu) {
            foreach ($menu as $item){
                if($item->parent == 0){
                    $m->add($item->title, $item->path)->id($item->id);
                } else {
                    if($m->find($item->parent)){
                        $m->find($item->parent)->add($item->title, $item->path)->id($item->id);
                    }
                }
            }
        });
        return $m_builder;
    }

}
