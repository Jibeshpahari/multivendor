@extends('admin.layout.app')

@push('css')
    <style>
        .col-8 {
            width: 70%;
        }

        .col-4 {
            width: 30%;
        }

        .input-group-text {
            font-size: 18px;
        }

        .maintenance {
            background-color: #f3f3f3 !important;
            border: 1px solid #e1e1e1;
            border-radius: 6px;
            padding: 8px 10px 12px 6px;
        }

        .maintenance.active {
            background-color: #f0fbf4 !important;
            border: 1px solid #c8dfd0;
        }

        .maintenance sub {
            font-size: 12.5px;
            color: #4f4f4f;
            line-height: 1.3;
            display: block;
            font-family: 'Public Sans';
        }
    </style>
@endpush

@section('content')
    <div class="row g-3">
        <div class="col-8">
            <div class="card py-3 px-2">
                <div class="container">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="site-identity-tab" data-bs-toggle="tab"
                                data-bs-target="#site-identity" data-tab="site_identity" type="button" role="tab"
                                aria-controls="home" aria-selected="true">Site Identity</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address"
                                data-tab="address" type="button" role="tab" aria-controls="profile"
                                aria-selected="false">Address</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="social-links-tab" data-bs-toggle="tab"
                                data-bs-target="#social-links" data-tab="social_links" type="button" role="tab"
                                aria-controls="contact" aria-selected="false">Social Links</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo"
                                data-tab="seo" type="button" role="tab" aria-controls="contact"
                                aria-selected="false">SEO</button>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="myTabContent">
                        {{-- Site Identity --}}
                        <div class="tab-pane fade show active" id="site-identity" role="tabpanel"
                            aria-labelledby="site-identity">
                            {{-- Site Settings Identity --}}
                            <form action="{{ route('admin.settings.site-setting.store') }}" method="POST"
                                id="site-identity" enctype="multipart/form-data">
                                @csrf
                                {{-- Tab Name --}}
                                <input type="hidden" name="tab_name" value="site_identity" data-tab="site-identity">

                                {{-- Site Name --}}
                                <div class="form-group">
                                    <label for="site_title" class="required">Site Title</label>
                                    <input type="text" class="form-control" id="site_title" name="site_title"
                                        value="{{ old('site_title', setting('site_title')) }}">
                                    @error('site_title')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    {{-- Site Email --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="site_email">Site Email</label>
                                            <input type="email" class="form-control" id="site_email" name="site_email"
                                                value="{{ old('site_email', setting('site_email')) }}">
                                            @error('site_email')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Site Phone --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="site_phone">Site Phone</label>
                                            <input type="text" class="form-control" id="site_phone" name="site_phone"
                                                value="{{ old('site_phone', setting('site_phone')) }}">
                                            @error('site_phone')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        {{-- Site Logo --}}
                                        <div class="form-group">
                                            <label for="site_logo">Site Logo</label>
                                            @if (setting('site_logo'))
                                                <div class="mb-2">
                                                    <img src="{{ Storage::url(setting('site_logo')) }}" alt="Site Logo"
                                                        height="50">
                                                    {{-- //TODO - Image will show on hover  --}}
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" id="site_logo" name="site_logo"
                                                accept="image/*">
                                            @error('site_logo')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col">
                                        {{-- Site Favicon --}}
                                        <div class="form-group">
                                            <label for="site_favicon">Site Favicon</label>
                                            @if (setting('site_favicon'))
                                                <div class="mb-2">
                                                    <img src="{{ Storage::url(setting('site_favicon')) }}"
                                                        alt="Site Favicon" height="32">
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" id="site_favicon"
                                                name="site_favicon" accept="image/*">
                                            @error('site_favicon')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        {{-- Site Timezone --}}
                                        <div class="form-group">
                                            <label for="site_timezone">Timezone </label>
                                            @php $currentTimezone = old('site_timezone', setting('site_timezone', 'UTC')); @endphp
                                            <select class="form-select" id="site_timezone" name="site_timezone">
                                                @foreach (timezone_identifiers_list() as $timezone)
                                                    <option value="{{ $timezone }}"
                                                        {{ $currentTimezone === $timezone ? 'selected' : '' }}>
                                                        {{ $timezone }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('site_timezone')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col">
                                        {{-- Site Language --}}
                                        <div class="form-group">
                                            <label for="site_language">Language</label>
                                            @php $currentLanguage = old('site_language', setting('site_language', 'en')); @endphp
                                            <select class="form-select" id="site_language" name="site_language">
                                                <option value="en" {{ $currentLanguage === 'en' ? 'selected' : '' }}>
                                                    English</option>
                                                <option value="fr" {{ $currentLanguage === 'fr' ? 'selected' : '' }}>
                                                    French</option>
                                                <option value="de" {{ $currentLanguage === 'de' ? 'selected' : '' }}>
                                                    German</option>
                                                <option value="es" {{ $currentLanguage === 'es' ? 'selected' : '' }}>
                                                    Spanish</option>
                                                <option value="ar" {{ $currentLanguage === 'ar' ? 'selected' : '' }}>
                                                    Arabic</option>
                                            </select>
                                            @error('site_language')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        {{-- Site Currency --}}
                                        <div class="form-group">
                                            <label for="site_currency">Currency </label>
                                            @php $currentCurrency = old('site_currency', setting('site_currency', 'USD')); @endphp
                                            <select class="form-select" id="site_currency" name="site_currency">
                                                <option value="USD" {{ $currentCurrency === 'USD' ? 'selected' : '' }}>
                                                    USD</option>
                                                <option value="EUR" {{ $currentCurrency === 'EUR' ? 'selected' : '' }}>
                                                    EUR</option>
                                                <option value="GBP" {{ $currentCurrency === 'GBP' ? 'selected' : '' }}>
                                                    GBP</option>
                                                <option value="AED" {{ $currentCurrency === 'AED' ? 'selected' : '' }}>
                                                    AED</option>
                                                <option value="SAR" {{ $currentCurrency === 'SAR' ? 'selected' : '' }}>
                                                    SAR</option>
                                            </select>
                                            @error('site_currency')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col">
                                        {{-- Site Currency Symbol --}}
                                        <div class="form-group">
                                            <label for="site_currency_symbol">Currency Symbol <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="site_currency_symbol"
                                                name="site_currency_symbol"
                                                value="{{ old('site_currency_symbol', setting('site_currency_symbol', '$')) }}">
                                            @error('site_currency_symbol')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </form>
                        </div>
                        {{-- Address --}}
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address">
                            <form action="{{ route('admin.settings.site-setting.store') }}" method="POST"
                                id="site-address" enctype="multipart/form-data">
                                @csrf

                                {{-- Tab Name --}}
                                <input type="hidden" name="tab_name" value="address" data-tab="site-identity">
                                {{-- Address --}}
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ old('address', setting('address')) }}">
                                    @error('address')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    {{-- City --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                value="{{ old('city', setting('city')) }}">
                                            @error('city')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- State --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" id="state" name="state"
                                                value="{{ old('state', setting('state')) }}">
                                            @error('state')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Country --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control" id="country" name="country"
                                                value="{{ old('country', setting('country')) }}">
                                            @error('country')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Zip Code --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zip_code">Zip Code</label>
                                            <input type="text" class="form-control" id="zip_code" name="zip_code"
                                                value="{{ old('zip_code', setting('zip_code')) }}">
                                            @error('zip_code')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="map_link">Map Link</label>
                                    <input type="url" class="form-control" id="map_link" name="map_link"
                                        placeholder="https://maps.google.com/?q=..."
                                        value="{{ old('map_link', setting('map_link')) }}">
                                    <small class="form-text text-muted">
                                        Paste a Google Maps share link (e.g. from "Share" → "Copy link" on Google Maps).
                                    </small>
                                    @error('map_link')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </form>
                        </div>
                        {{-- Social-links --}}
                        <div class="tab-pane fade" id="social-links" role="tabpanel" aria-labelledby="social-links">
                            <form action="{{ route('admin.settings.site-setting.store') }}" method="POST"
                                id="site-links" enctype="multipart/form-data">
                                @csrf

                                {{-- Tab Name --}}
                                <input type="hidden" name="tab_name" value="social_links" data-tab="social-links">

                                <div class="row">
                                    {{-- Facebook --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="facebook_link">Facebook Page Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                        class="fab fa-facebook-f text-primary"></i></span>
                                                <input type="url" class="form-control" id="facebook_link"
                                                    name="facebook_link" placeholder="https://facebook.com/yourpage"
                                                    value="{{ old('facebook_link', setting('facebook_link')) }}">
                                            </div>
                                            @error('facebook_link')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Instagram --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="instagram_link">Instagram Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                        class="fab fa-instagram text-danger"></i></span>
                                                <input type="url" class="form-control" id="instagram_link"
                                                    name="instagram_link" placeholder="https://instagram.com/yourpage"
                                                    value="{{ old('instagram_link', setting('instagram_link')) }}">
                                            </div>
                                            @error('instagram_link')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Twitter / X --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="twitter_link">Twitter / X Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fab fa-x-twitter"></i></span>
                                                <input type="url" class="form-control" id="twitter_link"
                                                    name="twitter_link" placeholder="https://x.com/yourpage"
                                                    value="{{ old('twitter_link', setting('twitter_link')) }}">
                                            </div>
                                            @error('twitter_link')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- YouTube --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="youtube_link">YouTube Channel Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                        class="fab fa-youtube text-danger"></i></span>
                                                <input type="url" class="form-control" id="youtube_link"
                                                    name="youtube_link" placeholder="https://youtube.com/@yourchannel"
                                                    value="{{ old('youtube_link', setting('youtube_link')) }}">
                                            </div>
                                            @error('youtube_link')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- LinkedIn --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="linkedin_link">LinkedIn Page Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                        class="fab fa-linkedin-in text-primary"></i></span>
                                                <input type="url" class="form-control" id="linkedin_link"
                                                    name="linkedin_link"
                                                    placeholder="https://linkedin.com/company/yourpage"
                                                    value="{{ old('linkedin_link', setting('linkedin_link')) }}">
                                            </div>
                                            @error('linkedin_link')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- WhatsApp --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="whatsapp_link">WhatsApp Link / Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                        class="fab fa-whatsapp text-success"></i></span>
                                                <input type="url" class="form-control" id="whatsapp_link"
                                                    name="whatsapp_link" placeholder="https://wa.me/8801XXXXXXXXX"
                                                    value="{{ old('whatsapp_link', setting('whatsapp_link')) }}">
                                            </div>
                                            @error('whatsapp_link')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- TikTok --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tiktok_link">TikTok Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fab fa-tiktok"></i></span>
                                                <input type="url" class="form-control" id="tiktok_link"
                                                    name="tiktok_link" placeholder="https://tiktok.com/@yourpage"
                                                    value="{{ old('tiktok_link', setting('tiktok_link')) }}">
                                            </div>
                                            @error('tiktok_link')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </form>
                        </div>
                        {{-- SEO --}}
                        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo">
                            <form action="{{ route('admin.settings.site-setting.store') }}" method="POST"
                                id="site-links" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                                        value="{{ $s?->meta_title ?? '' }}">
                                    @error('meta_title')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ $s?->meta_description ?? '' }}</textarea>
                                    @error('meta_description')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                        value="{{ $s?->meta_keywords ?? '' }}"
                                        placeholder="e.g. keyword1, keyword2, keyword3">
                                    @error('meta_keywords')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="google_analytics_id">Google Analytics ID</label>
                                            <input type="text" class="form-control" id="google_analytics_id"
                                                name="google_analytics_id" value="{{ $s?->google_analytics_id ?? '' }}"
                                                placeholder="e.g. G-XXXXXXXXXX">
                                            @error('google_analytics_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="google_tag_manager">Google Tag Manager</label>
                                            <textarea class="form-control" id="google_tag_manager" name="google_tag_manager" rows="3"
                                                placeholder="Paste GTM script here">{{ $s?->google_tag_manager ?? '' }}</textarea>
                                            @error('google_tag_manager')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="facebook_pixel">Facebook Pixel</label>
                                    <textarea class="form-control" id="facebook_pixel" name="facebook_pixel" rows="3"
                                        placeholder="Paste Facebook Pixel script here">{{ $s?->facebook_pixel ?? '' }}</textarea>
                                    @error('facebook_pixel')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">

            <div class="card p-3 mb-3">
                <h5 class="card-title mb-3">Useful settings</h5>

                <div class="form-group px-1">
                    <label for="user_per_page">User Pagination Per Page</label>
                    <input type="number" class="form-control setting-input" id="user_per_page" name="user_per_page"
                        data-key="user_per_page" min="1" step="1" value="{{ $s?->user_per_page ?? '' }}">
                    <span class="error setting-error" data-key="user_per_page"></span>
                </div>

                <div class="form-group px-1">
                    <label for="admin_per_page">Admin Pagination Per Page</label>
                    <input type="number" class="form-control setting-input" id="admin_per_page" name="admin_per_page"
                        data-key="admin_per_page" min="1" step="1"
                        value="{{ $s?->admin_per_page ?? '' }}">
                    <span class="error setting-error" data-key="admin_per_page"></span>
                </div>
            </div>

            <div class="card p-3 mb-3">
                <div class="row g-1 align-items-center maintenance">
                    <div class="col-3 d-flex justify-content-center">
                        <input class="form-check-input switch switch-lg" type="checkbox" role="switch"
                            id="switchCheckDefault">
                    </div>
                    <div class="col-9 ps-3">
                        <label class="form-check-label d-block fs-6 fw-semibold" for="switchCheckDefault">Maintenance
                            Mode</label>
                        <sub>Your site is live and accessible to all users.</sub>
                    </div>
                    <div class="col-12 d-none">
                        <span class="error d-block mt-1"> </span>
                    </div>
                </div>
            </div>

            <div class="card p-3">
                    <button class="primary-btn btn btn-dark bg-black-gradient w-100">
                        Clear Cache
                        
                    </button>
            </div>

        </div>

    </div>
@endsection


@push('js')
    <script>
        $(function() {
            const storageKey = 'site_setting_active_tab';
            const sessionTab = @json(session('active_tab'));
            const savedTab = sessionTab || localStorage.getItem(storageKey);

            if (savedTab) {
                $(`#myTab [data-tab="${savedTab}"]`).tab('show');
            }

            $('#myTab button').on('shown.bs.tab', function(e) {
                localStorage.setItem(storageKey, $(e.target).data('tab'));
            });
        });

        $(function() {
            var liveText = 'Your site is live and accessible to all users.';
            var offlineText = 'Your site is offline for maintenance.';

            $('#switchCheckDefault').on('change', function() {
                var $wrapper = $(this).closest('.maintenance');
                var isChecked = $(this).is(':checked');

                $wrapper.toggleClass('active', isChecked);
                $wrapper.find('sub').text(isChecked ? liveText : offlineText);
            });
        });

        $(document).on('change', '.setting-input', function() {
            const $input = $(this);
            const key = $input.data('key');
            const value = $input.val();
            const $error = $(`.setting-error[data-key="${key}"]`);

            $error.text(''); // clear previous error

            $.ajax({
                url: "{{ route('admin.settings.save.pagination') }}",
                method: 'POST',
                dataType: 'json',
                data: {
                    key,
                    value,
                },
                success: function(data) {
                    if (data.success) {
                        notify('success', data.message || 'Setting updated', 'toast');
                    } else {
                        notify('error', data.message, 'toast');
                    }
                },
                error: function(error) {
                    const message = error.responseJSON?.message || 'Could not update setting';
                    notify('error', message, 'toast');
                    if (error.responseJSON?.errors?.[key]) {
                        $error.text(error.responseJSON.errors[key][0]);
                    }
                }
            });
        });
    </script>

    {{-- <script>
        let socialIndex = {{ $s?->social_links ? count(json_decode($s->social_links, true)) : 0 }};

        $('#add_social_link').on('click', function() {
            const row = `
            <div class="row social-link-row mb-2">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="social_links[${socialIndex}][name]"
                        placeholder="e.g. Facebook">
                </div>
                <div class="col-md-7">
                    <input type="url" class="form-control" name="social_links[${socialIndex}][link]"
                        placeholder="e.g. https://facebook.com/">
                </div>
                <div class="col-md-1 align-content-center">
                    <button type="button" class="btn btn-danger btn-sm remove-social-link">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        `;

            $('#social_links_wrapper').append(row);
            socialIndex++;
        });

        $('#social_links_wrapper').on('click', '.remove-social-link', function() {
            $(this).closest('.social-link-row').remove();
        });
    </script> --}}
@endpush
