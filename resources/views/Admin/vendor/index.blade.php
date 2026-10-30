@extends('admin.layout.app')

@push('css')
    <style>
        .row-checkbox {
            width: 18px;
            height: 18px;
        }

        .table thead th {
            background: #eeeeee75;
            white-space: nowrap;
        }

        .table>thead {
            border-bottom: 2px solid #dddddd80;
        }

        .table>thead>tr>th,
        .table>tbody>tr>td {
            padding: 10px 15px !important;
        }

        #content {
            padding-bottom: 80px;
        }

        .avatar {
            position: relative;
            flex-shrink: 0;
            --ring: #9ca3af;
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--ring);
            border-radius: 50%;
        }

        .avatar .avatar-title {
            font-weight: 600;
            font-size: 14px;
        }

        .avatar .avatar-img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .avatar-active    { --ring: #16a34a; }
        .avatar-pending   { --ring: #f59e0b; }
        .avatar-suspended { --ring: #9ca3af; }
        .avatar-rejected  { --ring: #dc2626; }
        .avatar-banned    { --ring: #7f1d1d; }

        .avatar-active::before,
        .avatar-pending::before,
        .avatar-suspended::before,
        .avatar-rejected::before,
        .avatar-banned::before {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            width: 27%;
            height: 27%;
            border-radius: 50%;
            border: 2px solid #fff;
            background: var(--ring);
        }

        .offcanvas .avatar-active::before,
        .offcanvas .avatar-pending::before,
        .offcanvas .avatar-suspended::before,
        .offcanvas .avatar-rejected::before,
        .offcanvas .avatar-banned::before {
            width: 24%;
            height: 24%;
        }

        .avatar-trigger {
            display: inline-flex;
            padding: 0;
            border: 0;
            background: transparent;
            border-radius: 50%;
            cursor: pointer;
            transition: transform .15s;
        }

        .avatar-trigger .avatar {
            display: inline-block;
            transition: box-shadow .15s;
        }

        .avatar-trigger:hover,
        .avatar-trigger:focus-visible {
            transform: translateY(-1px);
        }

        .avatar-trigger:hover .avatar,
        .avatar-trigger:focus-visible .avatar {
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--ring), 0 6px 14px rgba(15, 23, 42, .28);
        }

        .avatar-trigger:focus-visible {
            outline: 2px solid #c7d2fe;
            outline-offset: 4px;
        }

        .avatar-trigger.is-loading {
            cursor: progress;
            opacity: .6;
        }

        .vendor-name {
            font-weight: 600;
            line-height: 1.2;
        }

        .order-icon {
            color: saddlebrown;
        }

        .product-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px 2px 2px;
            border-radius: 50rem;
            background: #eaf2ff;
            color: #052c65;
            border: 1px solid #9ec5fe;
            font-size: 10.5px;
            font-weight: 500;
            line-height: 1;
            text-decoration: none;
            cursor: pointer;
            transition: background .15s, border-color .15s, box-shadow .15s, transform .15s;
        }

        .product-badge .pb-icon {
            width: 16px;
            height: 16px;
            margin-right: 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 8px;
            color: #fff;
            background: #0d6efd;
            transition: background .15s;
        }

        .product-badge .pb-count {
            margin-right: 3px;
            font-size: 11px;
            font-weight: 700;
        }

        a.product-badge:hover {
            background: #cfe2ff;
            border-color: #6ea8fe;
            color: #052c65;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(13, 110, 253, .18);
        }

        a.product-badge:hover .pb-icon {
            background: #0a58ca;
        }

        .bulk-bar {
            position: fixed;
            left: 50%;
            bottom: 24px;
            transform: translateX(-50%);
            z-index: 1050;
            padding: 8px 12px 8px 18px;
            gap: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .25);
        }

        .contact-canvas {
            width: 400px !important;
            max-width: 100%;
            background: #f6f7fb;
        }

        .contact-head {
            position: relative;
            padding: 22px 22px 50px;
            color: #0f172a;
            background-image: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);
        }

        .contact-canvas .badge {
            margin-left: unset;
            font-weight: 500;
            font-size: 13px;
        }

        .contact-head .avatar {
            box-shadow: 0 0 0 3px #fff, 0 0 0 6px var(--ring);
            margin: 6px;
        }

        .contact-head .btn-close {
            position: absolute;
            top: 16px;
            right: 16px;
        }

        .contact-vendor {
            font-size: 18px;
            font-weight: 600;
            line-height: 1.2;
        }

        .contact-sub,
        .contact-verified,
        .contact-joined  {
            margin-top: 2px;
            font-size: 12.5px;
            font-weight: 500;
            color: rgba(15, 23, 42, .8);
        }

        .contact-quick {
            display: flex;
            gap: 10px;
            margin: -28px 22px 0;
            position: relative;
            z-index: 1;
        }

        .contact-quick a {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 10px 6px;
            border-radius: 12px;
            background: #fff;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(15, 23, 42, .12);
            transition: transform .15s;
        }

        .contact-quick a:hover { transform: translateY(-2px); }
        .contact-quick a i { font-size: 16px; }
        .contact-quick .q-mail { color: #1d4ed8; }
        .contact-quick .q-call { color: #047857; }
        .contact-quick .q-wa { color: #15803d; }

        .contact-section {
            margin: 22px 22px 8px;
            font-size: 13px;
            font-weight: 600;
            color: #4b5563;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0 22px 10px;
            padding: 12px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
        }

        .contact-item .ci-icon,
        .contact-item .ci-avatar {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 15px;
        }

        .contact-item .ci-avatar {
            overflow: hidden;
            font-size: 14px;
            font-weight: 600;
        }

        .contact-item .ci-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .contact-item .ci-body {
            min-width: 0;
            flex: 1;
        }

        .contact-item .ci-label {
            font-size: 11.5px;
            color: #6b7280;
            line-height: 1.2;
        }

        .contact-item .ci-value {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #111827;
            text-decoration: none;
            word-break: break-word;
        }

        a.ci-value:hover { text-decoration: underline; }

        .ci-copy {
            border: 0;
            background: transparent;
            color: #9ca3af;
            width: 30px;
            height: 30px;
            border-radius: 8px;
        }

        .ci-copy:hover {
            background: #f3f4f6;
            color: #374151;
        }

        .ci-copy.copied,
        .ci-copy.copied i { color: #059669; }
        .ci-copy.copied i { font-size: 16px; }

        .ci-indigo { background: #e0e7ff; color: #3730a3; }
        .ci-violet { background: #ede9fe; color: #6d28d9; }
        .ci-blue   { background: #dbeafe; color: #1d4ed8; }
        .ci-green  { background: #d1fae5; color: #047857; }
        .ci-teal   { background: #cffafe; color: #0e7490; }
        .ci-lime   { background: #dcfce7; color: #15803d; }
        .ci-amber  { background: #fef3c7; color: #b45309; }
        .ci-rose   { background: #ffe4e6; color: #be123c; }
    </style>
@endpush

@section('content')
    <div class="card filter-option-card p-3 mb-3">
        <form action="{{ '' }}" method="GET" autocomplete="off">
            <div class="row g-2">
                <div class="col-md-2 col-6">
                    <select class="form-select" name="status" id="status">
                        <option value="" selected>All</option>
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="rejected">Rejected</option>
                        <option value="suspended">Suspended</option>
                        <option value="banned">Banned</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <select class="form-select" name="sort_by" id="sort_by">
                        <option value="" disabled selected hidden>Sort By</option>
                        <option value="date_asc">Date (Oldest First)</option>
                        <option value="date_desc">Date (Newest First)</option>
                        <option value="name_asc">Name (A-Z)</option>
                        <option value="name_desc">Name (Z-A)</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <input type="date" class="form-control datepicker" name="start_date" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="Joined From (Start Date)">
                </div>
                <div class="col-md-2 col-6">
                    <input type="date" class="form-control datepicker" name="end_date" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="Joined To (End Date)">
                </div>
                <div class="col-md-2 col-12">
                    <button type="submit" class="btn btn-secondary bg-secondary-gradient btn-sm">
                        <i class="fa-solid fa-filter me-1"></i>
                        Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card p-3">
        <div class="card-header py-3 px-0 pt-0">
            <div class="text-end">
                <button type="button" class="btn btn-secondary bg-secondary-gradient btn-sm" id="exportBtn">
                    <i class="fa-regular fa-file-excel"></i>
                    Export All
                </button>

                <a href="{{ route('admin.vendors.add') }}" class="btn btn-primary bg-primary-gradient btn-sm">
                    <i class="fa-solid fa-plus me-1"></i>
                    Add Vendor
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0" id="vendorTable">
                    <thead>
                        <tr>
                            <th style="width:40px;">
                                <input type="checkbox" class="form-check-input row-checkbox" id="selectAll">
                            </th>
                            <th>Vendor</th>
                            <th>Revenue</th>
                            <th>Joined</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vendors as $vendor)
                            <tr data-name="{{ $vendor->name }}" data-uuid="{{ $vendor->uuid }}">
                                <td>
                                    <input type="checkbox" class="form-check-input row-checkbox"
                                        data-uuid="{{ $vendor->uuid }}">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <button type="button" class="avatar-trigger js-contact-trigger"
                                            data-uuid="{{ $vendor->uuid }}"
                                            title="{{ ucfirst($vendor->status) }} &middot; View contact details"
                                            aria-label="View contact details for {{ $vendor->name }}">
                                            @php
                                                $logo  = getImageUrl($vendor->vendorProfile?->store_logo);
                                                $color = getAvatarColor($vendor->uuid);
                                            @endphp
                                            <span class="avatar {{ getStatusRing($vendor->status) }}">
                                                @if ($logo)
                                                    <span class="avatar-title rounded-circle p-0 overflow-hidden bg-white">
                                                        <img src="{{ $logo }}" alt="{{ $vendor->name }}" class="avatar-img">
                                                    </span>
                                                @else
                                                    <span class="avatar-title rounded-circle"
                                                        style="background: {{ $color['bg'] }}; color: {{ $color['text'] }};">
                                                        {{ getInitials($vendor->name) }}
                                                    </span>
                                                @endif
                                            </span>
                                        </button>
                                        <div>
                                            <div class="vendor-name">{{ $vendor->name }}</div>
                                            <a href="{{ '' }}" class="product-badge" title="View products">
                                                <span class="pb-icon"><i class="fa-solid fa-box"></i></span>
                                                <span class="pb-count">{{ $vendor->products_count ?? 0 }}</span>
                                                <span>products</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold fs-6">${{ number_format($vendor->revenue ?? 0, 2) }}</div>
                                    <div class="small text-muted">
                                        <i class="fa-solid fa-bag-shopping order-icon me-1"></i>{{ $vendor->orders_count ?? 0 }} orders
                                    </div>
                                </td>
                                <td>{{ optional($vendor->created_at)->format('jS M Y') }}</td>
                                <td>
                                    <div class="dropdown-options dropdown text-center">
                                        <button class="do-kebab-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end do-menu">
                                            <li>
                                                <a class="do-item do-item--amber view-action" href="{{ '' }}"
                                                    data-uuid="{{ $vendor->uuid }}">
                                                    <span class="do-badge do-badge--amber"><i class="fa-solid fa-eye"></i></span>
                                                    <span>View</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="do-item do-item--edit edit-action" href="{{ '' }}"
                                                    data-uuid="{{ $vendor->uuid }}">
                                                    <span class="do-badge do-badge--edit"><i class="fa-solid fa-pen"></i></span>
                                                    <span>Edit</span>
                                                </a>
                                            </li>
                                            <li>
                                                <div class="do-divider"></div>
                                            </li>
                                            <li>
                                                <a class="do-item do-item--delete delete-action" href="{{ '' }}"
                                                    data-uuid="{{ $vendor->uuid }}">
                                                    <span class="do-badge do-badge--delete"><i class="fa-solid fa-trash"></i></span>
                                                    <span>Delete</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No vendors found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer py-3">
            @include('admin.layout.components.pagination', ['items' => $vendors])
        </div>

    </div>

    <div id="contactCanvasHolder"></div>

    <div class="bg-dark text-white rounded-3 bulk-bar d-flex justify-content-between align-items-center d-none"
        id="bulkBar">
        <span class="fw-semibold" id="bulkCount"></span>
        <div class="btn-group ms-auto" role="group" aria-label="Bulk actions">
            <button class="btn btn-sm btn-dark bulk-approve">
                <i class="fa-solid fa-circle-check"></i> Approve
            </button>
            <button class="btn btn-sm btn-dark" id="exportSelectedBtn">
                <i class="fa-solid fa-file-export"></i> Export Selected
            </button>
            <button class="btn btn-sm btn-danger bulk-delete">
                <i class="fa-solid fa-trash"></i> Delete
            </button>
            <button class="btn btn-sm btn-link text-white text-decoration-underline" id="bulkClear">Clear</button>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            const $tbody = $('#vendorTable tbody');
            const $bulkBar = $('#bulkBar');
            const $holder = $('#contactCanvasHolder');

            const DETAILS_URL = "{{ route('admin.vendors.details', ':uuid') }}";

            const selectedUuids = () =>
                $tbody.find('.row-checkbox:checked').map((_, el) => $(el).data('uuid')).get();

            function refreshBulkBar() {
                const count = $tbody.find('.row-checkbox:checked').length;
                const total = $tbody.find('.row-checkbox').length;

                $bulkBar.toggleClass('d-none', count === 0);
                $('#bulkCount').text(count + ' selected');
                $('#selectAll')
                    .prop('checked', count > 0 && count === total)
                    .prop('indeterminate', count > 0 && count < total);
            }

            $('#selectAll').on('change', function() {
                $tbody.find('.row-checkbox:visible').prop('checked', this.checked);
                refreshBulkBar();
            });

            $tbody.on('change', '.row-checkbox', refreshBulkBar);

            $('#bulkClear').on('click', function() {
                $('.row-checkbox').prop('checked', false);
                refreshBulkBar();
            });

            let contactXhr = null;

            $tbody.on('click', '.js-contact-trigger', function() {
                const $btn = $(this);
                const uuid = $btn.data('uuid');

                if (contactXhr) contactXhr.abort();
                $btn.addClass('is-loading');

                contactXhr = $.ajax({
                        url: DETAILS_URL.replace(':uuid', uuid),
                        method: 'GET',
                        dataType: 'html'
                    })
                    .done(function(html) {
                        $holder.html(html);

                        const el = $holder.find('.offcanvas')[0];
                        if (!el) return;

                        el.addEventListener('hidden.bs.offcanvas', function() {
                            bootstrap.Offcanvas.getInstance(el)?.dispose();
                            $holder.empty();
                        }, {
                            once: true
                        });

                        bootstrap.Offcanvas.getOrCreateInstance(el).show();
                    })
                    .fail(function(xhr, status) {
                        if (status === 'abort') return;
                        console.error('Could not load contact details:', xhr.status);
                        alert('Could not load contact details. Please try again.');
                    })
                    .always(function() {
                        $btn.removeClass('is-loading');
                    });
            });

            const COPIED_MS = 3000;

            function copyText(text, container) {
                if (navigator.clipboard && window.isSecureContext) {
                    return navigator.clipboard.writeText(text);
                }

                return new Promise(function(resolve, reject) {
                    const ta = document.createElement('textarea');
                    ta.value = text;
                    ta.setAttribute('readonly', '');
                    ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0;';
                    container.appendChild(ta);
                    ta.select();
                    ta.setSelectionRange(0, text.length);

                    try {
                        document.execCommand('copy') ? resolve() : reject(new Error('Copy command failed'));
                    } catch (err) {
                        reject(err);
                    } finally {
                        ta.remove();
                    }
                });
            }

            $holder.on('click', '.ci-copy', function() {
                const $btn = $(this);
                const text = $.trim($btn.closest('.contact-item').find('.ci-value').text());

                if (!text) return;

                copyText(text, $btn.closest('.offcanvas')[0]).then(function() {
                    clearTimeout($btn.data('timer'));

                    $btn.addClass('copied').attr('title', 'Copied')
                        .find('i').attr('class', 'fa-solid fa-check');

                    $btn.data('timer', setTimeout(function() {
                        $btn.removeClass('copied').attr('title', 'Copy')
                            .find('i').attr('class', 'fa-regular fa-copy');
                    }, COPIED_MS));
                }).catch(function(err) {
                    console.error('Copy failed:', err);
                });
            });

            $bulkBar.on('click', '.bulk-approve', () => console.log('Approve vendors', selectedUuids()));
            $bulkBar.on('click', '.bulk-delete', () => console.log('Delete vendors', selectedUuids()));
            $('#exportBtn').on('click', () => console.log('Export all vendors'));
            $('#exportSelectedBtn').on('click', () => console.log('Export selected vendors', selectedUuids()));
        });
    </script>
@endpush