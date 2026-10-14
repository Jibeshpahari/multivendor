@extends('admin.layout.app')

@push('css')
    <style>
        .section-icon {
            width: 38px;
            height: 38px;
        }

        #approvalNotes .accordion-button,
        #approvalNotes .accordion-button:not(.collapsed) {
            background: transparent;
            box-shadow: none;
            color: inherit;
        }

        .logo-dropzone {
            border: 2px dashed #ced4da;
            transition: border-color .15s, background-color .15s;
        }

        .logo-dropzone.dragover,
        .logo-dropzone.has-error {
            border-color: var(--bs-primary);
        }

        .logo-dropzone.has-error {
            border-color: var(--bs-danger);
        }

        .logo-dropzone.dragover {
            background: var(--bs-primary-bg-subtle);
        }

        .logo-preview {
            width: 96px;
            height: 96px;
        }

        .logo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
    @php
        $vendor = $vendor ?? null;
        $country = old('country', $vendor?->country ?? '');

        // Status now lives on the users table
        $status = old('status', $vendor?->user?->status ?? 'pending');

        $placeholder = [
            'store' => 'Mystic Willow Emporium',
            'slug' => 'mystic-willow-emporium',
            'name' => 'Aeloria Vance',
            'role' => 'Founder',
            'email' => 'aeloria@willowemporium.fake',
            'phone' => '+00 555 019 1111',
            'store_email' => 'hello@willowemporium.fake',
            'mobile' => '+00 555 019 2834',
            'alt_phone' => '+00 555 019 0000',
            'address' => '974 Stardust Lane, Sector 7G',
            'city' => 'Novaria City',
            'state' => 'Eldoria',
            'postal' => 'X9Y-2Z4',
        ];
    @endphp

    <form action="{{ route('admin.vendors.save') }}" method="POST" enctype="multipart/form-data" autocomplete="off"
        id="vendorForm">
        @csrf

        <div class="row g-4">

            <div class="col-lg-8 d-flex flex-column gap-4">

                <div class="card p-4 mb-0">
                    <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-4">
                        <span
                            class="section-icon bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center rounded-3">
                            <i class="fa-solid fa-store"></i>
                        </span>
                        <div>
                            <h5 class="fw-semibold mb-0">Store &amp; contact details</h5>
                            <small class="text-muted">Store name, public URL and the contact person. Login details are
                                emailed to the personal email</small>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="store_name" class="form-label required">
                                <i class="fa-solid fa-shop text-muted me-1"></i>Store Name
                            </label>
                            <input type="text" name="store_name" id="store_name"
                                class="form-control @error('store_name') is-invalid @enderror"
                                placeholder="Ex: {{ $placeholder['store'] }}"
                                value="{{ old('store_name', $vendor?->store_name) }}">
                            @error('store_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="store_slug" class="form-label">
                                <i class="fa-solid fa-link text-muted me-1"></i>Store Slug
                            </label>
                            <input type="text" name="store_slug" id="store_slug"
                                class="form-control @error('store_slug') is-invalid @enderror"
                                placeholder="{{ $placeholder['slug'] }}"
                                value="{{ old('store_slug', $vendor?->store_slug) }}" readonly>
                            @error('store_slug')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="name" class="form-label required">
                                <i class="fa-solid fa-user text-muted me-1"></i>Full Name
                            </label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Ex: {{ $placeholder['name'] }}"
                                value="{{ old('name', $vendor?->user?->name) }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="contact_role" class="form-label">
                                <i class="fa-solid fa-id-badge text-muted me-1"></i>Role
                            </label>
                            <input type="text" name="contact_role" id="contact_role"
                                class="form-control @error('contact_role') is-invalid @enderror"
                                placeholder="Ex: {{ $placeholder['role'] }}"
                                value="{{ old('contact_role', $vendor?->contact_role) }}">
                            @error('contact_role')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="email" class="form-label required">
                                <i class="fa-solid fa-envelope text-muted me-1"></i>Personal Email
                            </label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="{{ $placeholder['email'] }}"
                                value="{{ old('email', $vendor?->user?->email) }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="phone" class="form-label">
                                <i class="fa-solid fa-mobile-screen text-muted me-1"></i>Personal Number
                            </label>
                            <input type="tel" name="phone" id="phone"
                                class="form-control phone-input @error('phone') is-invalid @enderror"
                                placeholder="{{ $placeholder['phone'] }}"
                                value="{{ old('phone', $vendor?->user?->phone) }}">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="card p-4 mb-0">
                    <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-4">
                        <span
                            class="section-icon bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center rounded-3">
                            <i class="fa-solid fa-address-book"></i>
                        </span>
                        <div>
                            <h5 class="fw-semibold mb-0">Business contact</h5>
                            <small class="text-muted">Shown in the vendor contact panel. Leave email or phone empty to
                                use the personal ones</small>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="store_email" class="form-label">
                                <i class="fa-solid fa-building text-muted me-1"></i>Organization Email
                            </label>
                            <input type="email" name="store_email" id="store_email"
                                class="form-control @error('store_email') is-invalid @enderror"
                                placeholder="{{ $placeholder['store_email'] }}"
                                value="{{ old('store_email', $vendor?->store_email) }}">
                            @error('store_email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="store_phone" class="form-label">
                                <i class="fa-solid fa-mobile-screen text-muted me-1"></i>Organization Mobile
                            </label>
                            <input type="tel" name="store_phone" id="store_phone"
                                class="form-control phone-input @error('store_phone') is-invalid @enderror"
                                placeholder="{{ $placeholder['mobile'] }}"
                                value="{{ old('store_phone', $vendor?->store_phone) }}">
                            @error('store_phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="alt_phone" class="form-label">
                                <i class="fa-solid fa-phone-volume text-muted me-1"></i>Alternate / Office Phone
                            </label>
                            <input type="tel" name="alt_phone" id="alt_phone"
                                class="form-control phone-input @error('alt_phone') is-invalid @enderror"
                                placeholder="{{ $placeholder['alt_phone'] }}"
                                value="{{ old('alt_phone', $vendor?->alt_phone) }}">
                            @error('alt_phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="whatsapp_number" class="form-label">
                                <i class="fa-brands fa-whatsapp text-muted me-1"></i>WhatsApp
                            </label>
                            <input type="tel" name="whatsapp_number" id="whatsapp_number"
                                class="form-control phone-input @error('whatsapp_number') is-invalid @enderror"
                                placeholder="{{ $placeholder['mobile'] }}"
                                value="{{ old('whatsapp_number', $vendor?->whatsapp_number) }}">
                            @error('whatsapp_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card p-4">
                    <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-4">
                        <span
                            class="section-icon bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center rounded-3">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <div>
                            <h5 class="fw-semibold mb-0">Business address</h5>
                            <small class="text-muted">Registered place of business</small>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <label for="address_line" class="form-label required">
                                <i class="fa-solid fa-road text-muted me-1"></i>Address
                            </label>
                            <input type="text" name="address_line" id="address_line"
                                class="form-control @error('address_line') is-invalid @enderror"
                                placeholder="{{ $placeholder['address'] }}"
                                value="{{ old('address_line', $vendor?->address_line) }}">
                            @error('address_line')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="city" class="form-label required">
                                <i class="fa-solid fa-city text-muted me-1"></i>City
                            </label>
                            <input type="text" name="city" id="city"
                                class="form-control @error('city') is-invalid @enderror"
                                placeholder="{{ $placeholder['city'] }}" value="{{ old('city', $vendor?->city) }}">
                            @error('city')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="state" class="form-label required">
                                <i class="fa-solid fa-map text-muted me-1"></i>State
                            </label>
                            <input type="text" name="state" id="state"
                                class="form-control @error('state') is-invalid @enderror"
                                placeholder="{{ $placeholder['state'] }}" value="{{ old('state', $vendor?->state) }}">
                            @error('state')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="postal_code" class="form-label required">
                                <i class="fa-solid fa-hashtag text-muted me-1"></i>Postal Code
                            </label>
                            <input type="text" name="postal_code" id="postal_code"
                                class="form-control @error('postal_code') is-invalid @enderror"
                                placeholder="{{ $placeholder['postal'] }}"
                                value="{{ old('postal_code', $vendor?->postal_code) }}">
                            @error('postal_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="country" class="form-label required">
                                <i class="fa-solid fa-earth-asia text-muted me-1"></i>Country
                            </label>
                            <select class="form-select @error('country') is-invalid @enderror" name="country"
                                id="country">
                                <option value="" @selected(empty($country))>Choose</option>
                                <option value="IN" @selected($country == 'IN')>India</option>
                                <option value="US" @selected($country == 'US')>United States</option>
                                <option value="GB" @selected($country == 'GB')>United Kingdom</option>
                                <option value="AE" @selected($country == 'AE')>United Arab Emirates</option>
                                <option value="BD" @selected($country == 'BD')>Bangladesh</option>
                                <option value="NP" @selected($country == 'NP')>Nepal</option>
                            </select>
                            @error('country')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 d-flex flex-column gap-4">

                <div class="card p-4 mb-0">
                    <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-3">
                        <span
                            class="section-icon bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center rounded-3">
                            <i class="fa-solid fa-image"></i>
                        </span>
                        <div>
                            <h5 class="fw-semibold mb-0">Store Logo</h5>
                            <small class="text-muted">Upload your store logo</small>
                        </div>
                    </div>
                    <label for="store_logo" class="form-label {{ empty($vendor?->store_logo) ? 'required' : '' }}">
                        <i class="fa-solid fa-shop text-muted me-1"></i>Store Logo
                    </label>
                    <div class="logo-dropzone rounded-3 p-4 text-center @error('store_logo') has-error @enderror"
                        id="logoDropzone">
                        <div class="logo-preview rounded-circle overflow-hidden d-flex align-items-center justify-content-center bg-light text-primary fs-2 mx-auto mb-3"
                            id="logoPreview">
                            @if (!empty($vendor?->store_logo))
                                <img src="{{ asset('storage/' . $vendor->store_logo) }}" alt="Store logo">
                            @else
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            @endif
                        </div>
                        <div class="small fw-medium">Drag &amp; drop image here</div>
                        <div class="small text-muted my-1">or</div>
                        <button type="button" class="btn btn-primary bg-primary-gradient" id="logoBtn">
                            <i class="fa-solid fa-upload me-1"></i>Choose File
                        </button>
                        <input type="file" class="d-none" name="store_logo" id="store_logo"
                            accept=".jpg,.jpeg,.png,.webp">
                    </div>

                    <small class="text-muted d-block text-center mt-2">Recommended size: 300 &times; 300px <br>(JPG, PNG,
                        WEBP)</small>
                    @error('store_logo')
                        <small class="text-danger d-block text-center mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="card p-4 mb-0">
                    <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-3">
                        <span
                            class="section-icon bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center rounded-3">
                            <i class="fa-solid fa-user-circle"></i>
                        </span>
                        <div>
                            <h5 class="fw-semibold mb-0">Profile Photo</h5>
                            <small class="text-muted">Photo of the contact person (optional)</small>
                        </div>
                    </div>

                    <label for="avatar" class="form-label">
                        <i class="fa-solid fa-user text-muted me-1"></i>Profile Photo
                    </label>
                    <div class="logo-dropzone rounded-3 p-4 text-center @error('avatar') has-error @enderror"
                        id="avatarDropzone">
                        <div class="logo-preview rounded-circle overflow-hidden d-flex align-items-center justify-content-center bg-light text-primary fs-2 mx-auto mb-3"
                            id="avatarPreview">
                            @if (!empty($vendor?->user?->avatar))
                                <img src="{{ asset('storage/' . $vendor->user->avatar) }}" alt="Profile photo">
                            @else
                                <i class="fa-solid fa-user-tie"></i>
                            @endif
                        </div>
                        <div class="small fw-medium">Drag &amp; drop image here</div>
                        <div class="small text-muted my-1">or</div>
                        <button type="button" class="btn btn-primary bg-primary-gradient" id="avatarBtn">
                            <i class="fa-solid fa-upload me-1"></i>Choose File
                        </button>
                        <input type="file" class="d-none" name="avatar" id="avatar"
                            accept=".jpg,.jpeg,.png,.webp">
                    </div>

                    <small class="text-muted d-block text-center mt-2">Recommended size: 300 &times; 300px <br>(JPG, PNG,
                        WEBP)</small>
                    @error('avatar')
                        <small class="text-danger d-block text-center mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="card p-4 mb-0">
                    <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-4">
                        <span
                            class="section-icon bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center rounded-3">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </span>
                        <div>
                            <h5 class="fw-semibold mb-0">Account status</h5>
                            <small class="text-muted">New vendors start as pending</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label required">
                            <i class="fa-solid fa-clipboard-check text-muted me-1"></i>Status
                        </label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                            <option value="pending" @selected($status == 'pending')>Pending</option>
                            <option value="active" @selected($status == 'active')>Active</option>
                            <option value="rejected" @selected($status == 'rejected')>Rejected</option>
                            <option value="suspended" @selected($status == 'suspended')>Suspended</option>
                            <option value="banned" @selected($status == 'banned')>Banned</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="accordion" id="approvalNotes">
                        <div class="accordion-item border-0 rounded-3 overflow-hidden bg-primary-subtle">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#approvalNotesBody" aria-expanded="false"
                                    aria-controls="approvalNotesBody">
                                    <i class="fa-solid fa-circle-info me-2"></i>Good to know
                                </button>
                            </h2>
                            <div id="approvalNotesBody" class="accordion-collapse collapse">
                                <div class="accordion-body pt-0">
                                    <ul class="small mb-0 ps-3">
                                        <li class="mb-1"><strong>Pending</strong>, <strong>Rejected</strong>,
                                            <strong>Suspended</strong> and <strong>Banned</strong> vendors cannot sign
                                            in.</li>
                                        <li class="mb-1">Choosing <strong>Active</strong> and saving generates a
                                            temporary password and emails it to the personal email above.</li>
                                        <li class="mb-1">The email asks the vendor to change the password after the first
                                            login.</li>
                                        <li>The password is stored encrypted and is never shown again, so it cannot be
                                            recovered later.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-2 mt-4">
            <a href="{{ '' }}" class="btn btn-secondary bg-secondary-gradient">Cancel</a>
            <button type="submit" class="btn btn-primary bg-primary-gradient" id="saveBtn">
                <i class="fa-solid fa-floppy-disk me-1"></i>Save vendor
            </button>
        </div>
    </form>
@endsection

@push('js')
    <script>
        $(function() {
            let slugTouched = $('#store_slug').val().length > 0;
            $('#store_slug').on('input', () => slugTouched = true);
            $('#store_name').on('keyup', function() {
                if (slugTouched) return;
                $('#store_slug').val($(this).val().toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '').replace(/[\s_-]+/g, '-').replace(/^-+|-+$/g, ''));
            });

            function setupDropzone(cfg) {
                const input = document.getElementById(cfg.input);
                const $zone = $(cfg.zone);

                function showPreview(file) {
                    if (!file || !file.type.startsWith('image/')) return;
                    const reader = new FileReader();
                    reader.onload = e => $(cfg.preview).html($('<img>', {
                        src: e.target.result,
                        alt: cfg.alt
                    }));
                    reader.readAsDataURL(file);
                }

                $(cfg.btn).on('click', () => input.click());
                $(input).on('change', function() {
                    showPreview(this.files[0]);
                });

                $zone.on('dragenter dragover', e => {
                    e.preventDefault();
                    $zone.addClass('dragover');
                });
                $zone.on('dragleave dragend', e => {
                    e.preventDefault();
                    $zone.removeClass('dragover');
                });
                $zone.on('drop', e => {
                    e.preventDefault();
                    $zone.removeClass('dragover');
                    const files = e.originalEvent.dataTransfer.files;
                    if (!files.length) return;
                    input.files = files;
                    showPreview(files[0]);
                });
            }

            setupDropzone({
                input: 'store_logo',
                zone: '#logoDropzone',
                btn: '#logoBtn',
                preview: '#logoPreview',
                alt: 'Logo preview'
            });

            setupDropzone({
                input: 'avatar',
                zone: '#avatarDropzone',
                btn: '#avatarBtn',
                preview: '#avatarPreview',
                alt: 'Profile photo preview'
            });

            $('.phone-input').on('input', function() {
                this.value = this.value.replace(/[^0-9+\-\s()]/g, '');
            });

            $('#vendorForm').on('submit', function() {
                $('#saveBtn').prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm me-1"></span>Saving...');
            });
        });
    </script>
@endpush