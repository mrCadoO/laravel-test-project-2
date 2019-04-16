<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Http\Requests\UserRequest;
use Corp\Repositories\RolesRepository;
use Corp\Repositories\UsersRepository;
use Corp\User;
use \Gate;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;

class UsersController extends AdminController {

    protected $rol_rep;
    protected $user_rep;

    public function __construct(RolesRepository $rol_rep, UsersRepository $user_rep){
        parent::__construct();

        $this->middleware(function ($request, $next) {
            if(Gate::denies('EDIT_USERS')){
                abort(403);
            }

            if(Gate::denies('CREATE_USERS')){
                abort(403);
            }

            return $next($request);
        });

        $this->rol_rep = $rol_rep;
        $this->user_rep = $user_rep;

        $this->template = env('THEME'). '.admin.users';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $users = $this->user_rep->get();
        $this->content = view(env('THEME').'.admin.users_content')->with('users', $users)->render();
        $this->vars = array_add($this->vars, 'content', $this->content);

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $this->title = 'Новый пользователь';

        $roles = $this->getRoles()->reduce(function($returnRoles, $role){
            $returnRoles[$role->id] = $role->name;
            return $returnRoles;
        }, []);

        $this->content = view(env('THEME').'.admin.users_create_content')->with('roles', $roles)->render();
        $this->vars = array_add($this->vars, 'content', $this->content);

        return $this->renderOutput();
    }

    public function getRoles(){
        return $this->rol_rep->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request){

        $result = $this->user_rep->addUser($request);
        if(is_array($result) && !empty($result['error'])){
            return back()->with($result);
        }

        return redirect('/admin/users')->with($result);
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
    public function edit($id){

        $user = User::where('id', $id)->first();

        $this->title = 'Редактирование пользователя – '. $user->name;

        $roles = $this->getRoles()->reduce(function($returnRoles, $role){
                $returnRoles[$role->id] = $role->name;
                return $returnRoles;
            }, []);

        $this->content = view(env('THEME').'.admin.users_create_content')->with(['user' => $user, 'roles' => $roles])->render();
        $this->vars = array_add($this->vars, 'content', $this->content);

       return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id){

        $user = User::where('id', $id)->first();

        $result = $this->user_rep->updateUser($request, $user);
        if(is_array($result) && !empty($result['error'])){
            return back()->with($result);
        }

        return redirect('/admin/users')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){

        $user = User::where('id', $id)->first();

        $result = $this->user_rep->deleteUser($user);
        if(is_array($result) && !empty($result['error'])){
            return back()->with($result);
        }

        return redirect('/admin/users')->with($result);
    }
}
