<div id="content-page" class="content group">
    <div class="hentry group">
        <form action="{{ isset($menu->id) ? route('admin.menus.update', ['menus' => $menu->id]) : route('admin.menus.store') }}" method="post" class="contact-form" >
            {{ csrf_field() }}
            <ul>

                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Название:</span>
                        <br />
                        <span class="sublabel">Заголовок пункта</span>
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" value="{{ isset($menu->title) ? $menu->title : old('title') }}" name="title" placeholder="Введите название страницы">
                    </div>
                </li>


                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Родительский пункт меню:</span>
                        <br />
                        <span class="sublabel">Родитель:</span><br />
                    </label>
                    <div class="input-prepend">
                        {!! Form::select('parent', $menus, isset($menu->parent) ? $menu->parent : old('parent')) !!}
                    </div>
                </li>

            </ul>

            <h3><span class="label">Пользовательская ссылка</span></h3>
            <ul>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Путь для ссылки:</span>
                        <br />
                        <span class="sublabel">Путь для ссылки</span>
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" value="{{ isset($menu->path) ? $menu->path : old('path') }}" name="custom_link" placeholder="Введите путь для ссылки">
                    </div>
                    <br/>
                    <div style="clear: both;"></div>
                </li>

                <li class="submit-button">
                    <input type="submit" class="btn btn-the-salmon-dance-1" value="Сохранить">
                </li>

            </ul>
        </form>
    </div>
</div>
