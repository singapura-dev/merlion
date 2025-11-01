<div id="{{$self->getId()}}" class="d-flex gap-{{$self->getGap()}}">
    @for($i = 1; $i<=$self->getLength(); $i++)
        <input {{$self->getAttributes()->merge(['class'=> 'otp-input text-center form-control form-control-'.$self->getSize()])}}
               type="text" maxlength="1"/>
    @endfor
    <input class="otp" type="hidden" name="{{$self->getName()}}">
</div>

@push('styles')
    <style nonce="{{csp_nonce()}}">
        input.otp-input {
            flex: unset;
            width: 2.6rem;
            padding-left: 0;
            padding-right: 0;
        }

        input.otp-input.form-control-sm {
            width: 2rem;
        }

        input.otp-input.form-control-lg {
            width: 3.2rem;
        }
    </style>
@endpush

@push('scripts')
    <script nonce="{{csp_nonce()}}">
        document.addEventListener("DOMContentLoaded", function () {
            const inputs = document.querySelectorAll('#{{$self->getId()}} > input.otp-input');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('input', function () {

                    if (this.value.length > 1) {
                        this.value = this.value[0]; //
                    }

                    @if($self->getType() === 'number')
                    if (this.value < "0" || this.value > "9") {
                        this.value = '';
                    }
                    @endif

                    if (this.value !== '' && i < inputs.length - 1) {
                        inputs[i + 1].focus();
                        inputs[i + 1].select();
                    }
                    document.querySelector('#{{$self->getId()}} > input.otp').value = Array.from(inputs).map(input => input.value).join('');
                });

                inputs[i].addEventListener('keydown', function (event) {
                    if (event.key === 'Backspace') {
                        this.value = '';
                        if (i > 0) {
                            inputs[i - 1].focus();
                        }
                    }
                });
            }
        });
    </script>
@endpush
