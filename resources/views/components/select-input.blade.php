
@props([
  'name',
  'options',
  'selected',
])

<select
  name="{{ $name }}"
  {{ $attributes->merge(['class' => 'focus:border-primary-500 focus:ring-primary-500 peer block w-full rounded-lg p-4 text-sm placeholder:text-transparent autofill:pb-2 autofill:pt-6 focus:pb-2 focus:pt-6 disabled:pointer-events-none disabled:opacity-50 [&:not(:placeholder-shown)]:pb-2 [&:not(:placeholder-shown)]:pt-6']) }}
>
  @foreach ($options as $model)
    <option value="{{ $model['value'] }}" @selected($model['value'] == $selected)>{{ $model['name'] }}</option>
  @endforeach
</select>
