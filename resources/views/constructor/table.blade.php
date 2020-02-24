<div class="table table-striped table-borderless">

    <div class="row head">

        @foreach ($block['content']['columns'] as $column => $settings)
        <div class="col {{ $column }}">
            @if (in_array('sortable', $settings))
            <a href="{{ Constructor::link(['constructor' => collect(request()->except('sort', 'direction'))->merge([
                'sort' => $column,
                'direction' => $column == request()->sort && request()->direction == 'asc' ? 'desc' : 'asc'
            ])->all()]) }}">
                @lang ('hush::admin.' . $column)
            </a>
            @else
            @lang ('hush::admin.' . $column)
            @endif
        </div>
        @endforeach

        <div class="col actions">@lang ('hush::admin.actions')</div>

    </div>

    @php ($rows = $block['content']['rows']())

    @foreach ($rows as $row)
    <div class="row">

        @foreach ($block['content']['columns'] as $column => $settings)
        <div class="col {{ $column }}">{{ $row->{$column} }}</div>
        @endforeach

        @isset ($block['content']['actions'])
        <div class="col actions">

            @foreach ($block['content']['actions'] as $action)
            <a href="{{ Constructor::link($action) }}" class="btn btn-additional btn-rounded">
                <i class="material-icons">{{ $action['icon'] }}</i>
                @isset ($action['text'])
                <span>@lang ('hush::admin.' . $action['text'])</span>
                @endisset
            </a>
            @endforeach

            @isset ($block['content']['edit'])
            <a href="{{ Constructor::link(['constructor' => [
                'url' => $baseUrl . '/edit',
                'id' => $row->id
            ]]) }}" class="btn btn-primary btn-round {{ isset($block['content']['modal']) ? 'in-modal' : '' }}">
                <i class="material-icons">edit</i>
            </a>
            @endisset

            @isset ($block['content']['delete'])
            <a href="{{ Constructor::link(['constructor' => [
                'id' => $row->id,
                'action' => 'delete'
            ]]) }}" class="btn btn-danger btn-round delete-item">
                <i class="material-icons">delete</i>
            </a>
            @endisset

        </div>
        @endisset

    </div>
    @endforeach
</div>

<div class="pagination-block">
    @isset ($block['content']['pagination'])
    {!! $rows->appends(request()->except('page'))->render() !!}
    @endisset
</div>
