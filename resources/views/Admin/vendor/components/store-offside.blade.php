{{--
    resources/views/admin/vendors/partials/contact-canvas.blade.php

    Returned by VendorController@contact (AJAX). Receives: $vendor
    Field names below are assumptions - rename them to match your Vendor model.
--}}
@php
    $initials = strtoupper(substr($vendor->name ?? 'V', 0, 2));
    $waNumber = $vendor->whatsapp ?: $vendor->mobile;
    $waDigits = preg_replace('/\D+/', '', (string) $waNumber);
@endphp

<div class="offcanvas offcanvas-end contact-canvas" tabindex="-1" id="contactCanvas" aria-labelledby="contactTitle">
    <div class="contact-head">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <div class="d-flex align-items-center gap-3">
            <div class="avatar avatar-xl">
                <span class="avatar-title rounded-circle" style="background:#198754;">{{ $initials }}</span>
            </div>
            <div>
                <div class="contact-vendor" id="contactTitle">{{ $vendor->name }}</div>
                <div class="contact-joined">
                    <i class="fa-regular fa-calendar me-1"></i>Joined {{ optional($vendor->created_at)->format('j M Y') }}
                </div>
                @if ($vendor->verifier)
                    <div class="contact-verified">
                        <i class="fa-solid fa-check"></i> Verified By - {{ $vendor->verifier->name }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="contact-quick">
        @if ($vendor->email)
            <a href="mailto:{{ $vendor->email }}" class="q-mail"><i class="fa-solid fa-envelope"></i>Email</a>
        @endif
        @if ($vendor->mobile)
            <a href="tel:{{ $vendor->mobile }}" class="q-call"><i class="fa-solid fa-phone"></i>Call</a>
        @endif
        @if ($waDigits)
            <a href="https://wa.me/{{ $waDigits }}" class="q-wa" target="_blank" rel="noopener">
                <i class="fa-brands fa-whatsapp"></i>WhatsApp
            </a>
        @endif
    </div>

    <div class="offcanvas-body p-0 pb-4">
        @if ($vendor->owner_name)
            <div class="contact-section">Contact person</div>
            <div class="contact-item">
                <span class="ci-icon ci-indigo"><i class="fa-solid fa-user-tie"></i></span>
                <div class="ci-body">
                    <div class="ci-label">Owner</div>
                    <span class="ci-value">{{ $vendor->owner_name }}</span>
                </div>
                <button type="button" class="ci-copy" title="Copy" aria-label="Copy name">
                    <i class="fa-regular fa-copy"></i>
                </button>
            </div>
        @endif

        @if ($vendor->personal_email || $vendor->email)
            <div class="contact-section">Email</div>
            @if ($vendor->personal_email)
                <div class="contact-item">
                    <span class="ci-icon ci-violet"><i class="fa-solid fa-user"></i></span>
                    <div class="ci-body">
                        <div class="ci-label">Personal email</div>
                        <a class="ci-value" href="mailto:{{ $vendor->personal_email }}">{{ $vendor->personal_email }}</a>
                    </div>
                    <button type="button" class="ci-copy" title="Copy" aria-label="Copy personal email">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                </div>
            @endif
            @if ($vendor->email)
                <div class="contact-item">
                    <span class="ci-icon ci-blue"><i class="fa-solid fa-building"></i></span>
                    <div class="ci-body">
                        <div class="ci-label">Organization email</div>
                        <a class="ci-value" href="mailto:{{ $vendor->email }}">{{ $vendor->email }}</a>
                    </div>
                    <button type="button" class="ci-copy" title="Copy" aria-label="Copy organization email">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                </div>
            @endif
        @endif

        @if ($vendor->mobile || $vendor->alternate_phone || $waNumber)
            <div class="contact-section">Phone</div>
            @if ($vendor->mobile)
                <div class="contact-item">
                    <span class="ci-icon ci-green"><i class="fa-solid fa-mobile-screen"></i></span>
                    <div class="ci-body">
                        <div class="ci-label">Mobile</div>
                        <a class="ci-value" href="tel:{{ $vendor->mobile }}">{{ $vendor->mobile }}</a>
                    </div>
                    <button type="button" class="ci-copy" title="Copy" aria-label="Copy mobile number">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                </div>
            @endif
            @if ($vendor->alternate_phone)
                <div class="contact-item">
                    <span class="ci-icon ci-teal"><i class="fa-solid fa-phone-volume"></i></span>
                    <div class="ci-body">
                        <div class="ci-label">Alternate / office</div>
                        <a class="ci-value" href="tel:{{ $vendor->alternate_phone }}">{{ $vendor->alternate_phone }}</a>
                    </div>
                    <button type="button" class="ci-copy" title="Copy" aria-label="Copy alternate number">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                </div>
            @endif
            @if ($waNumber)
                <div class="contact-item">
                    <span class="ci-icon ci-lime"><i class="fa-brands fa-whatsapp"></i></span>
                    <div class="ci-body">
                        <div class="ci-label">WhatsApp</div>
                        <span class="ci-value">{{ $waNumber }}</span>
                    </div>
                    <button type="button" class="ci-copy" title="Copy" aria-label="Copy WhatsApp number">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                </div>
            @endif
        @endif

        @if ($vendor->address)
            <div class="contact-section">Address</div>
            <div class="contact-item">
                <span class="ci-icon ci-amber"><i class="fa-solid fa-location-dot"></i></span>
                <div class="ci-body">
                    <div class="ci-label">Business address</div>
                    <span class="ci-value">{{ $vendor->address }}</span>
                </div>
                <button type="button" class="ci-copy" title="Copy" aria-label="Copy business address">
                    <i class="fa-regular fa-copy"></i>
                </button>
            </div>
        @endif
    </div>
</div>