@props(['field'])

@if ($errors->has($field))
    <div class="invalid-feedback d-block">
        @foreach ($errors->get($field) as $error)
            {{ $error }}
        @endforeach
    </div>
@endif
