<div id="content-page" class="content group">
    <div class="hentry group">
        <form action="{{ isset($article->id) ? route('admin.articles.update', ['articles' => $article->alias]) : route('admin.articles.store') }}" method="post" class="contact-form" enctype="multipart/form-data" >
            {{ csrf_field() }}
            <ul>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Название:</span>
                        <br />
                        <span class="sublabel">Заголовок материала</span>
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" value="{{ isset($article->title) ? $article->title : old('title') }}" name="title" placeholder="Введите название страницы">
                    </div>
                </li>


                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Псевдоним:</span>
                        <br />
                        <span class="sublabel">Заголовок материала</span>
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" value="{{ isset($article->alias) ? $article->alias : old('alias') }}" name="alias" placeholder="Введите псевдоним">
                    </div>
                </li>


                <li class="textarea-field">
                    <label for="name-contact-us">
                        <span class="label">Краткое описание:</span>
                        <br />
                    </label>
                   <div class="input-prepend"><span class="add-on"><i class="icon-pencil"></i></span>
                        <textarea id="editor" class="form-control" name="desc">{{ isset($article->desc) ? $article->desc : old('desc') }}</textarea>
                   </div>
                </li>


                <li class="textarea-field">
                    <label for="name-contact-us">
                        <span class="label">Oписание:</span>
                        <br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-pencil"></i></span>
                        <textarea id="editor" class="form-control" name="text">{{ isset($article->text) ? $article->text : old('text') }}</textarea>
                    </div>
                </li>


                @if(isset($article->img->path))
                    <li class="textarea-field">
                        <label>
                            <span class="label">Изображение материала:</span>
                        </label>
                        <img src="{{asset(env('THEME')).'/images/articles/'.$article->img->path}}">
                        <input type="hidden" name="old_image" value="{{ $article->img->path }}">
                    </li>
                @endif


                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Изображение:</span>
                        <br />
                        <span class="sublabel">Изображение материала:</span><br />
                    </label>
                    <div class="input-prepend">
                        {!! Form::file('image', ['class'=>'filestyle','data-buttonText'=>'Выбирите изображение', 'data-buttonName'=>'btn-primary', 'data-placeholder'=>'Файла нет']) !!}
                    </div>
                </li>


                <li class="text-field">
                    <label for="name-contact-us">
                    <span class="label">Категория:</span>
                    <br />
                    <span class="sublabel">Категория материала:</span><br />
                    </label>
                    <div class="input-prepend">
                        {!! Form::select('category_id', $categories, isset($article->category_id) ? $article->category_id : '') !!}
                    </div>
                </li>


                @if(isset($article->id))
                    <input type="hidden" name="_method" value="PUT">
                @endif


                <li class="submit-button">
                    <input type="submit" class="btn btn-the-salmon-dance-1" value="Сохранить">
                </li>

            </ul>
        </form>
    </div>
</div>
