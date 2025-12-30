<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center brand-logo mb-4 fs-1 h-40px">
            @include('merlion::inc.admin.brand_logo')
        </div>
        <div class="card card-md">
            <div class="card-body">
                @include('merlion::components.errors')
                <form method="post" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label
                            class="form-label">{{admin()->getUsernameLabel() ?? __('merlion::auth.username')}}</label>
                        <input type="{{admin()->getUsernameType()}}"
                               placeholder="{{__('merlion::auth.input_username')}}"
                               name="{{admin()->getUsername()}}" class="form-control" autocomplete="off" />
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            {{__('merlion::auth.password')}}
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" name="password" class="form-control password-input"
                                   placeholder="{{__('merlion::auth.input_password')}}"
                                   autocomplete="off" />
                            <span class="input-group-text">
                                <a role="button" class="link-secondary password-addon"
                                   title="{{__('merlioh::auth.show_password')}}"
                                   data-bs-toggle="tooltip">
                                  <i class="ti ti-eye-closed icon"></i>
                                </a>
                              </span>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" />
                            <span class="form-check-label">{{__('merlion::auth.remember_me')}}</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">{{__('merlion::auth.login')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script nonce="{{csp_nonce()}}">
        document.querySelectorAll(".password-addon").forEach(function (r) {
            r.addEventListener("click", function (r) {
                const o = document.querySelector(".password-input");
                const i = r.currentTarget.querySelector("i");
                if ("password" === o.type) {
                    i.classList.remove("ti-eye-closed");
                    i.classList.add("ti-eye");
                    o.type = "text";
                } else {
                    i.classList.remove("ti-eye");
                    i.classList.add("ti-eye-closed");
                    o.type = "password";
                }
            });
        });
    </script>
@endpush
