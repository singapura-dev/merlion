@extends('merlion::form.fields.file')

@push('after_file_input')
    @if($value = $self->getValue())
        <div class="list-group mt-2">
            <div class="list-group-item p-2">
                <div class="d-flex justify-content-between align-items-center file-item">
                    <img src="{{$value}}" class="avatar avatar-sm" alt="">
                    <span class="badge-deleted badge bg-red text-red-fg">Deleted</span>
                    <button type="button" class="btn btn-ghost btn-danger p-1 btn-delete-file-item">
                        <i class="ti ti-trash"></i>
                    </button>
                    <button type="button" title="Restore" class="btn btn-ghost btn-success p-1 btn-restore-file-item">
                        <i class="ti ti-restore"></i>
                    </button>
                    <input type="hidden" name="{{$self->getName()}}_deleted" value="0">
                </div>
            </div>
        </div>
    @endif
@endpush

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
        (function () {
            document.querySelectorAll('.btn-delete-file-item').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    this.closest('.file-item').classList.add('deleted');
                    this.closest('.file-item').querySelector('input').value = 1;
                });
            });

            document.querySelectorAll('.btn-restore-file-item').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    this.closest('.file-item').classList.remove('deleted');
                    this.closest('.file-item').querySelector('input').value = 0;
                });
            });
        })();
    </script>
@endpushonce
