<div id="content page" class="content group">
    <div class="hentry group">
        <h3 class="title-page">Пользователи</h3>
        <div class="short-table white">
            <table style="width: 100%" cellpadding="0" cellspacing="0">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Login</th>
                    <th>Role</th>
                    <th>Удалить</th>
                </thead>

                @if($users)
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><a href="{{ route('admin.users.edit', ['users' => $user->id]) }}">{{ $user->name }}</a></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->login }}</td>
                            <td>{{ $user->roles->implode('name', ',') }}</td>
                            <td>
                                <form method="post" action="{{ route('admin.users.destroy', ['users' => $user->id]) }}" class="">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="submit" name="submit" value="Удалить" class="btn btn-the-salmon-dance-3" />
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif


            </table>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-the-salmon-dance-3">Добавить нового пользователя</a>
    </div>
</div>
