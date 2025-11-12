@props([
    'id' => '',
    'name' => '',
    'multiple' => false,
    'required' => false,
    'accept' => '*',
    'value' => null,
])

<input class="form-control"
       type="file"
       id="{{$id}}"
       name="{{$name}}"
       {{$required ? 'required' : ''}}
       @if($multiple)
           multiple
       @endif
       accept="{{$accept}}"
>
