<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\ArticlesRepository;
use Illuminate\Http\Request;
use Corp\Repositories\SliderRepository;
use Corp\Repositories\PortfolioRepository;

use Config;


class IndexController extends SiteController
{
    public function __construct(SliderRepository $s_rep, PortfolioRepository $p_rep, ArticlesRepository $a_rep){
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));

        $this->port_rep = $p_rep;
        $this->art_rep = $a_rep;
        $this->slider_rep = $s_rep;
        $this->bar = 'right';
        $this->template = env('THEME').'.index';
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {

        $portfolios = $this->getPortfolio();
        $content = view(env('THEME').'.content')->with('portfolios', $portfolios)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $articles = $this->getArticles();
        $this->contentRightBar = view(env('THEME'). '.indexBar')->with('articles', $articles)->render();

        $sliderItems = $this->getSliders();
        $slider = view(env('THEME'). '.slider')->with('sliders', $sliderItems)->render();
        $this->vars = array_add($this->vars, 'sliders', $slider);

        $this->keywords = 'Home page';
        $this->meta_description = 'Home page';
        $this->title = 'Home page';

        return $this->renderOutput();
    }

    public function getSliders(){
        $sliders = $this->slider_rep->get();
        if($sliders->isEmpty()){
            return FALSE;
        }
        $sliders->transform(function($item, $key){
            $item->img = Config::get('settings.slider_path').'/'.$item->img;
            return $item;
        });
        return $sliders;
    }

    protected function getPortfolio(){
        $portfolio = $this->port_rep->get('*', Config::get('settings.home_port_count'));
        return $portfolio;
    }

    protected function getArticles(){
        $articles = $this->art_rep->get(['title', 'created_at', 'img', 'alias'], Config::get('settings.home_articles_count'));
        return $articles;
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
