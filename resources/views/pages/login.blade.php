@use(Merlion\Components\Pages\Login)

<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="#" class="navbar-brand navbar-brand-autodark">
                <img src="{{admin()->getBrandLogo()}}" class="maxh-48px" alt="">
            </a>
        </div>
        <div class="card card-md">
            <div class="card-body">
                @include('merlion::form.errors')
                <form action="{{admin()->route('login.submit')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{Login::$usernameLabel}}</label>
                        <input type="text" name="{{Login::$username}}" required value="{{old(Login::$username)}}"
                               class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            {{__('merlion::base.password')}}
                            <span class="form-label-description">
                              </span>
                        </label>
                        <div class="input-group input-group-flat auth-pass-inputgroup">
                            <input type="password" name="password" required class="form-control password-input"
                                   autocomplete="off">
                            <span class="input-group-text">
                                <a href="#" class="link-secondary password-addon" data-bs-toggle="tooltip"
                                   aria-label="Show/hide password"
                                   data-bs-original-title="Show/hide password">
                                  <i class="ri-eye-fill align-middle"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input">
                            <span class="form-check-label">{{__('merlion::base.remember_me')}}</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">{{__('merlion::base.login')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script nonce="{{csp_nonce()}}">
        Array.from(document.querySelectorAll("form .auth-pass-inputgroup")).forEach(function (e) {
            Array.from(e.querySelectorAll(".password-addon")).forEach(function (r) {
                r.addEventListener("click", function (r) {
                    var o = e.querySelector(".password-input");
                    var i = r.currentTarget.querySelector("i");
                    if ("password" === o.type) {
                        i.classList.remove("ri-eye-fill");
                        i.classList.add("ri-eye-off-fill");
                        o.type = "text";
                    } else {
                        i.classList.remove("ri-eye-off-fill");
                        i.classList.add("ri-eye-fill");
                        o.type = "password";
                    }
                })
            })
        });
    </script>
@endpush
