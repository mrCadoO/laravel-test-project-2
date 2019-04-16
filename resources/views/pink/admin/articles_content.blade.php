@if($articles)
    <div id="content-page" class="content group">
        <div class="hentry group">
            <h2>Добавление статьи</h2>
            <div class="short-table white">
                <table style="width:100% " cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="align-left">ID</th>
                            <th>Заголовок</th>
                            <th>Текст</th>
                            <th>Изображение</th>
                            <th>Категория</th>
                            <th>Псевдоним</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                            <tr>
                                <td class="align-left">{{ $article->id }}</td>
                                <td class="align-left"><a href="{{ route('admin.articles.edit',['articles' =>$article->alias]) }}">{{ $article->title }}</a></td>
                                <td class="align-left">{!!  str_limit($article->text, 200) !!}</td>
                                <td>
                                    @if(isset($article->img->mini))
                                        <img src="{{ asset(env('THEME')).'/images/articles/'.$article->img->mini }}">
                                    @endif
                                </td>
                                <td>{{ $article->category->title }}</td>
                                <td>{{ $article->alias }}</td>
                                <td>
                                    <form action="{{ route('admin.articles.destroy',['articles' => $article->alias]) }}" class="form-horizontal" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <input type="submit" name="submit" value="Delete" class="btn btn-french-5">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('admin.articles.create') }}"  class="btn btn-green">Добавить новую запись</a>
        </div>
    </div>
@endif
