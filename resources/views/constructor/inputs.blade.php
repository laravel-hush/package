<div class="row">
    @foreach ($inputs as $input)

        @if (isset($input['condition']) && !call_user_func($input['condition'], get_defined_vars()))
            @continue
        @endif

        @if ($input['type'] == 'closure')
            <div class="col {{ $input['width'] ?? 'col-12' }}">
                {!! call_user_func($input['closure'], get_defined_vars()) !!}
            </div>
            @continue
        @endif

        @if ($input['type'] == 'html')
            <div class="col {{ $input['width'] ?? 'col-12' }}">
                {!! $input['html'] !!}
            </div>
            @continue
        @endif

        @if ($input['type'] == 'iterable')
            @include('hush::components.iterable')
            @continue
        @endif

        @if ($input['type'] == 'hidden')
            <x-hush-input
                type="hidden"
                :name="$input['name']"
                :value="Constructor::value(get_defined_vars(), $input, $input['default'] ?? null)"/>
            @continue
        @endif

        @if ($input['type'] == 'view')
            <div class="col {{ $input['width'] ?? 'col-12' }}">
                @include ($input['view'], isset($input['vars']) ? $input['vars']() : [])
            </div>
            @continue
        @endif

        <div class="col {{ $input['width'] ?? 'col-12' }}">

            @if (!in_array($input['type'], ['file', 'text', 'textarea']) || (!isset($input['multilingual']) || !$input['multilingual']))
                <div class="form-group">
            @endif

                @if (
                    isset($input['label'])
                    && !in_array($input['type'], ['checkbox', 'radion'])
                    && (!in_array($input['type'], ['file', 'text', 'textarea']) || (!isset($input['multilingual']) || !$input['multilingual']))
                )
                    <label for="$input['name']">
                        @lang('hush::admin.' . $input['label'])
                        {{ isset($input['lang']) ? " ({$langs[$input['lang']]->name})" : '' }}
                    </label>
                @endif

                {!! Input::render($input, get_defined_vars()) !!}

                @isset ($input['description'])
                    <small class="d-block">@lang ('hush::admin.' . $input['description'])</small>
                @endisset

            @if (!in_array($input['type'], ['file', 'text', 'textarea']) || (!isset($input['multilingual']) || !$input['multilingual']))
                </div>
            @endif
        </div>

    @endforeach
</div>
