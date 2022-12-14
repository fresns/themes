@extends('commons.fresns')

@section('title', fs_db_config('menu_account_login'))

@section('content')
    <div class="container-fluid">
        <div class="row my-5 pt-5 m-auto" style="max-width:500px;">
            <h1 class="h3 my-3 fw-normal text-center">{{ fs_lang('accountLogin') }}</h1>

            {{-- Quick Login --}}
            @if (fs_api_config('account_connect_services'))
                <div class="card mx-2 p-0">
                    <div class="card-header">{{ fs_lang('accountLoginByConnects') }}</div>
                    <div class="card-body">
                        @foreach(fs_api_config('account_connect_services') as $item)
                            <a class="btn btn-outline-primary mx-2" data-bs-toggle="modal" href="#fresnsModal"
                                data-lang-tag="{{ current_lang_tag() }}"
                                data-type="account"
                                data-scene="join"
                                data-post-message-key="fresnsJoin"
                                data-title="{{ fs_lang('accountLogin') }}"
                                data-url="{{ $item['url'] }}">
                                <img src="/assets/themes/ThemeFrame/images/connects/{{ $item['code'] }}.png" height="32">
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="text-center my-4">
                    <span class="badge text-bg-secondary">{{ fs_lang('modifierOr') }}</span>
                </div>
            @endif

            {{-- Select Login Method --}}
            @if (fs_db_config('fs_theme_is_email') && fs_db_config('fs_theme_is_sms'))
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-PasswordAccount-tab" data-bs-toggle="tab" data-bs-target="#nav-PasswordAccount" type="button" role="tab" aria-controls="nav-PasswordAccount" aria-selected="true">{{ fs_lang('accountLoginByPassword') }}</button>
                        <button class="nav-link" id="nav-CodeAccount-tab" data-bs-toggle="tab" data-bs-target="#nav-CodeAccount" type="button" role="tab" aria-controls="nav-CodeAccount" aria-selected="false">{{ fs_lang('accountLoginByCode') }}</button>
                    </div>
                </nav>
            @endif

            <div class="tab-content" id="nav-tabContent">
                {{-- Password Login: Start --}}
                <div class="tab-pane fade show active" id="nav-PasswordAccount" role="tabpanel" aria-labelledby="nav-PasswordAccount-tab">
                    <form id="accordionPasswordAccount" class="py-3" method="post" novalidate action="{{ route('fresns.api.account.login') }}" onsubmit="var passwordInput = document.querySelector('#nav-PasswordAccount > form > div.form-floating > input'); passwordInput.value = Base64.encode(passwordInput.value)">
                        @csrf
                        <input type="hidden" name="redirectURL" value="{{ request()->get('redirectURL') }}">
                        {{-- Account Select --}}
                        <div class="input-group mb-3 mt-2">
                            <span class="input-group-text" id="basic-addon1">{{ fs_lang('accountType') }}</span>
                            <div class="form-control">
                                {{-- E-Mail --}}
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" value="email" id="password_account_email" data-bs-toggle="collapse" data-bs-target="#password_account_email:not(.show)" aria-expanded="true" aria-controls="password_account_email" checked>
                                    <label class="form-check-label" for="password_account_email">{{ fs_lang('email') }}</label>
                                </div>
                                {{-- Phone --}}
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" value="phone" id="password_account_phone" data-bs-toggle="collapse" data-bs-target="#password_account_phone:not(.show)" aria-expanded="false" aria-controls="password_account_phone">
                                    <label class="form-check-label" for="password_account_phone">{{ fs_lang('phone') }}</label>
                                </div>
                            </div>
                        </div>

                        {{-- Account --}}
                        <div>
                            {{-- E-Mail --}}
                            <div class="collapse show" id="password_account_email" aria-labelledby="password_account_email" data-bs-parent="#accordionPasswordAccount">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="name@example.com">
                                    <label for="email">{{ fs_lang('email') }}</label>
                                </div>
                            </div>
                            {{-- Phone --}}
                            <div class="collapse" id="password_account_phone" aria-labelledby="password_account_phone" data-bs-parent="#accordionPasswordAccount">
                                <div class="row g-2 mb-3">
                                    @if (count(fs_api_config('send_sms_supported_codes') ?? []) > 1)
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                {{-- List of country calling codes --}}
                                                <select class="form-select" name="countryCode" value="{{ old('countryCode') }}">
                                                    <option disabled>{{ fs_lang('countryCode') }}</option>
                                                    @foreach(fs_api_config('send_sms_supported_codes') as $countryCode)
                                                        <option value="{{ $countryCode }}" @if (fs_api_config('send_sms_default_code') == $countryCode) selected @endif>{{ $countryCode }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="sms_code">{{ fs_lang('countryCode') }}</label>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Default Country Calling Code --}}
                                        <select class="form-select d-none" name="countryCode">
                                            <option value="{{ fs_api_config('send_sms_default_code') }}" selected>{{ fs_api_config('send_sms_default_code') }}</option>
                                        </select>
                                    @endif

                                    {{-- Cell Phone Number --}}
                                    <div @if (count(fs_api_config('send_sms_supported_codes') ?? []) > 1) class="col-md-9" @endif>
                                        <div class="form-floating">
                                            <input type="number" name="phone" value="{{ old('phone') }}" class="form-control rounded-bottom-0" placeholder="Phone Number">
                                            <label for="phone">{{ fs_lang('phone') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="form-floating">
                            <input type="password" name="password" class="form-control border-top-0" value="{{ old('password') }}" placeholder="Password" required>
                            <label for="password">{{ fs_lang('password') }}</label>
                        </div>

                        {{-- Forgot your password? --}}
                        <div class="mt-2 text-center"><a href="{{ fs_route(route('fresns.account.reset.password')) }}">{{ fs_lang('passwordForgot') }}?</a></div>

                        {{-- Login or Register --}}
                        <div class="clearfix mt-4">
                            <div @if (fs_api_config('site_public_status')) class="float-start w-65" @endif>
                                <button class="w-100 btn btn-lg btn-primary" type="submit">{{ fs_lang('accountLogin') }}</button>
                            </div>
                            @if (fs_api_config('site_public_status'))
                                <div class="float-start w-35 ps-4">
                                    @if (fs_api_config('site_public_service'))
                                        <a class="btn btn-success me-3" role="button" data-bs-toggle="modal" href="#fresnsModal"
                                            data-lang-tag="{{ current_lang_tag() }}"
                                            data-type="account"
                                            data-scene="join"
                                            data-post-message-key="fresnsJoin"
                                            data-title="{{ fs_lang('accountRegister') }}"
                                            data-url="{{ fs_api_config('site_public_service') }}">
                                            {{ fs_lang('accountRegister') }}
                                        </a>
                                    @else
                                        <a class="w-100 btn btn-lg btn-outline-success" href="{{ fs_route(route('fresns.account.register')) }}" role="button">{{ fs_lang('accountRegister') }}</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
                {{-- Password Login: end --}}

                {{-- Code Login: Start --}}
                <div class="tab-pane fade" id="nav-CodeAccount" role="tabpanel" aria-labelledby="nav-CodeAccount-tab">
                    <form  id="accordionCodeAccount" novalidate class="py-3" method="post" action="{{ route('fresns.api.account.login') }}">
                        @csrf
                        <input type="hidden" name="redirectURL" value="{{ request()->get('redirectURL') }}">
                        {{-- Account --}}
                        @if (fs_db_config('fs_theme_is_email') && fs_db_config('fs_theme_is_sms'))
                            <div class="input-group mb-3 mt-2">
                                <span class="input-group-text" id="basic-addon1">{{ fs_lang('accountType') }}</span>
                                <div class="form-control">
                                    {{-- E-Mail --}}
                                    @if (fs_db_config('fs_theme_is_email'))
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="code_account_email" value="email" data-bs-toggle="collapse" data-bs-target="#code_account_email:not(.show)" aria-expanded="true" aria-controls="code_account_email" checked>
                                            <label class="form-check-label" for="code_account_email">{{ fs_lang('email') }}</label>
                                        </div>
                                    @endif

                                    {{-- Phone --}}
                                    @if (fs_db_config('fs_theme_is_sms'))
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="code_account_phone" value="phone" data-bs-toggle="collapse" data-bs-target="#code_account_phone:not(.show)" aria-expanded="false" aria-controls="code_account_phone">
                                            <label class="form-check-label" for="code_account_phone">{{ fs_lang('phone') }}</label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Account Select --}}
                        <div>
                            <input type="hidden" name="useType" value="2">
                            <input type="hidden" name="templateId" value="7">
                            {{-- E-Mail --}}
                            @if (fs_db_config('fs_theme_is_email'))
                                <div class="collapse show" id="code_account_email" aria-labelledby="code_account_email" data-bs-parent="#accordionCodeAccount">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">{{ fs_lang('email') }}</span>
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control">

                                        {{-- Get email verify code --}}
                                        <button class="btn btn-outline-secondary send-verify-code" type="button" data-action="{{ route("fresns.api.send.verify.code") }}">{{ fs_lang('sendVerifyCode') }}</button>
                                    </div>
                                </div>
                            @endif

                            {{-- Cell Phone Number --}}
                            @if (fs_db_config('fs_theme_is_sms'))
                                <div class="collapse @if (! fs_db_config('fs_theme_is_email')) show @endif" id="code_account_phone" aria-labelledby="code_account_phone" data-bs-parent="#accordionCodeAccount">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">{{ fs_lang('phone') }}</span>
                                        @if (count(fs_api_config('send_sms_supported_codes')) > 1)
                                            {{-- List of country calling codes --}}
                                            <select class="form-select" name="countryCode" value="{{ old('countryCode') }}">
                                                <option disabled>{{ fs_lang('countryCode') }}</option>
                                                @foreach(fs_api_config('send_sms_supported_codes') as $countryCode)
                                                    <option value="{{ $countryCode }}" @if (fs_api_config('send_sms_default_code') == $countryCode) selected @endif>{{ $countryCode }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            {{-- Default Country Calling Code --}}
                                            <select class="form-select d-none" name="countryCode">
                                                <option value="{{ fs_api_config('send_sms_default_code') }}" selected>{{ fs_api_config('send_sms_default_code') }}</option>
                                            </select>
                                        @endif

                                        <input type="number" name="phone" value="{{ old('phone') }}" class="form-control" style="width:40%">

                                        {{-- Get cell phone verify code --}}
                                        <button class="btn btn-outline-secondary send-verify-code" type="button" data-action="{{ route("fresns.api.send.verify.code") }}">{{ fs_lang('sendVerifyCode') }}</button>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Verify Code --}}
                        <div class="input-group">
                            <span class="input-group-text">{{ fs_lang('verifyCode') }}</span>
                            <input type="text" class="form-control" name="verifyCode" value="{{ old('verifyCode') }}" required>
                        </div>

                        {{-- Login or Register --}}
                        <div class="clearfix mt-4">
                            <div @if (fs_api_config('site_public_status')) class="float-start w-65" @endif>
                                <button class="w-100 btn btn-lg btn-primary" type="submit">{{ fs_lang('accountLogin') }}</button>
                            </div>
                            @if (fs_api_config('site_public_status'))
                                <div class="float-start w-35 ps-4">
                                    @if (fs_api_config('site_public_service'))
                                        <button class="btn btn-success me-3" type="button" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                            data-lang-tag="{{ current_lang_tag() }}"
                                            data-type="account"
                                            data-scene="join"
                                            data-post-message-key="fresnsJoin"
                                            data-title="{{ fs_lang('accountRegister') }}"
                                            data-url="{{ fs_api_config('site_public_service') }}">
                                            {{ fs_lang('accountRegister') }}
                                        </button>
                                    @else
                                        <a class="w-100 btn btn-lg btn-outline-success" href="{{ fs_route(route('fresns.account.register')) }}" role="button">{{ fs_lang('accountRegister') }}</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
                {{-- Code Login: End --}}
            </div>
        </div>
    </div>
@endsection
