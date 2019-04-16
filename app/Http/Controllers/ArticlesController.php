<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Corp\Category;
use Corp\Repositories\SliderRepository;
use Corp\Repositories\PortfolioRepository;
use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\CommentsRepository;

class ArticlesController extends SiteController
{
    public function __construct(PortfolioRepository $p_rep, ArticlesRepository $a_rep, CommentsRepository $c_rep){
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));

        $this->port_rep = $p_rep;
        $this->art_rep = $a_rep;
        $this->comm_rep = $c_rep;
        $this->bar = 'right';
        $this->template = env('THEME').'.articles';
    }

    public function index($cat_alias = FALSE) {
        $articles = $this->getArticles($cat_alias);
        $content = view(env('THEME').'.articles_content')->with('articles', $articles)->render();
        $this->vars = array_add($this->vars, 'content', $content);
        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));
        $this->contentRightBar = view(env('THEME'). '.articlesBar')->with(['comments' => $comments, 'portfolios' => $portfolios])->render();
        return $this->renderOutput();
    }



    public function getArticles($alias = FALSE){

        $where = false;
        if($alias){
            $id = Category::select('id')->where('alias', $alias)->first()->id;
            $where = ['category_id', $id];
        }

        $articles = $this->art_rep->get(['id', 'title', 'alias', 'created_at', 'img', 'desc', 'user_id', 'category_id'], false, true, $where);
        if($articles){
            $articles->load('user', 'category', 'comments');
        }
        return $articles;
    }

    public function getComments($take){
        $comments = $this->comm_rep->get(['text', 'name', 'email', 'site', 'article_id'], $take);
        if($comments){
            $comments->load('article', 'user');
        }
        return $comments;
    }

    public function getPortfolios($take ){
        $portfolios = $this->port_rep->get(['title', 'text', 'alias', 'customer', 'img', 'filter_alias'], $take);
        return $portfolios;
    }

    public function show($alias = false){
        $article = $this->art_rep->one($alias, ['comments' => true]);

        //decoding img with json format
        if(isset($article->id)){
            $article->img = json_decode($article->img);
         }

        //create new content fo article_content.blade
        $content = view(env('THEME'). '.article_content')->with('article', $article)->render();
        $this->vars = array_add($this->vars, 'content', $content);


        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));
        $this->contentRightBar = view(env('THEME'). '.articlesBar')->with(['comments' => $comments, 'portfolios' => $portfolios])->render();


        return $this->renderOutput();
    }


}
