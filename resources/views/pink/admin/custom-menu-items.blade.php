@foreach($items as $item)

    <tr>
        <td style="text-align: left;">
            {{ $paddingLeft }}
            <a href="{{ route('admin.menus.edit', ['menus' => $item->id]) }}">{{ $item->title }}</a>
        </td>
        <td>{{ $item->url() }}</td>


        <td>
            <form action="{{ route('admin.menus.destroy', ['menu'=> $item->id]) }}" class="form-horizontal" method="post">
                {{ method_field('DELETE') }}
                <input type="submit" name="submit" value="Удалить" class="btn btn-french-5" />
            </form>
        </td>

        @if($item->hasChildren())
            <ul class="sub-menu">
                @include(env('THEME'). '.admin.custom-menu-items', array('items' => $item->children(), 'paddingLeft' => $paddingLeft.'--'))
            </ul>
        @endif


    </tr>
@endforeach
