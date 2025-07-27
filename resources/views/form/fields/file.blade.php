@php
    $value = $self->getValue();
    if($multiple) {
        $name = $name.'[]';
        $values = $value ? to_json($value) : [];
    } else {
        $values = [$value];
    }
@endphp
<x-merlion::form.field :$label :$id :$full :$label_position>
    <input {{$attributes->merge(['class' => 'form-control'])}}
           accept="{{$self->getAccept()}}"
           @if($self->getMaxSize())
               data-max-size="{{$self->getMaxSize()}}"
           @endif
           type="file" {{$multiple?'multiple':''}} id="{{$id}}"
    >
</x-merlion::form.field>

<div class="d-flex gap-2 flex-wrap align-items-end" id="{{$id}}_preview">
    @foreach($values as $value)
        <div class="click-delete">
            <img src="{{$value}}" alt="" class="maxh-40px maxw-40px rounded">
            <input type="hidden" name="{{$name}}" value="{{$value}}">
        </div>
    @endforeach
</div>

@push('scripts')
    <script nonce="{{csp_nonce()}}">
        (function () {
            let fileInput = document.getElementById('{{$id}}');
            fileInput.addEventListener('change', function (e) {
                var data = new FormData();
                var maxSize = {{$self->getMaxSize() ?? 10000000}};
                @if($multiple)
                console.log(fileInput.files);
                data.append('multiple', '1');
                fileInput.files.forEach(function (file) {
                    console.log(file.size);
                    if (file.size > maxSize) {
                        admin().toast({
                            text: 'File size is too large',
                        });
                        throw 'File size is too large';
                    }
                    data.append('file[]', file);
                });
                @else

                console.log(fileInput.files[0].size);
                if (fileInput.files[0].size > maxSize) {
                    admin().toast({
                        text: 'File size is too large',
                        className: 'danger',
                    });
                    throw 'File size is too large';
                }
                data.append('file', fileInput.files[0]);
                @endif

                fetch('{{admin()->route('upload')}}', {
                    method: 'POST',
                    body: data
                }).then(
                    response => response.json() // if the response is a JSON object
                ).then((success) => {
                    if (success.success) {
                        {{--document.querySelector("#{{$id}}_value").value = JSON.stringify(success.url);--}}
                        @if($multiple)
                        success.url.forEach(function (url) {
                            appendValue(url);
                        });
                        @else
                        clearValue();
                        appendValue(success.url);
                        @endif
                    }
                }).catch(
                    error => console.log(error) // Handle the error response object
                );
            });

            function clearValue() {
                var previewImg = document.querySelector('#{{$id}}_preview');
                previewImg.innerHTML = '';
            }

            function appendValue(url) {
                var previewImg = document.querySelector('#{{$id}}_preview');
                var div = document.createElement('div');
                div.classList.add('click-delete');
                var img = document.createElement('img');
                var input = document.createElement('input');
                img.src = url;
                img.classList.add('maxh-40px', 'maxw-40px', 'rounded');
                div.appendChild(img);
                input.name = "{{$name}}";
                input.type = "hidden";
                input.value = url;
                div.appendChild(input);
                previewImg.appendChild(div);
            }

            document.addEventListener('click', function (event) {
                // 检查被点击的元素是否有指定的 class
                if (event.target.classList.contains('click-delete')) {
                    // delete it self
                    event.target.remove();
                }
            });
        })();
    </script>
    <style nonce="{{csp_nonce()}}">
        .click-delete {
            position: relative;
        }

        .click-delete::after {
            content: "×";
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translateY(-50%) translateX(-50%);
            background: var(--tblr-red);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .click-delete:hover::after {
            opacity: 1;
        }

        .click-delete:hover img {
            opacity: 0.5;
        }
    </style>
@endpush
