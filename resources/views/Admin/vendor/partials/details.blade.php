@php
    $storeName = $profile?->store_name ?: $vendor->name;

    $mobile    = $vendor->phone;
    $altPhone  = $profile?->alt_phone;
    $waNumber  = $profile?->whatsapp_number ?: $mobile;
    $waDigits  = preg_replace('/\D+/', '', (string) $waNumber);

    $orgEmail  = $profile?->store_email;

    $logoUrl   = getImageUrl($profile?->store_logo);
    $headColor = getAvatarColor($vendor->uuid);

    $personUrl   = getImageUrl($vendor->avatar ?? null);
    $personColor = getAvatarColor($vendor->uuid);

    $addressParts = array_filter([
        $profile?->address_line,
        $profile?->city,
        $profile?->state,
        $profile?->postal_code,
        $profile?->country,
    ]);
    $fullAddress = implode(', ', $addressParts);

    $statusColors = [
        'active' => '#16a34a', 'pending' => '#f59e0b', 'suspended' => '#9ca3af',
        'rejected' => '#dc2626', 'banned' => '#7f1d1d',
    ];
    $statusColor = $statusColors[$vendor->status] ?? '#9ca3af';
@endphp

<div class="offcanvas offcanvas-end contact-canvas" tabindex="-1" id="contactCanvas" aria-labelledby="contactTitle">
    <div class="contact-head">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <div class="d-flex align-items-center gap-3">
            <div class="avatar avatar-xl {{ getStatusRing($vendor->status) }}"
                title="{{ ucfirst($vendor->status) }}">
                @if ($logoUrl)
                    <span class="avatar-title rounded-circle p-0 overflow-hidden bg-white">
                        <img src="{{ $logoUrl }}" alt="{{ $storeName }}" class="avatar-img">
                    </span>
                @else
                    <span class="avatar-title rounded-circle"
                        style="background: {{ $headColor['bg'] }}; color: {{ $headColor['text'] }};">
                        {{ getInitials($storeName) }}
                    </span>
                @endif
            </div>
            <div>
                <div class="contact-vendor" id="contactTitle">{{ $storeName }}</div>
                <div class="contact-joined">
                    <i class="fa-regular fa-calendar me-1"></i>Joined {{ optional($vendor->created_at)->format('j M Y') }}
                </div>
                <div class="contact-verified">
                    <i class="fa-solid fa-check"></i>
                    Approved by {{ $approver?->name ?? '—' }}
                    @if ($approver && $profile?->approved_at)
                        on {{ $profile->approved_at->format('j M Y') }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="contact-quick">
        @if ($orgEmail || $vendor->email)
            <a href="mailto:{{ $orgEmail ?: $vendor->email }}" class="q-mail"><i class="fa-solid fa-envelope"></i>Email</a>
        @endif
        @if ($mobile)
            <a href="tel:{{ $mobile }}" class="q-call"><i class="fa-solid fa-phone"></i>Call</a>
        @endif
        @if ($waDigits)
            <a href="https://wa.me/{{ $waDigits }}" class="q-wa" target="_blank" rel="noopener">
                <i class="fa-brands fa-whatsapp"></i>WhatsApp
            </a>
        @endif
    </div>

    <div class="offcanvas-body p-0 pb-4">
        @if ($vendor->name)
            <div class="contact-section">Contact person</div>
            <div class="contact-item">
                @if ($personUrl)
                    <span class="ci-avatar">
                        <img src="{{ $personUrl }}" alt="{{ $vendor->name }}">
                    </span>
                @else
                    <span class="ci-avatar"
                        style="background: {{ $personColor['bg'] }}; color: {{ $personColor['text'] }};">
                        {{ getInitials($vendor->name) }}
                    </span>
                @endif
                <div class="ci-body">
                    <div class="ci-label">{{ $profile?->contact_role ?: 'Owner' }}</div>
                    <span class="ci-value">{{ $vendor->name }}</span>
                </div>
                <button type="button" class="ci-copy" title="Copy" aria-label="Copy name">
                    <i class="fa-regular fa-copy"></i>
                </button>
            </div>
        @endif

        @if ($vendor->email || $orgEmail)
            <div class="contact-section">Email</div>
            @if ($vendor->email)
                <div class="contact-item">
                    <span class="ci-icon ci-violet"><i class="fa-solid fa-user"></i></span>
                    <div class="ci-body">
                        <div class="ci-label">Personal email</div>
                        <a class="ci-value" href="mailto:{{ $vendor->email }}">{{ $vendor->email }}</a>
                    </div>
                    <button type="button" class="ci-copy" title="Copy" aria-label="Copy personal email">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                </div>
            @endif
            @if ($orgEmail)
                <div class="contact-item">
                    <span class="ci-icon ci-blue"><i class="fa-solid fa-building"></i></span>
                    <div class="ci-body">
                        <div class="ci-label">Store email</div>
                        <a class="ci-value" href="mailto:{{ $orgEmail }}">{{ $orgEmail }}</a>
                    </div>
                    <button type="button" class="ci-copy" title="Copy" aria-label="Copy store email">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                </div>
            @endif
        @endif

        @if ($mobile || $altPhone || $waNumber || $profile?->store_phone)
            <div class="contact-section">Phone</div>
            @if ($mobile)
                <div class="contact-item">
                    <span class="ci-icon ci-green"><i class="fa-solid fa-mobile-screen"></i></span>
                    <div class="ci-body">
                        <div class="ci-label">Mobile</div>
                        <a class="ci-value" href="tel:{{ $mobile }}">{{ $mobile }}</a>
                    </div>
                    <button type="button" class="ci-copy" title="Copy" aria-label="Copy mobile number">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                </div>
            @endif
            @if ($profile?->store_phone)
                <div class="contact-item">
                    <span class="ci-icon ci-blue"><i class="fa-solid fa-store"></i></span>
                    <div class="ci-body">
                        <div class="ci-label">Store phone</div>
                        <a class="ci-value" href="tel:{{ $profile->store_phone }}">{{ $profile->store_phone }}</a>
                    </div>
                    <button type="button" class="ci-copy" title="Copy" aria-label="Copy store phone">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                </div>
            @endif
            @if ($altPhone)
                <div class="contact-item">
                    <span class="ci-icon ci-teal"><i class="fa-solid fa-phone-volume"></i></span>
                    <div class="ci-body">
                        <div class="ci-label">Alternate / office</div>
                        <a class="ci-value" href="tel:{{ $altPhone }}">{{ $altPhone }}</a>
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

        @if ($fullAddress)
            <div class="contact-section">Address</div>
            <div class="contact-item">
                <span class="ci-icon ci-amber"><i class="fa-solid fa-location-dot"></i></span>
                <div class="ci-body">
                    <div class="ci-label">Business address</div>
                    <span class="ci-value">{{ $fullAddress }}</span>
                </div>
                <button type="button" class="ci-copy" title="Copy" aria-label="Copy business address">
                    <i class="fa-regular fa-copy"></i>
                </button>
            </div>
        @endif
    </div>
</div>