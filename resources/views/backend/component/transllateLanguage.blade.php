@foreach ($languages as $language)
    @if (App::currentLocale() === $language->canonical)
        @continue    
    @endif
    @php
        $translate = $item->languages->contains('id',$language->id);
       
    @endphp

    <td colspan="2">
        <a class="{{ $translate ==true ? 'text-danger' : ''  }}" href="{{ route('private-system.management.configuration.language.translate',
        ['id' => $item->id, 'languages_id' => $language->id,'model' => $model]) }}">
        {{ $translate == true ? 'Đã dịch' : 'Chưa dịch' }}  
        </a>
    </td>   

@endforeach

