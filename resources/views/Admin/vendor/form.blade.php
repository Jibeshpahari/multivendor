@extends('admin.layout.app')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css">
    <style>
        .section-icon { width: 38px; height: 38px; }
        #approvalNotes .accordion-button, #approvalNotes .accordion-button:not(.collapsed) { background: transparent; box-shadow: none; color: inherit; }
        .logo-preview { width: 56px; height: 56px; border: 2px dashed #ced4da; }
        .logo-preview img { width: 100%; height: 100%; object-fit: cover; }
        .select2-container--default .select2-selection--single { height: 38px; border: 1px solid #dee2e6; border-radius: .375rem; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 38px; padding-left: 12px; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 38px; }
    </style>
@endpush

@section('content')
    @php
        $vendor = $vendor ?? null;

        // [name, label, icon, placeholder, col, type, value source]
        $sections = [
            ['Store details', 'fa-store', 'Name and public URL of the store', [
                ['store_name', 'Store Name', 'fa-shop', 'Ex: Green Basket Traders', 6],
                ['store_slug', 'Store URL', 'fa-link', 'green-basket-traders', 6],
            ]],
            ['Contact person', 'fa-user-tie', 'Login details are emailed to the personal email', [
                ['name', 'Full Name', 'fa-user', 'Ex: Anita Sharma', 4, 'text', 'user.name'],
                ['contact_role', 'Role', 'fa-id-badge', 'Ex: Owner', 4],
                ['email', 'Personal Email', 'fa-envelope', 'anita@gmail.com', 4, 'email', 'user.email'],
            ]],
            ['Business contact', 'fa-address-book', 'Shown in the vendor contact panel', [
                ['store_email', 'Organization Email', 'fa-building', 'anita@greenbasket.in', 6, 'email'],
                ['store_phone', 'Mobile', 'fa-mobile-screen', '+91 98300 12345', 6, 'tel'],
                ['alt_phone', 'Alternate / Office Phone', 'fa-phone-volume', '+91 33 4001 2200', 6, 'tel'],
            ]],
            ['Business address', 'fa-location-dot', 'Registered place of business', [
                ['address_line', 'Address', 'fa-road', '12 Park Street', 12],
                ['city', 'City', 'fa-city', 'Kolkata', 3],
                ['state', 'State', 'fa-map', 'West Bengal', 3],
                ['postal_code', 'Postal Code', 'fa-hashtag', '700016', 3],
            ]],
            ['Approval', 'fa-clipboard-check', 'New vendors start as pending', []],
        ];
        $countries = ['IN' => 'India', 'US' => 'United States', 'GB' => 'United Kingdom', 'AE' => 'United Arab Emirates', 'BD' => 'Bangladesh', 'NP' => 'Nepal'];
        $country = old('country', $vendor?->country ?? 'IN');
        $status = old('status', $vendor?->status ?? 'pending');
    @endphp

    <div class="card p-4">
        <form action="{{ '' }}" method="POST" enctype="multipart/form-data" autocomplete="off" id="vendorForm">
            @csrf

            @foreach ($sections as $section)
                @php [$title, $icon, $hint, $fields] = $section; @endphp

                <div class="mb-5">
                    <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-4">
                        <span class="section-icon bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center rounded-3">
                            <i class="fa-solid {{ $icon }}"></i>
                        </span>
                        <div>
                            <h5 class="fw-semibold mb-0">{{ $title }}</h5>
                            <small class="text-muted">{{ $hint }}</small>
                        </div>
                    </div>

                    <div class="row g-4">
                        @foreach ($fields as $f)
                            @php
                                [$name, $label, $fIcon, $placeholder, $col] = $f;
                                $type = $f[5] ?? 'text';
                            @endphp
                            <div class="col-md-{{ $col }}">
                                <label for="{{ $name }}" class="form-label fw-semibold">
                                    <i class="fa-solid {{ $fIcon }} text-muted me-1"></i>{{ $label }}
                                </label>
                                <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
                                    class="form-control {{ $type == 'tel' ? 'phone-input' : '' }}"
                                    placeholder="{{ $placeholder }}"
                                    value="{{ old($name, data_get($vendor, $f[6] ?? $name)) }}">
                                @error($name)
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endforeach

                        {{-- Extras that need custom markup --}}
                        @if ($loop->index == 0)
                            <div class="col-md-6">
                                <label for="store_logo" class="form-label fw-semibold">
                                    <i class="fa-solid fa-image text-muted me-1"></i>Store Logo
                                </label>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="logo-preview rounded-circle overflow-hidden d-flex align-items-center justify-content-center bg-light text-muted flex-shrink-0" id="logoPreview">
                                        @if (!empty($vendor?->store_logo))
                                            <img src="{{ asset('storage/' . $vendor->store_logo) }}" alt="Store logo">
                                        @else
                                            <i class="fa-solid fa-camera"></i>
                                        @endif
                                    </div>
                                    <input type="file" class="form-control" name="store_logo" id="store_logo" accept=".jpg,.jpeg,.png,.webp">
                                </div>
                                @error('store_logo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @elseif ($loop->index == 2)
                            <div class="col-md-6">
                                <label for="whatsapp_number" class="form-label fw-semibold">
                                    <i class="fa-brands fa-whatsapp text-muted me-1"></i>WhatsApp
                                </label>
                                <input type="tel" class="form-control phone-input" name="whatsapp_number" id="whatsapp_number"
                                    value="{{ old('whatsapp_number', $vendor?->whatsapp_number) }}" placeholder="+91 98300 12345">
                                @error('whatsapp_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @elseif ($loop->index == 3)
                            <div class="col-md-3">
                                <label for="country" class="form-label fw-semibold">
                                    <i class="fa-solid fa-earth-asia text-muted me-1"></i>Country
                                </label>
                                <select class="form-select" name="country" id="country">
                                    @foreach ($countries as $code => $countryName)
                                        <option value="{{ $code }}" @selected($country == $code)>{{ $countryName }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @elseif ($loop->index == 4)
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="fa-solid fa-clipboard-check text-muted me-1"></i>Approval Status
                                </label>
                                <div class="selectgroup w-100">
                                    @foreach (['pending' => 'clock', 'approved' => 'circle-check', 'rejected' => 'circle-xmark'] as $value => $statusIcon)
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="{{ $value }}" class="selectgroup-input" @checked($status == $value)>
                                            <span class="selectgroup-button"><i class="fa-solid fa-{{ $statusIcon }} me-1"></i>{{ ucfirst($value) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="accordion" id="approvalNotes">
                                    <div class="accordion-item border-0 rounded-3 overflow-hidden bg-primary-subtle">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed fw-semibold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#approvalNotesBody"
                                                aria-expanded="false" aria-controls="approvalNotesBody">
                                                <i class="fa-solid fa-circle-info me-2"></i>Good to know
                                            </button>
                                        </h2>
                                        <div id="approvalNotesBody" class="accordion-collapse collapse">
                                            <div class="accordion-body pt-0">
                                                <ul class="small mb-0 ps-3">
                                        <li class="mb-1">New vendors stay <strong>Pending</strong> and cannot sign in yet.</li>
                                        <li class="mb-1">Choosing <strong>Approved</strong> and saving generates a temporary password and emails it to the personal email above.</li>
                                        <li class="mb-1">The email asks the vendor to change the password after the first login.</li>
                                        <li>The password is stored encrypted and is never shown again, so it cannot be recovered later.</li>
                                    </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-center gap-2 border-top pt-4">
                <a href="{{ '' }}" class="btn btn-secondary bg-secondary-gradient">Cancel</a>
                <button type="submit" class="btn btn-primary bg-primary-gradient" id="saveBtn">
                    <i class="fa-solid fa-floppy-disk me-1"></i>Save vendor
                </button>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script>
        $(function() {
            $('#country').select2({ width: '100%' });

            // Slug follows the store name until it is edited by hand
            let slugTouched = $('#store_slug').val().length > 0;
            $('#store_slug').on('input', () => slugTouched = true);
            $('#store_name').on('keyup', function() {
                if (slugTouched) return;
                $('#store_slug').val($(this).val().toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '').replace(/[\s_-]+/g, '-').replace(/^-+|-+$/g, ''));
            });

            // Logo preview
            $('#store_logo').on('change', function() {
                if (!this.files[0]) return;
                const reader = new FileReader();
                reader.onload = e => $('#logoPreview').html($('<img>', { src: e.target.result, alt: 'Logo preview' }));
                reader.readAsDataURL(this.files[0]);
            });

            // Phone characters only
            $('.phone-input').on('input', function() {
                this.value = this.value.replace(/[^0-9+\-\s()]/g, '');
            });

            // Prevent double submit
            $('#vendorForm').on('submit', function() {
                $('#saveBtn').prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm me-1"></span>Saving...');
            });
        });
    </script>
@endpush