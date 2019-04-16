<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends SiteController
{

    public function __construct(){
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));

        $this->bar = 'left';
        $this->template = env('THEME').'.contacts';
    }

    public function index(Request $request){
        $this->title = 'Contacts';
        $content = view(env('THEME').'.contact_content')->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $this->contentLeftBar = view(env('THEME').'.contact_bar')->render();

        return $this->renderOutput();
    }



}
