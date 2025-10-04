@props(['name', 'label', 'options' => [], 'required' => false, 'placeholder' => '', 'value' => '', 'class' => '', 'emptyText' => '-- Select Option --'])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    
    <select 
        name="{{ $name }}" 
        id="{{ $name }}" 
        class="form-control @error($name) is-invalid @enderror {{ $class }}"
        @if($required) required @endif
        {{ $attributes }}
    >
        @if($emptyText)
            <option value="">{{ $emptyText }}</option>
        @endif
        
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    
    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>
