@php
    $fieldContext = $self->getFieldContext();
@endphp
<form {{$attributes}} method="{{$self->method!='get' ? 'post':'get'}}" id="{{$id}}"
      enctype="multipart/form-data">
    @method($self->getMethod())
    @csrf
    @foreach($self->getFields() as $field)
        {!! $field->model($model)->set($fieldContext)->render() !!}
    @endforeach
</form>
<script nonce="{{csp_nonce()}}">
    (function () {
        let form = document.querySelector("form#{{$id}}");
        const valueChangedHandler = function (e) {
            let name = e.detail.name;
            let value = e.detail.value;
            console.log(name, ':', value);

            let all_depends = @json($self->getDepends());

            for (let field_id in all_depends) {
                let depends = all_depends[field_id];
                for (let i in depends) {
                    let depend = depends[i];
                    if (depend.name === name) {
                        let match = false;
                        if (Array.isArray(depend.values)) {
                            match = depend.values.includes(value);
                        } else {
                            match = depend.values === value;
                        }
                        if (match) {
                            document.querySelector("#field_set_" + field_id).style.display = "block";
                        } else {
                            document.querySelector("#field_set_" + field_id).style.display = "none";
                        }
                    }
                }
            }
        }
        form.addEventListener('field_value_changed', valueChangedHandler);
    })();
</script>
