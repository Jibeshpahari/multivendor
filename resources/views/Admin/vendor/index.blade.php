@extends('admin.layout.app')

@section('content')
    <div class="card p-3 filter-box">
        <form action="" method="GET" class="" autocomplete="off">
            <div class="row">
                <div class="col-2">
                    <select class="form-select" name="status" id="status">
                        <option value="" disabled="" selected="" hidden="">Status</option>
                        <option value="approved">Approved</option>
                        <option value="pending_approval">Pending Approval</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="col-2">
                    <select class="form-select" name="date_sort" id="sort">
                        <option value="" disabled="" selected="" hidden="">Sort By</option>
                        <option value="date_asc">Date (Oldest First)</option>
                        <option value="date_desc">Date (Newest First)</option>
                        <option value="name_asc">Name (A-Z)</option>
                        <option value="name_desc">Name (Z-A)</option>
                    </select>
                </div>
                <div class="col-4">
                    <div class="dropdown">
                        <button class="date-filter-trigger dropdown-toggle" type="button" id="dateFilterDropdown"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class="fa-solid fa-calendar-days"></i>
                            <span id="dateFilterLabel">Filter by date</span>
                        </button>

                        <div class="dropdown-menu date-filter-panel p-3" aria-labelledby="dateFilterDropdown">
                            <div class="mb-2">
                                <label for="start_date" class="form-label">From</label>
                                <input type="date" class="form-control datepicker" value="" name="start_date"
                                    id="start_date" readonly aria-expanded="false">
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">To</label>
                                <input type="date" class="form-control datepicker" value="" name="end_date"
                                    id="end_date" readonly aria-expanded="false">
                            </div>
                            <div class="date-filter-actions">
                                <button type="button" class="btn-apply-date" id="btnApplyDate">Apply</button>
                                <button type="button" class="btn-clear-date" id="btnClearDate">Clear</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-2">
                    <button type="submit" class="btn btn-secondary bg-secondary-gradient btn-sm">
                        <i class="fa-solid fa-filter me-1"></i>
                        Filter
                    </button>
                </div>
                <div class="col-2">
                    <div class="text-end">
                        <a href="http://127.0.0.1:8000/admin/product/categories/add"
                            class="btn btn-primary bg-primary-gradient btn-sm">
                            <i class="fa-solid fa-plus me-1"></i>
                            Add Category
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


@push('css')
    <style>
        .filter-box .form-control,
        .filter-box .form-select {
            padding-block: 0.465rem !important
        }

        .date-filter-trigger {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: .465rem 1.4rem;
            border: 1px solid #ced4da;
            border-radius: .375rem;
            background: #fff;
            color: #212529;
            font-size: 1rem;
            font-weight: 400;
        }

        .date-filter-trigger i {
            font-size: 13px;
            color: #6c757d;
        }

        .date-filter-trigger:hover,
        .date-filter-trigger:focus {
            border-color: #86b7fe;
            color: #212529;
        }

        .date-filter-trigger.show {
            border-color: #86b7fe;
            background: #fff;
            color: #212529;
        }

        .date-filter-trigger.show i {
            color: #6c757d;
        }

        .date-filter-trigger::after {
            color: #6c757d;
        }

        /* ---- dropdown panel ---- */
        .date-filter-panel {
            min-width: 250px;
            padding: 16px !important;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        .date-filter-panel .form-label {
            font-size: 11.5px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 4px;
        }

        .date-filter-panel input[type="date"] {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 13px;
            background: #fff;
        }

        .date-filter-panel input[type="date"]:focus {
            outline: none;
            border-color: #495057;
            box-shadow: 0 0 0 3px rgba(73, 80, 87, 0.08);
        }

        /* ---- actions row ---- */
        .date-filter-actions {
            display: flex;
            gap: 8px;
            margin-top: 4px;
        }

        .date-filter-actions button {
            flex: 1;
            border-radius: 8px;
            padding: 8px 0;
            font-size: 12.5px;
            font-weight: 600;
            border: 1px solid #dee2e6;
        }

        .btn-apply-date {
            background: #495057;
            border-color: #495057 !important;
            color: #fff;
        }

        .btn-apply-date:hover {
            background: #343a40;
        }

        .btn-clear-date {
            background: #fff;
            color: #6c757d;
        }

        .btn-clear-date:hover {
            border-color: #dc3545;
            color: #dc3545;
        }
    </style>
@endpush
