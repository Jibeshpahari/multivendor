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

        /* ---------- Vendor cell ---------- */
        /* Kaiadmin .avatar + status classes; only the ring colour and the rejected dot are custom */
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

        .avatar-away::before,
        .avatar-offline::before,
        .avatar-online::before,
        .avatar-rejected:before {
            width: 27%;
            height: 27%;
        }

        .avatar-online {
            --ring: #16a34a;
            /* box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--ring), 0 0 0 8px rgba(22, 163, 74, .16); */
        }

        .avatar-away {
            --ring: #f59e0b;
        }

        .avatar-offline {
            --ring: #9ca3af;
        }

        .avatar-rejected {
            --ring: #dc2626;
        }

        .avatar-rejected:before {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            border-radius: 50%;
            border: 2px solid #fff;
            background: #dc2626;
        }

        .vendor-name {
            font-weight: 600;
            line-height: 1.2;
        }

        .vendor-meta {
            font-size: 12px;
            color: #6c757d;
        }

        /* ---------- Contact trigger ---------- */
        .contact-trigger {
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #c7d2fe;
            border-radius: 8px;
            background: #eef2ff;
            color: #4338ca;
            font-size: 14px;
            transition: background .15s, color .15s, border-color .15s;
        }

        .vendor-name+.contact-trigger {
            margin-left: -4px;
        }

        .contact-trigger:hover,
        .contact-trigger:focus-visible {
            background: #4338ca;
            border-color: #4338ca;
            color: #fff;
        }

        /* ---------- Contact side panel ---------- */
        .contact-canvas {
            width: 400px !important;
            max-width: 100%;
            background: #f6f7fb;
        }

        .contact-head {
            position: relative;
            padding: 22px 22px 56px;
            color: #fff;
            background: linear-gradient(135deg, #1e1b4b 0%, #3730a3 55%, #4f46e5 100%);
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

        .contact-sub {
            font-size: 13px;
            color: rgba(255, 255, 255, .75);
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
            box-shadow: 0 4px 14px rgba(30, 27, 75, .12);
            transition: transform .15s;
        }

        .contact-quick a:hover {
            transform: translateY(-2px);
        }

        .contact-quick a i {
            font-size: 16px;
        }

        .contact-quick .q-mail {
            color: #1d4ed8;
        }

        .contact-quick .q-call {
            color: #047857;
        }

        .contact-quick .q-wa {
            color: #15803d;
        }

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

        .contact-item .ci-icon {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 15px;
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

        a.ci-value:hover {
            text-decoration: underline;
        }

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

        .ci-copy.copied {
            color: #059669;
        }

        .ci-indigo {
            background: #e0e7ff;
            color: #3730a3;
        }

        .ci-violet {
            background: #ede9fe;
            color: #6d28d9;
        }

        .ci-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .ci-green {
            background: #d1fae5;
            color: #047857;
        }

        .ci-teal {
            background: #cffafe;
            color: #0e7490;
        }

        .ci-lime {
            background: #dcfce7;
            color: #15803d;
        }

        .ci-amber {
            background: #fef3c7;
            color: #b45309;
        }

        .order-icon {
            color: saddlebrown;
            /* alternatives: darkmagenta, darkslategray, olive */
        }

        /* ---------- Product badge (icon chip + count) ---------- */
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

        .product-badge.is-empty {
            background: #f3f4f6;
            border-color: #e5e7eb;
            /* color: #6b7280; */
            color: #505050;
            cursor: default;
        }

        .product-badge.is-empty .pb-icon {
            background: #cbd5e1;
        }

        /* ---------- Bulk bar ---------- */
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

        #content {
            padding-bottom: 80px;
        }
    </style>
@endpush

@section('content')
    {{-- Filters --}}
    <div class="card filter-option-card p-3 mb-3">
        <form action="{{ '' }}" method="GET" autocomplete="off">
            <div class="row g-2">
                <div class="col-md-2 col-6">
                    <select class="form-select" name="status" id="status">
                        <option value="" disabled selected hidden>Status</option>
                        <option value="approved">Approved</option>
                        <option value="pending_approval">Pending</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <select class="form-select" name="date_sort" id="sort">
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

    {{-- Vendor table --}}
    <div class="card p-3">
        <div class="card-header py-3 px-0 pt-0">
            <div class="text-end">
                <div>
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
                        <tr data-name="Green Basket Traders">
                            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="1"></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar avatar-online" title="Active"><span class="avatar-title rounded-circle" style="background:#198754;">GB</span></div>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="vendor-name">Green Basket Traders</div>
                                            <button type="button" class="contact-trigger" data-bs-toggle="offcanvas"
                                                data-bs-target="#contactCanvas" title="View contact details"
                                                aria-label="View contact details for Anita Sharma"
                                                data-vendor="Green Basket Traders" data-initials="GB" data-color="#198754"
                                                data-status="Approved" data-status-class="approved"
                                                data-person="Anita Sharma" data-role="Owner"
                                                data-personal-email="anita.sharma@gmail.com" data-org-email="anita@greenbasket.in"
                                                data-phone="+91 98300 12345" data-alt-phone="+91 33 4001 2200"
                                                data-whatsapp="+91 98300 12345" data-address="12 Park Street, Kolkata, West Bengal 700016">
                                                <i class="fa-solid fa-address-card"></i>
                                            </button>
                                        </div>
                                        <a href="{{ '' }}" class="product-badge" title="View products">
                                            <span class="pb-icon"><i class="fa-solid fa-box"></i></span>
                                            <span class="pb-count">48</span><span>products</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div title="Avg. order $36.49">
                                    <div class="fw-bold fs-6">
                                        $12,480
                                    </div>
                                    <div class="small text-muted"><i class="fa-solid fa-bag-shopping order-icon me-1"></i>342 orders</div>
                                </div>
                            </td>
                            <td>4th Nov 2025</td>
                            <td>
                                <div class="dropdown-options dropdown text-center">
                                    <button class="do-kebab-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end do-menu">
                                        <li>
                                            <a class="do-item do-item--amber flag-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--amber"><i class="fa-solid fa-eye"></i></span>
                                                <span>View</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="do-item do-item--edit edit-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--edit"><i class="fa-solid fa-pen"></i></span>
                                                <span>Edit</span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="do-divider"></div>
                                        </li>
                                        <li>
                                            <a class="do-item do-item--delete delete-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--delete"><i class="fa-solid fa-trash"></i></span>
                                                <span>Delete</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <tr data-name="Kolkata Spice House">
                            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="2"></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar avatar-online" title="Active"><span class="avatar-title rounded-circle" style="background:#d63384;">KS</span></div>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="vendor-name">Kolkata Spice House</div>
                                            <button type="button" class="contact-trigger" data-bs-toggle="offcanvas"
                                                data-bs-target="#contactCanvas" title="View contact details"
                                                aria-label="View contact details for Rahul Dutta"
                                                data-vendor="Kolkata Spice House" data-initials="KS" data-color="#d63384"
                                                data-status="Approved" data-status-class="approved"
                                                data-person="Rahul Dutta" data-role="Managing Partner"
                                                data-personal-email="rahul.dutta@gmail.com" data-org-email="rahul@spicehouse.in"
                                                data-phone="+91 98310 55421" data-alt-phone="+91 33 2245 8890"
                                                data-whatsapp="+91 98310 55421" data-address="45 Burrabazar Road, Kolkata, West Bengal 700007">
                                                <i class="fa-solid fa-address-card"></i>
                                            </button>
                                        </div>
                                        <a href="{{ '' }}" class="product-badge" title="View products">
                                            <span class="pb-icon"><i class="fa-solid fa-box"></i></span>
                                            <span class="pb-count">126</span><span>products</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div title="Avg. order $35.52">
                                    <div class="fw-bold fs-6">
                                        $28,950
                                    </div>
                                    <div class="small text-muted"><i class="fa-solid fa-bag-shopping order-icon me-1"></i>815 orders</div>
                                </div>
                            </td>
                            <td>18th Sep 2025</td>
                            <td>
                                <div class="dropdown-options dropdown text-center">
                                    <button class="do-kebab-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end do-menu">
                                        <li>
                                            <a class="do-item do-item--amber flag-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--amber"><i class="fa-solid fa-eye"></i></span>
                                                <span>View</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="do-item do-item--edit edit-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--edit"><i class="fa-solid fa-pen"></i></span>
                                                <span>Edit</span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="do-divider"></div>
                                        </li>
                                        <li>
                                            <a class="do-item do-item--delete delete-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--delete"><i class="fa-solid fa-trash"></i></span>
                                                <span>Delete</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <tr data-name="Urban Loom Textiles">
                            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="3"></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar avatar-away" title="Pending approval"><span class="avatar-title rounded-circle" style="background:#fd7e14;">UL</span></div>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="vendor-name">Urban Loom Textiles</div>
                                            <button type="button" class="contact-trigger" data-bs-toggle="offcanvas"
                                                data-bs-target="#contactCanvas" title="View contact details"
                                                aria-label="View contact details for Meera Iyer"
                                                data-vendor="Urban Loom Textiles" data-initials="UL" data-color="#fd7e14"
                                                data-status="Pending" data-status-class="pending"
                                                data-person="Meera Iyer" data-role="Founder"
                                                data-personal-email="meera.iyer@outlook.com" data-org-email="meera@urbanloom.in"
                                                data-phone="+91 98765 43210" data-alt-phone="+91 44 2811 7700"
                                                data-whatsapp="+91 98765 43210" data-address="8 Anna Salai, Chennai, Tamil Nadu 600002">
                                                <i class="fa-solid fa-address-card"></i>
                                            </button>
                                        </div>
                                        <span class="product-badge is-empty">
                                            <span class="pb-icon"><i class="fa-solid fa-box"></i></span>
                                            <span>No products</span>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div title="No orders yet">
                                    <div class="fw-bold fs-6 text-muted">
                                        $0
                                    </div>
                                    <div class="small text-muted"><i class="fa-solid fa-bag-shopping order-icon me-1"></i>0 orders</div>
                                </div>
                            </td>
                            <td>11th Feb 2026</td>
                            <td>
                                <div class="dropdown-options dropdown text-center">
                                    <button class="do-kebab-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end do-menu">
                                        <li>
                                            <a class="do-item do-item--amber flag-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--amber"><i class="fa-solid fa-eye"></i></span>
                                                <span>View</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="do-item do-item--edit edit-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--edit"><i class="fa-solid fa-pen"></i></span>
                                                <span>Edit</span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="do-divider"></div>
                                        </li>
                                        <li>
                                            <a class="do-item do-item--delete delete-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--delete"><i class="fa-solid fa-trash"></i></span>
                                                <span>Delete</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <tr data-name="Sunrise Electronics">
                            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="4"></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar avatar-offline" title="Inactive"><span class="avatar-title rounded-circle" style="background:#0d6efd;">SE</span></div>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="vendor-name">Sunrise Electronics</div>
                                            <button type="button" class="contact-trigger" data-bs-toggle="offcanvas"
                                                data-bs-target="#contactCanvas" title="View contact details"
                                                aria-label="View contact details for Sourav Ghosh"
                                                data-vendor="Sunrise Electronics" data-initials="SE" data-color="#0d6efd"
                                                data-status="Approved" data-status-class="approved"
                                                data-person="Sourav Ghosh" data-role="Director"
                                                data-personal-email="sourav.ghosh@gmail.com" data-org-email="sourav@sunrise.in"
                                                data-phone="+91 97330 88120" data-alt-phone="+91 33 4015 6600"
                                                data-whatsapp="+91 97330 88120" data-address="Sector V, Salt Lake, Kolkata, West Bengal 700091">
                                                <i class="fa-solid fa-address-card"></i>
                                            </button>
                                        </div>
                                        <a href="{{ '' }}" class="product-badge" title="View products">
                                            <span class="pb-icon"><i class="fa-solid fa-box"></i></span>
                                            <span class="pb-count">72</span><span>products</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div title="Avg. order $144.44">
                                    <div class="fw-bold fs-6">
                                        $18,200
                                    </div>
                                    <div class="small text-muted"><i class="fa-solid fa-bag-shopping order-icon me-1"></i>126 orders</div>
                                </div>
                            </td>
                            <td>23rd Dec 2025</td>
                            <td>
                                <div class="dropdown-options dropdown text-center">
                                    <button class="do-kebab-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end do-menu">
                                        <li>
                                            <a class="do-item do-item--amber flag-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--amber"><i class="fa-solid fa-eye"></i></span>
                                                <span>View</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="do-item do-item--edit edit-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--edit"><i class="fa-solid fa-pen"></i></span>
                                                <span>Edit</span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="do-divider"></div>
                                        </li>
                                        <li>
                                            <a class="do-item do-item--delete delete-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--delete"><i class="fa-solid fa-trash"></i></span>
                                                <span>Delete</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <tr data-name="Pixel Print Studio">
                            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="5"></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar avatar-rejected" title="Rejected"><span class="avatar-title rounded-circle" style="background:#6f42c1;">PP</span></div>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="vendor-name">Pixel Print Studio</div>
                                            <button type="button" class="contact-trigger" data-bs-toggle="offcanvas"
                                                data-bs-target="#contactCanvas" title="View contact details"
                                                aria-label="View contact details for Debjani Roy"
                                                data-vendor="Pixel Print Studio" data-initials="PP" data-color="#6f42c1"
                                                data-status="Rejected" data-status-class="rejected"
                                                data-person="Debjani Roy" data-role="Proprietor"
                                                data-personal-email="debjani.roy@yahoo.com" data-org-email="debjani@pixelprint.in"
                                                data-phone="+91 98001 77654" data-alt-phone="+91 33 2466 1010"
                                                data-whatsapp="+91 98001 77654" data-address="27 College Street, Kolkata, West Bengal 700073">
                                                <i class="fa-solid fa-address-card"></i>
                                            </button>
                                        </div>
                                        <a href="{{ '' }}" class="product-badge" title="View products">
                                            <span class="pb-icon"><i class="fa-solid fa-box"></i></span>
                                            <span class="pb-count">9</span><span>products</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div title="Avg. order $47.86">
                                    <div class="fw-bold fs-6">
                                        $1,340
                                    </div>
                                    <div class="small text-muted"><i class="fa-solid fa-bag-shopping order-icon me-1"></i>28 orders</div>
                                </div>
                            </td>
                            <td>7th Jan 2026</td>
                            <td>
                                <div class="dropdown-options dropdown text-center">
                                    <button class="do-kebab-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end do-menu">
                                        <li>
                                            <a class="do-item do-item--amber flag-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--amber"><i class="fa-solid fa-eye"></i></span>
                                                <span>View</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="do-item do-item--edit edit-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--edit"><i class="fa-solid fa-pen"></i></span>
                                                <span>Edit</span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="do-divider"></div>
                                        </li>
                                        <li>
                                            <a class="do-item do-item--delete delete-action" href="{{ '' }}">
                                                <span class="do-badge do-badge--delete"><i class="fa-solid fa-trash"></i></span>
                                                <span>Delete</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Contact side panel --}}
    <div class="offcanvas offcanvas-end contact-canvas" tabindex="-1" id="contactCanvas"
        aria-labelledby="contactTitle">
        <div class="contact-head">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
            <div class="d-flex align-items-center gap-3">
                <div class="avatar avatar-xl"><span class="avatar-title rounded-circle" id="cAvatar"></span></div>
                <div>
                    <div class="contact-vendor" id="contactTitle"></div>
                    <div class="contact-sub"><span id="cPerson"></span> &middot; <span id="cRole"></span></div>
                </div>
            </div>
            <div class="mt-3"><span class="badge rounded-pill" id="cStatus"></span></div>
        </div>

        <div class="contact-quick">
            <a href="#" class="q-mail" id="qMail"><i class="fa-solid fa-envelope"></i>Email</a>
            <a href="#" class="q-call" id="qCall"><i class="fa-solid fa-phone"></i>Call</a>
            <a href="#" class="q-wa" id="qWa" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i>WhatsApp</a>
        </div>

        <div class="offcanvas-body p-0 pb-4">
            <div class="contact-section">Contact person</div>
            <div class="contact-item" data-item="person">
                <span class="ci-icon ci-indigo"><i class="fa-solid fa-user-tie"></i></span>
                <div class="ci-body">
                    <div class="ci-label" id="cPersonLabel"></div>
                    <span class="ci-value" data-field="person"></span>
                </div>
                <button type="button" class="ci-copy" title="Copy" aria-label="Copy name"><i class="fa-regular fa-copy"></i></button>
            </div>

            <div class="contact-section">Email</div>
        <div class="contact-item" data-item="personalEmail">
            <span class="ci-icon ci-violet"><i class="fa-solid fa-user"></i></span>
            <div class="ci-body">
                <div class="ci-label">Personal email</div>
                <a class="ci-value" href="#" data-field="personalEmail" data-link="mailto:"></a>
            </div>
            <button type="button" class="ci-copy" title="Copy" aria-label="Copy Personal email"><i class="fa-regular fa-copy"></i></button>
        </div>
        <div class="contact-item" data-item="orgEmail">
            <span class="ci-icon ci-blue"><i class="fa-solid fa-building"></i></span>
            <div class="ci-body">
                <div class="ci-label">Organization email</div>
                <a class="ci-value" href="#" data-field="orgEmail" data-link="mailto:"></a>
            </div>
            <button type="button" class="ci-copy" title="Copy" aria-label="Copy Organization email"><i class="fa-regular fa-copy"></i></button>
        </div>

            <div class="contact-section">Phone</div>
        <div class="contact-item" data-item="phone">
            <span class="ci-icon ci-green"><i class="fa-solid fa-mobile-screen"></i></span>
            <div class="ci-body">
                <div class="ci-label">Mobile</div>
                <a class="ci-value" href="#" data-field="phone" data-link="tel:"></a>
            </div>
            <button type="button" class="ci-copy" title="Copy" aria-label="Copy Mobile"><i class="fa-regular fa-copy"></i></button>
        </div>
        <div class="contact-item" data-item="altPhone">
            <span class="ci-icon ci-teal"><i class="fa-solid fa-phone-volume"></i></span>
            <div class="ci-body">
                <div class="ci-label">Alternate / office</div>
                <a class="ci-value" href="#" data-field="altPhone" data-link="tel:"></a>
            </div>
            <button type="button" class="ci-copy" title="Copy" aria-label="Copy Alternate / office"><i class="fa-regular fa-copy"></i></button>
        </div>
        <div class="contact-item" data-item="whatsapp">
            <span class="ci-icon ci-lime"><i class="fa-brands fa-whatsapp"></i></span>
            <div class="ci-body">
                <div class="ci-label">WhatsApp</div>
                <span class="ci-value" data-field="whatsapp"></span>
            </div>
            <button type="button" class="ci-copy" title="Copy" aria-label="Copy WhatsApp"><i class="fa-regular fa-copy"></i></button>
        </div>

            <div class="contact-section">Address</div>
        <div class="contact-item" data-item="address">
            <span class="ci-icon ci-amber"><i class="fa-solid fa-location-dot"></i></span>
            <div class="ci-body">
                <div class="ci-label">Business address</div>
                <span class="ci-value" data-field="address"></span>
            </div>
            <button type="button" class="ci-copy" title="Copy" aria-label="Copy Business address"><i class="fa-regular fa-copy"></i></button>
        </div>
        </div>
    </div>

    {{-- Bulk Edit Bar --}}
    <div class="bg-dark text-white rounded-3 bulk-bar d-flex justify-content-between align-items-center d-none"
        id="bulkBar">
        <span class="fw-semibold bulk-count" id="bulkCount"></span>
        <div class="btn-group ms-auto" role="group" aria-label="Bulk actions">
            <button class="btn btn-sm btn-dark bulk-approve">
                <i class="fa-solid fa-circle-check"></i> Approve
            </button>
            <button class="btn btn-sm btn-dark bulk-export" id="exportSelectedBtn">
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
            const $table = $('#vendorTable');
            const $tbody = $table.find('tbody');
            const $bulkBar = $('#bulkBar');

            /* ---------- Selection + bulk bar ---------- */
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

            /* ---------- Contact side panel ---------- */
            $('#contactCanvas').on('show.bs.offcanvas', function(e) {
                const d = $(e.relatedTarget).data();
                const digits = String(d.whatsapp).replace(/\D/g, '');

                $('#cAvatar').text(d.initials).css('background', d.color);
                $('#contactTitle').text(d.vendor);
                $('#cPerson').text(d.person);
                $('#cRole').text(d.role);
                $('#cPersonLabel').text(d.role);
                const badgeMap = {
                    approved: 'bg-success',
                    pending: 'bg-warning text-dark',
                    rejected: 'bg-danger'
                };
                $('#cStatus').attr('class', 'badge rounded-pill ' + badgeMap[d.statusClass]).text(d.status);

                const values = {
                    person: d.person,
                    personalEmail: d.personalEmail,
                    orgEmail: d.orgEmail,
                    phone: d.phone,
                    altPhone: d.altPhone,
                    whatsapp: d.whatsapp,
                    address: d.address
                };

                $.each(values, function(field, value) {
                    const $item = $('[data-item="' + field + '"]');
                    const $val = $item.find('[data-field]');

                    $item.toggle(!!value);
                    $val.text(value);
                    if ($val.is('a')) {
                        $val.attr('href', $val.data('link') + String(value).replace(/\s/g, ''));
                    }
                });

                $('#qMail').attr('href', 'mailto:' + d.orgEmail);
                $('#qCall').attr('href', 'tel:' + String(d.phone).replace(/\s/g, ''));
                $('#qWa').attr('href', 'https://wa.me/' + digits);
            });

            $('#contactCanvas').on('click', '.ci-copy', function() {
                const $btn = $(this);
                const text = $btn.closest('.contact-item').find('[data-field]').text();

                navigator.clipboard.writeText(text).then(function() {
                    $btn.addClass('copied').find('i').attr('class', 'fa-solid fa-check');
                    setTimeout(function() {
                        $btn.removeClass('copied').find('i').attr('class', 'fa-regular fa-copy');
                    }, 1200);
                });
            });

            /* ---------- Export ---------- */
            $('#exportBtn').on('click', function() {
                console.log('Export all vendors');
            });

            $('#exportSelectedBtn').on('click', function() {
                const ids = $tbody.find('.row-checkbox:checked').map((_, el) => $(el).data('id')).get();
                console.log('Export selected vendors', ids);
            });
        });
    </script>
@endpush