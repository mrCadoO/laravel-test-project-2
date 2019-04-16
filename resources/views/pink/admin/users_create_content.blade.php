<div id="content-page" class="content group">
    <div class="hentry group">
        <form action="{{ isset($user->id) ? route('admin.users.update', ['user' => $user->id]) : route('admin.users.store') }}" method="post" class="contact-form">
           {{ csrf_field() }}
            <ul>


                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Имя:</span>
                        <br/>
                        <span class="sublabel">Имя</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="name" value="{{ isset($user->id) ? $user->name : old('name') }}" placeholder="Введите имя" />
                    </div>
                </li>


                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Логин:</span>
                        <br/>
                        <span class="sublabel">Логин</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="login" value="{{ isset($user->id) ? $user->login : old('login') }}" placeholder="Введите логин" />
                    </div>
                </li>


                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Email:</span>
                        <br/>
                        <span class="sublabel">Email</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="email" value="{{ isset($user->id) ? $user->email : old('email') }}" placeholder="Введите Email" />
                    </div>
                </li>


                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Пароль:</span>
                        <br/>
                        <span class="sublabel">Пароль</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                        <input type="password" name="password" />
                    </div>
                </li>


                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Повтор пароля:</span>
                        <br/>
                        <span class="sublabel">Повтор пароля</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                        <input type="password" name="password_confirmation"  />
                    </div>
                </li>


                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Роль:</span>
                        <br/>
                        <span class="sublabel">Роль</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"></span>
                        {!! Form::select('role_id', $roles, isset($user->id) ? $user->roles()->first()->id : null) !!}
                    </div>
                </li>


                @if(isset($user->id))
                    <input type="hidden" name="_method" value="PUT" />
                @endif


                <li >
                    <input type="submit" value="Сохранить" name="submit" class="btn btn-the-salmon-dance-3" />
                </li>

            </ul>
        </form>
    </div>
</div>
