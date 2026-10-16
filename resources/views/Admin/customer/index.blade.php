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

        /* ---------- Customer cell ---------- */
        /* Kaiadmin .avatar + status classes; only the ring colour and the blocked dot are custom */
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
        .avatar-blocked::before {
            width: 27%;
            height: 27%;
        }

        /* active */
        .avatar-online {
            --ring: #16a34a;
        }

        /* unverified */
        .avatar-away {
            --ring: #f59e0b;
        }

        /* inactive */
        .avatar-offline {
            --ring: #9ca3af;
        }

        /* blocked */
        .avatar-blocked {
            --ring: #dc2626;
        }

        .avatar-blocked::before {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            border-radius: 50%;
            border: 2px solid #fff;
            background: #dc2626;
        }

        .customer-name {
            font-weight: 600;
            line-height: 1.2;
        }

        .customer-meta {
            font-size: 12px;
            color: #6c757d;
        }

        /* ---------- Avatar = contact trigger ---------- */
        /* The avatar itself opens the contact panel; no extra button needed */
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

        /* ---------- Contact side panel ---------- */
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

        .contact-head .btn-close {
            position: absolute;
            top: 16px;
            right: 16px;
        }

        .contact-customer {
            font-size: 18px;
            font-weight: 600;
            line-height: 1.2;
        }

        .contact-sub {
            font-size: 13px;
            color: rgba(15, 23, 42, .65);
        }

        .contact-joined {
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

        .ci-rose {
            background: #ffe4e6;
            color: #be123c;
        }

        .order-icon {
            color: saddlebrown;
        }

        /* ---------- Plan badge (subscription) ---------- */
        /* Colour comes from the modifier; add a plan by adding one modifier */
        .plan-badge {
            --pb-bg: #f3f4f6;
            --pb-border: #e5e7eb;
            --pb-text: #505050;
            --pb-chip: #cbd5e1;
            display: inline-flex;
            align-items: center;
            padding: 2px 8px 2px 2px;
            border-radius: 50rem;
            background: var(--pb-bg);
            color: var(--pb-text);
            border: 1px solid var(--pb-border);
            font-size: 10.5px;
            font-weight: 500;
            line-height: 1;
        }

        .plan-badge .pb-icon {
            width: 16px;
            height: 16px;
            margin-right: 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 8px;
            color: #fff;
            background: var(--pb-chip);
        }

        .plan-badge .pb-label {
            font-weight: 600;
        }

        .plan-badge--silver {
            --pb-bg: #f1f5f9;
            --pb-border: #cbd5e1;
            --pb-text: #334155;
            --pb-chip: #64748b;
        }

        .plan-badge--gold {
            --pb-bg: #fff8e1;
            --pb-border: #fcd34d;
            --pb-text: #78350f;
            --pb-chip: #d97706;
        }

        .plan-badge--platinum {
            --pb-bg: #f5f3ff;
            --pb-border: #c4b5fd;
            --pb-text: #4c1d95;
            --pb-chip: #7c3aed;
        }

        /* ---------- Segment icon (beside the name) ---------- */
        .segment-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 9px;
            color: #fff;
            background: #94a3b8;
        }

        .segment-icon--returning {
            background: #0d6efd;
        }

        .segment-icon--new {
            background: #16a34a;
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
                        <option value="active">Active</option>
                        <option value="unverified">Unverified</option>
                        <option value="inactive">Inactive</option>
                        <option value="blocked">Blocked</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <select class="form-select" name="plan" id="plan">
                        <option value="" disabled selected hidden>Plan</option>
                        <option value="platinum">Platinum</option>
                        <option value="gold">Gold</option>
                        <option value="silver">Silver</option>
                        <option value="none">No plan</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <select class="form-select" name="sort" id="sort">
                        <option value="" disabled selected hidden>Sort By</option>
                        <option value="date_desc">Joined (Newest First)</option>
                        <option value="date_asc">Joined (Oldest First)</option>
                        <option value="name_asc">Name (A-Z)</option>
                        <option value="name_desc">Name (Z-A)</option>
                        <option value="spent_desc">Total Spent (High to Low)</option>
                        <option value="orders_desc">Orders (Most First)</option>
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

    {{-- Customer table --}}
    <div class="card p-3">
        <div class="card-header py-3 px-0 pt-0">
            <div class="text-end">
                <div>
                    <button type="button" class="btn btn-secondary bg-secondary-gradient btn-sm" id="exportBtn">
                        <i class="fa-regular fa-file-excel"></i>
                        Export All
                    </button>

                    <a href="{{ route('admin.customers.add') }}" class="btn btn-primary bg-primary-gradient btn-sm">
                        <i class="fa-solid fa-plus me-1"></i>
                        Add Customer
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body px-0 py-3">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0" id="customerTable">
                    <thead>
                        <tr>
                            <th style="width:40px;">
                                <input type="checkbox" class="form-check-input row-checkbox" id="selectAll">
                            </th>
                            <th>Customer</th>
                            <th>Total Spent</th>
                            <th>Last Order</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-name="Ananya Mukherjee">
                            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="1"></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <button type="button" class="avatar-trigger" data-bs-toggle="offcanvas"
                                        data-bs-target="#contactCanvas" title="Active &middot; View contact details"
                                        aria-label="View contact details for Ananya Mukherjee"
                                        data-customer="Ananya Mukherjee" data-joined="4th Nov 2025"
                                        data-initials="AM" data-color="#198754"
                                        data-status="Active" data-status-class="active"
                                        data-segment="Returning customer"
                                        data-plan="platinum" data-plan-note="Renews 12th Nov 2026" data-plan-state="active"
                                        data-email="ananya.mukherjee@gmail.com" data-phone="+91 98300 12345" data-whatsapp="+91 98300 12345"
                                        data-shipping="12 Park Street, Kolkata, West Bengal 700016"
                                        data-billing="Flat 4B, Lake Gardens, Kolkata, West Bengal 700045">
                                        <span class="avatar avatar-online"><span class="avatar-title rounded-circle" style="background:#198754;">AM</span></span>
                                    </button>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="customer-name">Ananya Mukherjee</div>
                                            <span class="segment-icon segment-icon--returning" title="Returning customer"><i class="fa-solid fa-repeat"></i></span>
                                        </div>
                                        <span class="plan-badge plan-badge--platinum" title="Platinum membership">
                                            <span class="pb-icon"><i class="fa-solid fa-gem"></i></span>
                                            <span class="pb-label">Platinum</span>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div title="Avg. order $114.77">
                                    <div class="fw-bold fs-6">$9,870</div>
                                    <div class="small text-muted"><i class="fa-solid fa-bag-shopping order-icon me-1"></i>86 orders</div>
                                </div>
                            </td>
                            <td>
                                <div>12th Oct 2026</div>
                                <div class="customer-meta">4 days ago</div>
                            </td>
                            <td>
                                <div class="dropdown-options dropdown text-center">
                                    <button class="do-kebab-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end do-menu">
                                        <li>
                                            <a class="do-item do-item--amber view-action" href="{{ '' }}">
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

                        <tr data-name="Rohit Banerjee">
                            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="2"></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <button type="button" class="avatar-trigger" data-bs-toggle="offcanvas"
                                        data-bs-target="#contactCanvas" title="Active &middot; View contact details"
                                        aria-label="View contact details for Rohit Banerjee"
                                        data-customer="Rohit Banerjee" data-joined="18th Sep 2025"
                                        data-initials="RB" data-color="#d63384"
                                        data-status="Active" data-status-class="active"
                                        data-segment="Returning customer"
                                        data-plan="gold" data-plan-note="Renews 30th Oct 2026" data-plan-state="active"
                                        data-email="rohit.banerjee@outlook.com" data-phone="+91 98310 55421" data-whatsapp="+91 98310 55421"
                                        data-shipping="45 Burrabazar Road, Kolkata, West Bengal 700007"
                                        data-billing="45 Burrabazar Road, Kolkata, West Bengal 700007">
                                        <span class="avatar avatar-online"><span class="avatar-title rounded-circle" style="background:#d63384;">RB</span></span>
                                    </button>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="customer-name">Rohit Banerjee</div>
                                            <span class="segment-icon segment-icon--returning" title="Returning customer"><i class="fa-solid fa-repeat"></i></span>
                                        </div>
                                        <span class="plan-badge plan-badge--gold" title="Gold membership">
                                            <span class="pb-icon"><i class="fa-solid fa-crown"></i></span>
                                            <span class="pb-label">Gold</span>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div title="Avg. order $89.00">
                                    <div class="fw-bold fs-6">$1,246</div>
                                    <div class="small text-muted"><i class="fa-solid fa-bag-shopping order-icon me-1"></i>14 orders</div>
                                </div>
                            </td>
                            <td>
                                <div>2nd Oct 2026</div>
                                <div class="customer-meta">2 weeks ago</div>
                            </td>
                            <td>
                                <div class="dropdown-options dropdown text-center">
                                    <button class="do-kebab-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end do-menu">
                                        <li>
                                            <a class="do-item do-item--amber view-action" href="{{ '' }}">
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

                        <tr data-name="Priya Nair">
                            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="3"></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <button type="button" class="avatar-trigger" data-bs-toggle="offcanvas"
                                        data-bs-target="#contactCanvas" title="Unverified &middot; View contact details"
                                        aria-label="View contact details for Priya Nair"
                                        data-customer="Priya Nair" data-joined="9th Oct 2026"
                                        data-initials="PN" data-color="#fd7e14"
                                        data-status="Unverified" data-status-class="unverified"
                                        data-segment="No orders yet"
                                        data-plan="none" data-plan-note="" data-plan-state=""
                                        data-email="priya.nair@yahoo.com" data-phone="+91 98765 43210" data-whatsapp=""
                                        data-shipping="8 Anna Salai, Chennai, Tamil Nadu 600002"
                                        data-billing="">
                                        <span class="avatar avatar-away"><span class="avatar-title rounded-circle" style="background:#fd7e14;">PN</span></span>
                                    </button>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="customer-name">Priya Nair</div>
                                            <span class="segment-icon segment-icon--none" title="No orders yet"><i class="fa-solid fa-minus"></i></span>
                                        </div>
                                        <span class="plan-badge" title="No active subscription">
                                            <span class="pb-icon"><i class="fa-solid fa-minus"></i></span>
                                            <span class="pb-label">No plan</span>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div title="No orders yet">
                                    <div class="fw-bold fs-6 text-muted">$0</div>
                                    <div class="small text-muted"><i class="fa-solid fa-bag-shopping order-icon me-1"></i>0 orders</div>
                                </div>
                            </td>
                            <td class="text-muted">&mdash;</td>
                            <td>
                                <div class="dropdown-options dropdown text-center">
                                    <button class="do-kebab-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end do-menu">
                                        <li>
                                            <a class="do-item do-item--amber view-action" href="{{ '' }}">
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

                        <tr data-name="Karan Mehta">
                            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="4"></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <button type="button" class="avatar-trigger" data-bs-toggle="offcanvas"
                                        data-bs-target="#contactCanvas" title="Inactive &middot; View contact details"
                                        aria-label="View contact details for Karan Mehta"
                                        data-customer="Karan Mehta" data-joined="23rd Dec 2025"
                                        data-initials="KM" data-color="#0d6efd"
                                        data-status="Inactive" data-status-class="inactive"
                                        data-segment="Returning customer"
                                        data-plan="silver" data-plan-note="Expired 23rd Mar 2026" data-plan-state="expired"
                                        data-email="karan.mehta@gmail.com" data-phone="+91 97330 88120" data-whatsapp="+91 97330 88120"
                                        data-shipping="22 Linking Road, Bandra West, Mumbai, Maharashtra 400050"
                                        data-billing="22 Linking Road, Bandra West, Mumbai, Maharashtra 400050">
                                        <span class="avatar avatar-offline"><span class="avatar-title rounded-circle" style="background:#0d6efd;">KM</span></span>
                                    </button>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="customer-name">Karan Mehta</div>
                                            <span class="segment-icon segment-icon--returning" title="Returning customer"><i class="fa-solid fa-repeat"></i></span>
                                        </div>
                                        <span class="plan-badge plan-badge--silver" title="Silver membership">
                                            <span class="pb-icon"><i class="fa-solid fa-medal"></i></span>
                                            <span class="pb-label">Silver</span>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div title="Avg. order $62.00">
                                    <div class="fw-bold fs-6">$310</div>
                                    <div class="small text-muted"><i class="fa-solid fa-bag-shopping order-icon me-1"></i>5 orders</div>
                                </div>
                            </td>
                            <td>
                                <div>23rd Mar 2026</div>
                                <div class="customer-meta">7 months ago</div>
                            </td>
                            <td>
                                <div class="dropdown-options dropdown text-center">
                                    <button class="do-kebab-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end do-menu">
                                        <li>
                                            <a class="do-item do-item--amber view-action" href="{{ '' }}">
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

                        <tr data-name="Sneha Kapoor">
                            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="5"></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <button type="button" class="avatar-trigger" data-bs-toggle="offcanvas"
                                        data-bs-target="#contactCanvas" title="Blocked &middot; View contact details"
                                        aria-label="View contact details for Sneha Kapoor"
                                        data-customer="Sneha Kapoor" data-joined="7th Jan 2026"
                                        data-initials="SK" data-color="#6f42c1"
                                        data-status="Blocked" data-status-class="blocked"
                                        data-segment="New customer"
                                        data-plan="silver" data-plan-note="Expired 7th Feb 2026" data-plan-state="expired"
                                        data-email="sneha.kapoor@yahoo.com" data-phone="+91 98001 77654" data-whatsapp="+91 98001 77654"
                                        data-shipping="27 Connaught Place, New Delhi, Delhi 110001"
                                        data-billing="27 Connaught Place, New Delhi, Delhi 110001">
                                        <span class="avatar avatar-blocked"><span class="avatar-title rounded-circle" style="background:#6f42c1;">SK</span></span>
                                    </button>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="customer-name">Sneha Kapoor</div>
                                            <span class="segment-icon segment-icon--new" title="New customer"><i class="fa-solid fa-seedling"></i></span>
                                        </div>
                                        <span class="plan-badge plan-badge--silver" title="Silver membership">
                                            <span class="pb-icon"><i class="fa-solid fa-medal"></i></span>
                                            <span class="pb-label">Silver</span>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div title="Avg. order $34.50">
                                    <div class="fw-bold fs-6">$34.50</div>
                                    <div class="small text-muted"><i class="fa-solid fa-bag-shopping order-icon me-1"></i>1 order</div>
                                </div>
                            </td>
                            <td>
                                <div>7th Jan 2026</div>
                                <div class="customer-meta">9 months ago</div>
                            </td>
                            <td>
                                <div class="dropdown-options dropdown text-center">
                                    <button class="do-kebab-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end do-menu">
                                        <li>
                                            <a class="do-item do-item--amber view-action" href="{{ '' }}">
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
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            <div class="d-flex align-items-center gap-3">
                <div class="avatar avatar-xl"><span class="avatar-title rounded-circle" id="cAvatar"></span></div>
                <div>
                    <div class="contact-customer" id="contactTitle"></div>
                    <div class="contact-sub" id="cSegment"></div>
                    <div class="contact-joined" id="cJoined"></div>
                </div>
            </div>
            <div class="mt-3 d-flex align-items-center gap-2">
                <span class="badge rounded-pill" id="cStatus"></span>
                <span id="cPlan"></span>
            </div>
        </div>

        <div class="contact-quick">
            <a href="#" class="q-mail" id="qMail"><i class="fa-solid fa-envelope"></i>Email</a>
            <a href="#" class="q-call" id="qCall"><i class="fa-solid fa-phone"></i>Call</a>
            <a href="#" class="q-wa" id="qWa" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i>WhatsApp</a>
        </div>

        <div class="offcanvas-body p-0 pb-4">
            <div class="contact-section">Email</div>
            <div class="contact-item" data-item="email">
                <span class="ci-icon ci-blue"><i class="fa-solid fa-envelope"></i></span>
                <div class="ci-body">
                    <div class="ci-label">Email address</div>
                    <a class="ci-value" href="#" data-field="email" data-link="mailto:"></a>
                </div>
                <button type="button" class="ci-copy" title="Copy" aria-label="Copy email address"><i class="fa-regular fa-copy"></i></button>
            </div>

            <div class="contact-section">Phone</div>
            <div class="contact-item" data-item="phone">
                <span class="ci-icon ci-green"><i class="fa-solid fa-mobile-screen"></i></span>
                <div class="ci-body">
                    <div class="ci-label">Mobile</div>
                    <a class="ci-value" href="#" data-field="phone" data-link="tel:"></a>
                </div>
                <button type="button" class="ci-copy" title="Copy" aria-label="Copy mobile number"><i class="fa-regular fa-copy"></i></button>
            </div>
            <div class="contact-item" data-item="whatsapp">
                <span class="ci-icon ci-lime"><i class="fa-brands fa-whatsapp"></i></span>
                <div class="ci-body">
                    <div class="ci-label">WhatsApp</div>
                    <span class="ci-value" data-field="whatsapp"></span>
                </div>
                <button type="button" class="ci-copy" title="Copy" aria-label="Copy WhatsApp number"><i class="fa-regular fa-copy"></i></button>
            </div>

            <div class="contact-section">Addresses</div>
            <div class="contact-item" data-item="shipping">
                <span class="ci-icon ci-amber"><i class="fa-solid fa-truck-fast"></i></span>
                <div class="ci-body">
                    <div class="ci-label">Shipping address</div>
                    <span class="ci-value" data-field="shipping"></span>
                </div>
                <button type="button" class="ci-copy" title="Copy" aria-label="Copy shipping address"><i class="fa-regular fa-copy"></i></button>
            </div>
            <div class="contact-item" data-item="billing">
                <span class="ci-icon ci-rose"><i class="fa-solid fa-file-invoice"></i></span>
                <div class="ci-body">
                    <div class="ci-label">Billing address</div>
                    <span class="ci-value" data-field="billing"></span>
                </div>
                <button type="button" class="ci-copy" title="Copy" aria-label="Copy billing address"><i class="fa-regular fa-copy"></i></button>
            </div>

        </div>
    </div>

    {{-- Bulk Edit Bar --}}
    <div class="bg-dark text-white rounded-3 bulk-bar d-flex justify-content-between align-items-center d-none"
        id="bulkBar">
        <span class="fw-semibold bulk-count" id="bulkCount"></span>
        <div class="btn-group ms-auto" role="group" aria-label="Bulk actions">
            <button class="btn btn-sm btn-dark bulk-activate">
                <i class="fa-solid fa-circle-check"></i> Activate
            </button>
            <button class="btn btn-sm btn-dark bulk-block">
                <i class="fa-solid fa-ban"></i> Block
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
            const $table = $('#customerTable');
            const $tbody = $table.find('tbody');
            const $bulkBar = $('#bulkBar');

            const selectedIds = () =>
                $tbody.find('.row-checkbox:checked').map((_, el) => $(el).data('id')).get();

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
            const statusBadge = {
                active: 'bg-success-gradient',
                unverified: 'bg-warning-gradient text-dark',
                inactive: 'bg-secondary-gradient',
                blocked: 'bg-danger-gradient'
            };

            // Subscription plans: label + icon (used for the header badge)
            const planMap = {
                silver: { label: 'Silver', icon: 'fa-medal' },
                gold: { label: 'Gold', icon: 'fa-crown' },
                platinum: { label: 'Platinum', icon: 'fa-gem' }
            };

            $('#contactCanvas').on('show.bs.offcanvas', function(e) {
                if (!e.relatedTarget) return;

                const d = $(e.relatedTarget).data();
                const phone = String(d.phone || '').replace(/\s/g, '');
                const waDigits = String(d.whatsapp || '').replace(/\D/g, '');

                $('#cAvatar').text(d.initials).css('background', d.color);
                $('#contactTitle').text(d.customer);
                $('#cSegment').text(d.segment);
                $('#cStatus')
                    .attr('class', 'badge rounded-pill ' + (statusBadge[d.statusClass] || 'bg-secondary'))
                    .text(d.status);

                $('#cJoined').text(d.joined ? 'Joined - ' + d.joined : '');

                // Plan badge in the header (hidden when the customer has no plan)
                const plan = planMap[d.plan];
                $('#cPlan').html(plan ?
                    '<span class="plan-badge plan-badge--' + d.plan + '">' +
                    '<span class="pb-icon"><i class="fa-solid ' + plan.icon + '"></i></span>' +
                    '<span class="pb-label">' + plan.label + '</span></span>' : '');

                const values = {
                    email: d.email,
                    phone: d.phone,
                    whatsapp: d.whatsapp,
                    shipping: d.shipping,
                    billing: d.billing
                };

                $.each(values, function(field, value) {
                    const $item = $('[data-item="' + field + '"]');
                    const $val = $item.find('[data-field]');

                    $item.toggle(!!value);
                    $val.text(value || '');
                    if (value && $val.is('a')) {
                        $val.attr('href', $val.data('link') + String(value).replace(/\s/g, ''));
                    }
                });

                // Quick actions: only show what we can actually do for this customer
                $('#qMail').toggle(!!d.email).attr('href', 'mailto:' + (d.email || ''));
                $('#qCall').toggle(!!phone).attr('href', 'tel:' + phone);
                $('#qWa').toggle(!!waDigits).attr('href', 'https://wa.me/' + waDigits);
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

            /* ---------- Bulk actions (wire these to your routes) ---------- */
            $bulkBar.on('click', '.bulk-activate', function() {
                console.log('Activate customers', selectedIds());
            });

            $bulkBar.on('click', '.bulk-block', function() {
                console.log('Block customers', selectedIds());
            });

            $bulkBar.on('click', '.bulk-delete', function() {
                console.log('Delete customers', selectedIds());
            });

            /* ---------- Export ---------- */
            $('#exportBtn').on('click', function() {
                console.log('Export all customers');
            });

            $('#exportSelectedBtn').on('click', function() {
                console.log('Export selected customers', selectedIds());
            });
        });
    </script>
@endpush