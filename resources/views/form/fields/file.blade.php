@php
    /** @var $self \Merlion\Components\Form\Fields\File */
    $name = $self->getName();
    $id = $self->getId();
    $label = $self->getLabel();
    if(isset($errors) && $errors->has($name)) {
       $attributes = $attributes->merge(['class' => 'is-invalid']);
    }
    $label_position = $self->getContext('label_position') ?? null;
    $multiple = (bool) $self->getMultiple();
    $value = $self->getValue();

    $original_name = $name.'_original';
    if($multiple) {
        $values = to_json($value?:'[]');
        $name.= '[]';
        $original_name.= '[]';
    } else {
        $values = empty($value) ? [] : [$value];
    }
@endphp

<x-merlion::form.field :$label :$id :$full :$label_position>
    <x-merlion::form.fields.file :$id :$name :$multiple :$value />
    <div class="list-group mt-2">
        @foreach($values as $value)
            <div class="list-group-item p-2">
                <div class="d-flex justify-content-between align-items-center file-item">
                    <img src="{{$value}}" class="avatar avatar-sm object-contain" alt="">
                    <button type="button" class="btn btn-ghost btn-sm btn-danger p-1 btn-delete-file-item">
                        <i class="ti ti-trash"></i>
                    </button>
                    <input type="hidden" name="{{$original_name}}" value="{{$value}}">
                </div>
            </div>
        @endforeach
    </div>
</x-merlion::form.field>


@pushonce('scripts')
    <style nonce="{{csp_nonce()}}">
        .file-item .btn-restore-file-item, .file-item .badge-deleted {
            display: none;
        }

        .file-item.deleted .btn-restore-file-item, .file-item.deleted .badge-deleted {
            display: block;
        }

        .file-item.deleted .btn-delete-file-item {
            display: none;
        }
    </style>
    <script nonce="{{csp_nonce()}}">
        (function() {
            document.querySelectorAll('.btn-delete-file-item').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    this.closest('.list-group-item').remove();
                });
            });
        })();
    </script>
@endpushonce
