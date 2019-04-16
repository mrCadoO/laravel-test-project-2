<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Corp\Repositories\PortfolioRepository;

class PortfolioController extends SiteController
{

    public function __construct(PortfolioRepository $p_rep){
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));

        $this->port_rep = $p_rep;
        $this->template = env('THEME').'.portfolios';
    }


    public function index() {
        $this->title = 'Portfolio';

        $portfolios = $this->getPortfolios();
        $content = view(env('THEME').'.portfolios_content')->with('portfolios', $portfolios)->render();
        $this->vars = array_add($this->vars, 'content', $content);


        return $this->renderOutput();
    }

    public function getPortfolios($take = false, $paginate = true){
        $portfolios = $this->port_rep->get('*', $take, $paginate);
        if($portfolios){
            $portfolios->load('filter');
        }
        return $portfolios;
    }

    public function show($alias){

        $portfolio = $this->port_rep->one($alias);
        $portfolios = $this->getPortfolios(config('settings.other_portfolios'), false);

        //create new content fo portfolio_content.blade
        $content = view(env('THEME'). '.portfolio_content')->with(['portfolios'=> $portfolios, 'portfolio' => $portfolio])->render();
        $this->vars = array_add($this->vars, 'content', $content);



        return $this->renderOutput();
    }



}
