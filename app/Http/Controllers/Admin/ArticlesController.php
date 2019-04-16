<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Category;
use Illuminate\Http\Request;
use Corp\Http\Requests\ArticleRequest;
use \Gate;
use \Auth;
use Corp\Article;
use Corp\Repositories\ArticlesRepository;
use Corp\Http\Controllers\Controller;

class ArticlesController extends AdminController
{

    public function __construct(ArticlesRepository $a_rep){

        $this->a_rep = $a_rep;
        $this->template = env('THEME') . '.admin.articles';

        //****define**a**closure**based**middleware****//fix session(auth) related bug
        $this->middleware(function ($request, $next) {
        $this->user = Auth::user();

        //****authentication**check****//
        if(!$this->user){
            abort(403);
        }

        //****roles**check****//
        if(Gate::denies('VIEW_ADMIN_ARTICLES')) {
            abort(403);
        }
        return $next($request);
        });
    }


    public function index(){
        $this->title = 'Менеджер статей';
        $articles = $this->getArticles();
        $this->content = view(env('THEME').'.admin.articles_content')->with('articles', $articles)->render();
        $this->vars = array_add($this->vars, 'content', $this->content);
        return $this->renderOutput();
    }

    public function getArticles(){
        return $this->a_rep->get();
    }



    public function create(){
        if(Gate::denies('save', new \Corp\Article)){
            abort(403);
        }

        $this->title = 'Добавить новый материал';
        $categories = Category::select(['title', 'alias', 'parent_id', 'id'])->get();
        $lists = [];

        foreach($categories as $category){
            if($category->parent_id == 0){
                $lists[$category->title] = array();
            } else {
                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }
        $this->content = view(env('THEME'). '.admin.articles_create_content')->with('categories', $lists)->render();
        $this->vars = array_add($this->vars, 'content', $this->content);
        return $this->renderOutput();
    }





    public function store(ArticleRequest $request){
        $result = $this->a_rep->addArticle($request);
        if(is_array($result) && !empty($result['error'])){
            return back()->with($result);
        }
        return redirect('/admin')->with($result);
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






    public function edit($alias){
        $article = Article::where('alias', $alias)->first();

        if(!isset($article->id)){
            abort(403);
        }

        if(Gate::denies('edit', new Article)){
            abort(403);
        }

        if(isset($article->id)) {
            $article->img = json_decode($article->img);
        }

        $categories = Category::select(['title', 'alias', 'parent_id', 'id'])->get();
        $lists = [];

        foreach($categories as $category){
            if($category->parent_id == 0){
                $lists[$category->title] = array();
            } else {
                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }

        $this->title = 'Редактирование материала – ' . $this->title;

        $this->content = view(env('THEME'). '.admin.articles_create_content')->with(['article' => $article, 'categories' => $lists])->render();
        $this->vars = array_add($this->vars, 'content', $this->content);
        return $this->renderOutput();
    }



    public function update(ArticleRequest $request, $alias){
        $article = Article::where('alias', $alias)->first();

        $result = $this->a_rep->updateArticle($request, $article);
        if(is_array($result) && !empty($result['error'])){
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
    }



    public function destroy($alias){
        $article = Article::where('alias', $alias)->first();

        $result = $this->a_rep->deleteArticle($article);
        if(is_array($result) && !empty($result['error'])){
            return back()->with($result);
        }
        return redirect('/admin')->with($result);
    }
}
