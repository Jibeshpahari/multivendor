@extends('admin.layout.app')

@section('content')
    @php
        $baseUrl = url()->current();
    @endphp

    <div class="card p-4">
        <form method="GET" action="{{ $baseUrl }}" id="filterForm">
            <div class="filter-bar-wrapper">
                <div class="filter-bar">
                    <div class="dropdown">
                        <button class="filter-btn dropdown-toggle {{ !empty($filters['topic']) ? 'is-active' : '' }}"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-hashtag"></i> Topic
                            <span>{{ !empty($filters['topic']) ? optional($topics->firstWhere('id', $filters['topic']))->name : 'All' }}</span>
                        </button>
                        <ul class="dropdown-menu topic-picker-menu filter-menu">
                            <li>
                                <a class="dropdown-item {{ empty($filters['topic']) ? 'active' : '' }}"
                                    href="{{ request()->fullUrlWithQuery(['topic' => null, 'page' => null]) }}">
                                    <span class="topic-dot dot-all"></span> All notes
                                    <span class="topic-count" style="margin-left:auto;">{{ $counts['all'] ?? 0 }}</span>
                                </a>
                            </li>
                            @foreach ($topics as $t)
                                <li>
                                    <a class="dropdown-item {{ (string) ($filters['topic'] ?? '') === (string) $t->id ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['topic' => $t->id, 'page' => null]) }}">
                                        <span class="topic-dot dot-topic-{{ $t->id % 7 }}"></span>
                                        <span>{{ $t->name }}</span>
                                        <span class="topic-count"
                                            style="margin-left:auto;">{{ $counts['topics'][$t->id] ?? 0 }}</span>
                                    </a>
                                </li>
                            @endforeach
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#" id="filterAddTopic"><i class="fa-solid fa-plus"
                                        style="width:9px;"></i> New topic</a></li>
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="filter-btn dropdown-toggle {{ !empty($filters['status']) ? 'is-active' : '' }}"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-circle-dot"></i> Status
                            <span>{{ $filters['status'] ?? null ? \Illuminate\Support\Str::title($filters['status']) : 'All' }}</span>
                        </button>
                        <ul class="dropdown-menu topic-picker-menu filter-menu">
                            <li>
                                <a class="dropdown-item {{ empty($filters['status']) ? 'active' : '' }}"
                                    href="{{ request()->fullUrlWithQuery(['status' => null, 'page' => null]) }}">
                                    <span class="status-dot dot-all"></span> All
                                    <span class="topic-count" style="margin-left:auto;">{{ $counts['all'] ?? 0 }}</span>
                                </a>
                            </li>
                            @foreach ([['key' => 'todo', 'label' => 'To do'], ['key' => 'progress', 'label' => 'In progress'], ['key' => 'done', 'label' => 'Done']] as $s)
                                <li>
                                    <a class="dropdown-item {{ ($filters['status'] ?? '') === $s['key'] ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['status' => $s['key'], 'page' => null]) }}">
                                        <span class="status-dot dot-status-{{ $s['key'] }}"></span>
                                        <span>{{ $s['label'] }}</span>
                                        <span class="topic-count"
                                            style="margin-left:auto;">{{ $counts['statuses'][$s['key']] ?? 0 }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="filter-btn dropdown-toggle {{ !empty($filters['priority']) ? 'is-active' : '' }}"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-flag"></i> Priority
                            <span>{{ $filters['priority'] ?? null ? \Illuminate\Support\Str::title($filters['priority']) : 'All' }}</span>
                        </button>
                        <ul class="dropdown-menu topic-picker-menu filter-menu">
                            <li>
                                <a class="dropdown-item {{ empty($filters['priority']) ? 'active' : '' }}"
                                    href="{{ request()->fullUrlWithQuery(['priority' => null, 'page' => null]) }}">
                                    <i class="fa-solid fa-flag dot-priority-all" style="width:9px; font-size:10px;"></i> All
                                    <span class="topic-count" style="margin-left:auto;">{{ $counts['all'] ?? 0 }}</span>
                                </a>
                            </li>
                            @foreach ([['key' => 'low', 'label' => 'Low'], ['key' => 'medium', 'label' => 'Medium'], ['key' => 'high', 'label' => 'High'], ['key' => 'urgent', 'label' => 'Urgent']] as $p)
                                <li>
                                    <a class="dropdown-item {{ ($filters['priority'] ?? '') === $p['key'] ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['priority' => $p['key'], 'page' => null]) }}">
                                        <i class="fa-solid fa-flag dot-priority-{{ $p['key'] }}"
                                            style="width:9px; font-size:10px;"></i>
                                        <span>{{ $p['label'] }}</span>
                                        <span class="topic-count"
                                            style="margin-left:auto;">{{ $counts['priorities'][$p['key']] ?? 0 }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button
                            class="filter-btn dropdown-toggle {{ !empty($filters['from']) || !empty($filters['to']) ? 'is-active' : '' }}"
                            type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="fa-solid fa-calendar"></i> Date
                            <span>
                                @if (!empty($filters['from']) && !empty($filters['to']))
                                    {{ $filters['from'] }} → {{ $filters['to'] }}
                                @elseif(!empty($filters['from']))
                                    From {{ $filters['from'] }}
                                @elseif(!empty($filters['to']))
                                    Until {{ $filters['to'] }}
                                @else
                                    Any time
                                @endif
                            </span>
                        </button>
                        <div class="dropdown-menu date-filter-box">
                            <div class="field-row">
                                <label>From</label>
                                <input type="date" name="from" value="{{ $filters['from'] ?? '' }}">
                            </div>
                            <div class="field-row" style="margin-bottom:12px;">
                                <label>To</label>
                                <input type="date" name="to" value="{{ $filters['to'] ?? '' }}">
                            </div>
                            <div class="df-actions">
                                <button class="btn-apply" type="submit">Apply</button>
                                <button type="button" id="btnClearDate">Clear</button>
                            </div>
                        </div>
                    </div>

                    @foreach (['topic', 'status', 'priority', 'q'] as $key)
                        @if (!empty($filters[$key]))
                            <input type="hidden" name="{{ $key }}" value="{{ $filters[$key] }}">
                        @endif
                    @endforeach

                    @php
                        $anyActive =
                            !empty($filters['topic']) ||
                            !empty($filters['status']) ||
                            !empty($filters['priority']) ||
                            !empty($filters['from']) ||
                            !empty($filters['to']) ||
                            !empty($filters['q']);
                    @endphp
                    <a class="filter-clear-all" href="{{ $baseUrl }}"
                        style="{{ $anyActive ? 'display:inline-flex;' : '' }}">
                        <i class="fa-solid fa-rotate-left"></i> Clear filters
                    </a>
                </div>

                <div class="card-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="q" id="searchInput" placeholder="Search notes..."
                        value="{{ $filters['q'] ?? '' }}">
                </div>
            </div>
        </form>
    </div>

    <div class="card p-4" style="min-height: 100px">
        <div class="list-meta-row">
            <div class="list-count" id="listCount">{{ $notes->total() }} note{{ $notes->total() === 1 ? '' : 's' }}
            </div>
            <div class="header-actions">
                <button class="btn-new-note-main" id="btnNewNoteMain"><i class="fa-solid fa-plus"></i> New note</button>
            </div>
        </div>

        <div id="notesListArea">
            @forelse ($notes as $n)
                @include('admin.tasknote.partials.note-card', ['note' => $n, 'topics' => $topics])
            @empty
                <div class="empty-state">
                    <i class="fa-regular fa-note-sticky"></i>
                    <h6>Nothing here yet</h6>
                    <p>Try a different topic, search term or date range — or create your first note.</p>
                </div>
            @endforelse
        </div>

        <div class="card-footer py-3">
            @include('admin.layout.components.pagination', ['items' => $notes])
        </div>
    </div>

    <div class="modal fade" id="editorModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="editor-card" id="editorCard">
                    <div class="editor-card-header">
                        <div class="editor-card-title" id="editorCardTitle">New note</div>
                        <button class="editor-close-btn" id="btnCloseEditor" title="Close"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                    <div class="editor-top-row">
                        <input type="text" class="title-input" id="noteTitle" placeholder="Note title">

                        <div class="topic-picker dropdown">
                            <button class="topic-picker-btn dropdown-toggle" type="button" id="topicPickerBtn"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="topic-dot dot-topic-0" id="topicPickerDot"></span>
                                <span id="topicPickerLabel">General</span>
                            </button>
                            <ul class="dropdown-menu topic-picker-menu" id="topicPickerMenu">
                                @foreach ($topics as $t)
                                    <li><a class="dropdown-item" href="#" data-id="{{ $t->id }}">
                                            <span class="topic-dot dot-topic-{{ $t->id % 7 }}"></span><span
                                                class="js-label">{{ $t->name }}</span>
                                        </a></li>
                                @endforeach
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#" id="pickerAddTopic"><i
                                            class="fa-solid fa-plus" style="width:9px;"></i> New topic</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="editor-second-row">
                        <div class="topic-picker dropdown">
                            <button class="topic-picker-btn dropdown-toggle" type="button" id="statusPickerBtn"
                                data-bs-toggle="dropdown">
                                <span class="status-dot dot-status-todo" id="statusPickerDot"></span>
                                <span id="statusPickerLabel">To do</span>
                            </button>
                            <ul class="dropdown-menu topic-picker-menu" id="statusPickerMenu">
                                @foreach ([['key' => 'todo', 'label' => 'To do'], ['key' => 'progress', 'label' => 'In progress'], ['key' => 'done', 'label' => 'Done']] as $s)
                                    <li><a class="dropdown-item" href="#" data-key="{{ $s['key'] }}">
                                            <span class="status-dot dot-status-{{ $s['key'] }}"></span><span
                                                class="js-label">{{ $s['label'] }}</span>
                                        </a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="topic-picker dropdown">
                            <button class="topic-picker-btn dropdown-toggle" type="button" id="priorityPickerBtn"
                                data-bs-toggle="dropdown">
                                <i class="fa-solid fa-flag dot-priority-medium" id="priorityPickerIcon"></i>
                                <span id="priorityPickerLabel">Medium</span>
                            </button>
                            <ul class="dropdown-menu topic-picker-menu" id="priorityPickerMenu">
                                @foreach ([['key' => 'low', 'label' => 'Low'], ['key' => 'medium', 'label' => 'Medium'], ['key' => 'high', 'label' => 'High'], ['key' => 'urgent', 'label' => 'Urgent']] as $p)
                                    <li><a class="dropdown-item" href="#" data-key="{{ $p['key'] }}">
                                            <i class="fa-solid fa-flag dot-priority-{{ $p['key'] }}"
                                                style="width:11px;"></i><span class="js-label">{{ $p['label'] }}</span>
                                        </a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="reminder-control">
                            <button class="topic-picker-btn" type="button" id="reminderBtn">
                                <i class="fa-solid fa-bell"></i>
                                <span id="reminderLabel">Add reminder</span>
                            </button>
                            <input type="datetime-local" id="reminderInput" style="display:none;">
                            <button id="reminderClearBtn" title="Remove reminder" style="display:none;"><i
                                    class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>

                    <div id="editor-container"></div>

                    <div class="editor-bottom-row">
                        <div class="editor-actions">
                            <button class="btn-cancel-edit" id="btnCancelEdit">Cancel</button>
                            <button class="btn-save-note" id="btnSaveNote">Save note</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="topicModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New topic</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Topic name</label>
                    <input type="text" class="form-control" id="newTopicName" placeholder="e.g. Client work">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-soft" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-dark-primary" id="btnConfirmAddTopic">Create topic</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.css">

    <style>
        :root {
            --ink: #16161a;
            --ink-soft: #5a5a63;
            --ink-faint: #8b8b93;
            --paper: #ffffff;
            --panel: #f7f7f8;
            --panel-deep: #eef0f5;
            --line: #e4e4e8;
            --line-strong: #d3d3d9;

            --a-indigo: #5b5fef;
            --a-teal: #12a594;
            --a-amber: #dc9b30;
            --a-coral: #e6604c;
            --a-violet: #8b5cf6;
            --a-slate: #71717a;
            --a-pink: #e8779a;

            --radius-sm: 6px;
            --radius-md: 10px;
        }

        button {
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-new-note-main {
            background: var(--ink);
            color: var(--paper);
            border: none;
            border-radius: var(--radius-sm);
            padding: 10px 18px;
            font-weight: 600;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            transition: background .15s ease, transform .1s ease;
        }

        .btn-new-note-main:hover {
            background: #000;
        }

        .btn-new-note-main:active {
            transform: scale(.98);
        }

        .btn-icon-outline {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--line-strong);
            background: var(--paper);
            color: var(--ink-soft);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-icon-outline:hover {
            border-color: var(--ink);
            color: var(--ink);
        }

        .card-search {
            position: relative;
            margin-bottom: 0;
            max-width: 100%;
            width: 350px;
            flex-shrink: 0;
        }

        .card-search input {
            width: 100%;
            border: 1px solid var(--line-strong);
            background: var(--panel);
            border-radius: var(--radius-sm);
            padding: 9px 12px 9px 34px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            color: var(--ink);
        }

        .card-search input:focus {
            outline: none;
            border-color: var(--ink);
            background: var(--paper);
            box-shadow: 0 0 0 3px rgba(22, 22, 26, 0.06);
        }

        .card-search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ink-faint);
            font-size: 12px;
        }

        /* Base topic-dot shape/color — shared by filter bar dropdown,
                   editor topic picker, AND the note-card partial. Kept here
                   (not in note-card.blade.php) because the filter bar renders
                   even when there are zero notes. */
        .topic-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            flex-shrink: 0;
            display: inline-block;
            background: #9a12eda1;
        }

        .topic-count {
            font-size: 11.5px;
            color: var(--ink-faint);
            font-weight: 500;
        }

        .filter-bar-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 0px;
        }

        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 0;
        }

        .filter-btn {
            display: flex;
            align-items: center;
            gap: 7px;
            border: 1px solid var(--line-strong);
            border-radius: 5px;
            padding: 8px 14px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink-soft);
            background: var(--paper);
            white-space: nowrap;
        }

        .filter-btn:hover {
            border-color: var(--ink);
            color: var(--ink);
        }

        .filter-btn.is-active {
            border-color: var(--ink);
            background: var(--ink);
            color: var(--paper);
        }

        .filter-btn i {
            font-size: 11px;
        }

        .filter-btn span {
            font-weight: 600;
        }

        .filter-menu {
            max-height: 280px;
            overflow-y: auto;
        }

        .filter-clear-all {
            border: 1px dashed var(--line-strong);
            background: transparent;
            color: var(--ink-faint);
            font-size: 12px;
            font-weight: 600;
            border-radius: 20px;
            padding: 7px 13px;
            display: none;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .filter-clear-all:hover {
            border-color: var(--a-coral);
            color: var(--a-coral);
        }

        /* editor card (lives inside #editorModal's modal-content) */
        .editor-card {
            background: var(--paper);
            padding: 22px 24px 24px;
        }

        .editor-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .editor-card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--ink-faint);
        }

        .editor-close-btn {
            width: 28px;
            height: 28px;
            border: none;
            background: transparent;
            color: var(--ink-faint);
            border-radius: 7px;
            font-size: 13px;
        }

        .editor-close-btn:hover {
            background: var(--panel-deep);
            color: var(--ink);
        }

        .editor-top-row {
            display: flex;
            gap: 12px;
            margin-bottom: 14px;
            flex-wrap: wrap;
        }

        .title-input {
            flex: 1;
            min-width: 200px;
            border: none;
            border-bottom: 2px solid var(--line-strong);
            font-size: 19px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            color: var(--ink);
            padding: 6px 2px 10px;
            background: transparent;
        }

        .title-input::placeholder {
            color: var(--ink-faint);
            font-weight: 500;
        }

        .title-input:focus {
            outline: none;
            border-bottom-color: var(--ink);
        }

        .topic-picker {
            position: relative;
        }

        .topic-picker-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--line-strong);
            border-radius: var(--radius-sm);
            padding: 9px 13px;
            font-size: 13px;
            font-weight: 500;
            color: var(--ink);
            background: var(--paper);
            white-space: nowrap;
        }

        .topic-picker-btn:hover {
            border-color: var(--ink);
        }

        .topic-picker-menu {
            min-width: 190px;
            padding: 6px;
            border-radius: var(--radius-md);
            border: 1px solid var(--line);
            box-shadow: 0 10px 30px rgba(16, 16, 20, 0.12);
        }

        .topic-picker-menu .dropdown-item {
            display: flex;
            align-items: center;
            gap: 9px;
            border-radius: 6px;
            padding: 8px 10px;
            font-size: 13px;
            font-weight: 500;
        }

        .topic-picker-menu .dropdown-item:active,
        .topic-picker-menu .dropdown-item.active {
            background: var(--panel-deep);
            color: var(--ink);
        }

        .status-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .editor-second-row {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }

        .reminder-control {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .reminder-control input[type="datetime-local"] {
            border: 1px solid var(--line-strong);
            border-radius: var(--radius-sm);
            padding: 8px 10px;
            font-size: 12.5px;
            font-family: 'Poppins', sans-serif;
            color: var(--ink);
            background: var(--paper);
        }

        .reminder-control input[type="datetime-local"]:focus {
            outline: none;
            border-color: var(--ink);
        }

        #reminderClearBtn {
            border: none;
            background: transparent;
            color: var(--ink-faint);
            width: 26px;
            height: 26px;
            border-radius: 6px;
            font-size: 11px;
            flex-shrink: 0;
        }

        #reminderClearBtn:hover {
            background: var(--panel-deep);
            color: var(--a-coral);
        }

        #editor-container {
            border: 1px solid var(--line);
            border-radius: 10px;
            overflow: hidden;
            background: var(--paper);
        }

        .ql-toolbar.ql-snow {
            border: none;
            border-bottom: 1px solid var(--line);
            background: var(--panel);
            border-radius: 10px 10px 0 0;
        }

        .ql-container.ql-snow {
            border: none;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            min-height: 130px;
        }

        .ql-editor.ql-blank::before {
            color: var(--ink-faint);
            font-style: normal;
            font-family: 'Poppins', sans-serif;
        }

        .ql-editor:focus {
            outline: none;
        }

        #editor-container:focus-within {
            border-color: var(--ink);
            box-shadow: 0 0 0 3px rgba(22, 22, 26, 0.06);
        }

        .editor-bottom-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 16px;
        }

        .editor-actions {
            display: flex;
            gap: 10px;
            margin-left: auto;
        }

        .btn-cancel-edit {
            border: 1px solid var(--line-strong);
            background: var(--paper);
            color: var(--ink-soft);
            font-weight: 600;
            font-size: 13px;
            padding: 9px 16px;
            border-radius: var(--radius-sm);
        }

        .btn-save-note {
            border: none;
            background: var(--ink);
            color: var(--paper);
            font-weight: 600;
            font-size: 13px;
            padding: 9px 20px;
            border-radius: var(--radius-sm);
        }

        .btn-save-note:hover {
            background: #000;
        }

        .btn-save-note:disabled,
        .btn-new-note-main:disabled {
            opacity: .6;
            cursor: default;
        }

        .list-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .list-count {
            font-size: 12.5px;
            color: var(--ink-faint);
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 70px 20px;
            color: var(--ink-faint);
        }

        .empty-state i {
            font-size: 30px;
            margin-bottom: 14px;
            color: var(--line-strong);
        }

        .empty-state h6 {
            font-weight: 600;
            color: var(--ink-soft);
            margin-bottom: 4px;
            font-size: 15px;
        }

        .empty-state p {
            font-size: 13px;
            margin: 0;
        }

        .dot-all {
            background: var(--ink);
        }

        .dot-status-todo {
            background: #9a9aa2;
        }

        .dot-status-progress {
            background: var(--a-indigo);
        }

        .dot-status-done {
            background: var(--a-teal);
        }

        .dot-priority-all {
            color: var(--ink);
        }

        .dot-priority-low {
            color: #9a9aa2;
        }

        .dot-priority-medium {
            color: var(--a-amber);
        }

        .dot-priority-high {
            color: var(--a-coral);
        }

        .dot-priority-urgent {
            color: #b91c1c;
        }

        .date-filter-box {
            padding: 14px;
            min-width: 230px;
        }

        .date-filter-box .field-row {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 10px;
        }

        .date-filter-box label {
            font-size: 10.5px;
            font-weight: 600;
            color: var(--ink-faint);
        }

        .date-filter-box input[type="date"] {
            border: 1px solid var(--line-strong);
            border-radius: var(--radius-sm);
            padding: 6px 8px;
            font-size: 12.5px;
            font-family: 'Poppins', sans-serif;
            color: var(--ink);
            width: 100%;
        }

        .date-filter-box input[type="date"]:focus {
            outline: none;
            border-color: var(--ink);
        }

        .df-actions {
            display: flex;
            gap: 8px;
            margin-top: 4px;
        }

        .df-actions button {
            flex: 1;
            font-size: 12px;
            font-weight: 600;
            border-radius: var(--radius-sm);
            padding: 7px 0;
            border: 1px solid var(--line-strong);
            background: var(--paper);
            color: var(--ink-soft);
        }

        .df-actions .btn-apply {
            background: var(--ink);
            color: var(--paper);
            border-color: var(--ink);
        }

        .df-actions button:hover {
            filter: brightness(0.97);
        }

        .modal-content {
            border-radius: 14px;
            border: none;
            font-family: 'Poppins', sans-serif;
        }

        .modal-header {
            border-bottom: 1px solid var(--line);
        }

        .modal-footer {
            border-top: 1px solid var(--line);
        }

        .modal-title {
            font-weight: 600;
            font-size: 16px;
        }

        .form-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink-soft);
        }

        .form-control:focus {
            border-color: var(--ink);
            box-shadow: 0 0 0 3px rgba(22, 22, 26, 0.08);
        }

        .btn-dark-primary {
            background: var(--ink);
            border-color: var(--ink);
            color: var(--paper);
            font-weight: 600;
            font-size: 13px;
        }

        .btn-dark-primary:hover {
            background: #000;
            border-color: #000;
        }

        .btn-outline-soft {
            border: 1px solid var(--line-strong);
            color: var(--ink-soft);
            font-weight: 600;
            font-size: 13px;
            background: var(--paper);
        }

        .kebab-menu .dropdown-item {
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 12px;
        }

        @media (max-width: 980px) {
            .editor-top-row {
                flex-direction: column;
            }
        }
    </style>

    <style>
        .note-card {
            position: relative;
            min-height: 120px;
            border: 1px solid #c7c7ce;
            border-radius: 6px;
            padding: 16px 18px;
            margin-bottom: 10px;
            background: #fafafa;
            transition: border-color .12s ease, box-shadow .12s ease;
            cursor: pointer;
            box-shadow: 0px 0px 3px #00000010;
        }

        .note-card:hover {
            border-color: var(--line-strong);
            box-shadow: 0 4px 14px rgba(16, 16, 20, 0.06);
        }

        .note-card-done {
            border-color: #1b7f4d;
            background: #ecfdf5;
        }

        .note-card-done:hover {
            border-color: #1b7f4d;
            box-shadow: 0 4px 14px rgba(27, 127, 77, 0.1);
        }

        .note-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 8px;
        }

        .note-card-left {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 0;
        }

        .note-card-time {
            font-size: 13px;
            color: #333333;
            font-weight: 500;
            line-height: 2.5;
        }

        .note-card-title {
            font-size: 15.5px;
            font-weight: 600;
            color: var(--ink);
            max-width: 420px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .note-card-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
            flex-shrink: 0;
        }

        .meta-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12.5px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
            border: 1px solid #aaa;
            white-space: nowrap;
        }

        .meta-pill i {
            font-size: 10px;
        }

        .pill-reminder {
            background: #eef0ff;
            color: #5b5fef;
            border: 1px solid #5b5fef;
        }

        .pill-reminder.overdue {
            background: #fdeceb !important;
            color: #b91c1c !important;
            border: 1px solid #b91c1c;
        }

        .pill-status-todo,
        .pill-status-progress,
        .pill-status-done {
            background: var(--panel-deep);
            color: var(--ink-soft);
        }

        .pill-priority-low {
            background: rgba(154, 154, 162, 0.1);
            color: #9a9aa2;
            border: 1px solid #9a9aa2;
        }

        .pill-priority-medium {
            background: rgba(220, 155, 48, 0.1);
            color: var(--a-amber);
            border: 1px solid var(--a-amber);
        }

        .pill-priority-high {
            background: rgba(230, 96, 76, 0.1);
            color: var(--a-coral);
            border: 1px solid var(--a-coral);
        }

        .pill-priority-urgent {
            background: rgba(185, 28, 28, 0.1);
            color: #b91c1c;
            border: 1px solid #b91c1c;
        }

        .note-topic-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            font-weight: 600;
            padding: 3px 9px 3px 7px;
            border-radius: 20px;
            background: #9a12ed1a;
            color: #9a12ed;
            border: 1px solid #9a12ed;
        }

        .note-card-actions {
            position: absolute;
            bottom: 16px;
            right: 18px;

        }

        .note-card-actions .done-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            border: 1px solid var(--a-teal);
            border-radius: 5px;
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 600;
            color: var(--a-teal);
            background: rgba(18, 165, 148, 0.1);
        }

        .note-card-actions .revert-btn {
            color: #eb970b;
            background: rgb(255 248 214);
            border-color: #e6940c;
        }

        .note-card-actions .done-btn:hover,
        .note-card-actions .revert-btn:hover {
            background: var(--paper);
        }

        .note-card-preview {
            width: 80%;
            font-size: 13px;
            color: #414141;
            line-height: 1.7;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .note-card-preview p {
            margin: 0;
            line-height: inherit;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>

    <script>
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let topics = @json($topics->map(fn($t) => ['id' => $t->id, 'name' => $t->name, 'colorClass' => 'dot-topic-' . $t->id % 7]));

            function topicById(id) {
                return topics.find(t => t.id == id);
            }

            function toInputDateTime(ts) {
                const d = new Date(ts);
                const pad = n => String(n).padStart(2, '0');
                return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
            }

            function formatReminder(ts) {
                return new Date(ts).toLocaleString(undefined, {
                    month: 'short',
                    day: 'numeric',
                    hour: 'numeric',
                    minute: '2-digit'
                });
            }

            function bumpListCount(delta) {
                const $count = $('#listCount');
                const n = Math.max(0, (parseInt($count.text(), 10) || 0) + delta);
                $count.text(`${n} note${n === 1 ? '' : 's'}`);
            }

            let searchTimer = null;
            $('#searchInput').on('input', function() {
                clearTimeout(searchTimer);
                const $form = $(this).closest('form');
                searchTimer = setTimeout(function() {
                    $form.trigger('submit');
                }, 500);
            });

            $('#btnClearDate').on('click', function() {
                $('#filterForm input[name="from"]').val('');
                $('#filterForm input[name="to"]').val('');
                $('#filterForm').trigger('submit');
            });

            function openAddTopicModal() {
                $('#newTopicName').val('');
                new bootstrap.Modal('#topicModal').show();
                setTimeout(() => $('#newTopicName').focus(), 250);
            }
            $(document).on('click', '#filterAddTopic, #pickerAddTopic', function(e) {
                e.preventDefault();
                openAddTopicModal();
            });

            $('#btnConfirmAddTopic').on('click', function() {
                const name = $('#newTopicName').val().trim();
                if (!name) {
                    $('#newTopicName').focus();
                    return;
                }
                const $btn = $(this).prop('disabled', true);

                $.ajax({
                    url: "{{ route('admin.notes.add.topic') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        name
                    },
                    success: function(data) {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('topicModal'))
                                .hide();
                            notify('success', data.message || `Topic "${name}" created`,
                                'toast');
                            // window.location.reload();
                            // TODO - ADD THE TOPIC WITHOUT LOADING THE PAGE.
                        } else {
                            notify('error', data.message, 'toast');
                        }
                    },
                    error: function(error) {
                        notify('error', error.responseJSON?.message || 'Could not create topic',
                            'toast');
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                    }
                });
            });

            $(document).on('click', '.done-btn', function(e) {
                e.stopPropagation();
                const $card = $(this).closest('.note-card');
                const id = $card.data('id');
                const currentStatus = $card.data('status') || 'todo';
                const targetStatus = currentStatus === 'done' ? 'todo' : 'done';

                $.ajax({
                    url: "{{ route('admin.notes.mark-done') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        id,
                        status: targetStatus
                    },
                    success: function(data) {
                        if (data.success) {
                            notify('success', data.message || (targetStatus === 'done' ?
                                'Marked as done' : 'Moved back to To do'), 'toast');
                            if (data.html) $card.replaceWith($(data.html));
                        } else {
                            notify('error', data.message, 'toast');
                        }
                    },
                    error: function(error) {
                        notify('error', error.responseJSON?.message || 'Could not update note',
                            'toast');
                    }
                });
            });

            const quill = new Quill('#editor-container', {
                theme: 'snow',
                placeholder: 'Write what you need to remember...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }],
                        [{
                            color: []
                        }],
                        ['blockquote', 'link'],
                        ['clean']
                    ]
                }
            });

            let editingNoteId = null;
            let pickedTopicId = null;
            let pickedStatus = 'todo';
            let pickedPriority = 'medium';
            let reminderAt = null;

            function statusLabel(key) {
                return ({
                    todo: 'To do',
                    progress: 'In progress',
                    done: 'Done'
                })[key] || 'To do';
            }

            function priorityLabel(key) {
                return ({
                    low: 'Low',
                    medium: 'Medium',
                    high: 'High',
                    urgent: 'Urgent'
                })[key] || 'Medium';
            }

            function setPickedTopic(id) {
                const t = topicById(id) || topics[0];
                if (!t) return;
                pickedTopicId = t.id;
                $('#topicPickerDot').attr('class', 'topic-dot ' + t.colorClass);
                $('#topicPickerLabel').text(t.name);
                $('#topicPickerMenu .dropdown-item').removeClass('active');
                $(`#topicPickerMenu .dropdown-item[data-id="${t.id}"]`).addClass('active');
            }
            $(document).on('click', '#topicPickerMenu .dropdown-item[data-id]', function(e) {
                e.preventDefault();
                setPickedTopic($(this).data('id'));
            });

            function setPickedStatus(key) {
                pickedStatus = key;
                $('#statusPickerDot').attr('class', 'status-dot dot-status-' + key);
                $('#statusPickerLabel').text(statusLabel(key));
                $('#statusPickerMenu .dropdown-item').removeClass('active');
                $(`#statusPickerMenu .dropdown-item[data-key="${key}"]`).addClass('active');
            }
            $(document).on('click', '#statusPickerMenu .dropdown-item[data-key]', function(e) {
                e.preventDefault();
                setPickedStatus($(this).data('key'));
            });

            function setPickedPriority(key) {
                pickedPriority = key;
                $('#priorityPickerIcon').attr('class', 'fa-solid fa-flag dot-priority-' + key);
                $('#priorityPickerLabel').text(priorityLabel(key));
                $('#priorityPickerMenu .dropdown-item').removeClass('active');
                $(`#priorityPickerMenu .dropdown-item[data-key="${key}"]`).addClass('active');
            }
            $(document).on('click', '#priorityPickerMenu .dropdown-item[data-key]', function(e) {
                e.preventDefault();
                setPickedPriority($(this).data('key'));
            });

            function updateReminderUI() {
                if (reminderAt) {
                    $('#reminderLabel').text(formatReminder(reminderAt));
                    $('#reminderClearBtn').show();
                    $('#reminderInput').val(toInputDateTime(reminderAt));
                } else {
                    $('#reminderLabel').text('Add reminder');
                    $('#reminderClearBtn').hide();
                    $('#reminderInput').val('');
                }
            }
            $('#reminderBtn').on('click', function() {
                $('#reminderInput').toggle();
                if ($('#reminderInput').is(':visible')) $('#reminderInput').trigger('focus').trigger(
                    'click');
            });
            $('#reminderInput').on('change', function() {
                const val = $(this).val();
                reminderAt = val ? new Date(val).getTime() : null;
                updateReminderUI();
            });
            $('#reminderClearBtn').on('click', function(e) {
                e.stopPropagation();
                reminderAt = null;
                updateReminderUI();
                $('#reminderInput').hide();
            });

            const editorModalEl = document.getElementById('editorModal');
            const editorModal = new bootstrap.Modal(editorModalEl);

            function resetEditor() {
                editingNoteId = null;
                $('#noteTitle').val('');
                quill.setContents([]);
                setPickedTopic(topics[0] ? topics[0].id : null);
                setPickedStatus('todo');
                setPickedPriority('medium');
                reminderAt = null;
                updateReminderUI();
                $('#reminderInput').hide();
                $('#editorCardTitle').text('New note');
                $('#btnSaveNote').text('Save note');
            }

            function openEditor() {
                editorModal.show();
                setTimeout(() => $('#noteTitle').focus(), 300);
            }

            function closeEditor() {
                editorModal.hide();
            }

            editorModalEl.addEventListener('hidden.bs.modal', resetEditor);
            $('#btnNewNoteMain').on('click', function() {
                resetEditor();
                openEditor();
            });
            $('#btnCloseEditor').on('click', closeEditor);
            $('#btnCancelEdit').on('click', function() {
                resetEditor();
                closeEditor();
            });

            $('#btnSaveNote').on('click', function() {
                const title = $('#noteTitle').val().trim();
                const html = quill.root.innerHTML;
                const isEmpty = quill.getText().trim().length === 0;
                if (!title && isEmpty) {
                    $('#noteTitle').focus();
                    return;
                }

                const payload = {
                    title: title || 'Untitled note',
                    content: html,
                    topic_id: pickedTopicId,
                    status: pickedStatus,
                    priority: pickedPriority,
                    reminder_at: reminderAt ? toInputDateTime(reminderAt) : null
                };

                const $btn = $(this).prop('disabled', true);
                const wasEditing = editingNoteId;
                const url = wasEditing ?
                    "{{ route('admin.notes.save', ':id') }}".replace(':id', wasEditing) :
                    "{{ route('admin.notes.save') }}";

                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    data: payload,
                    success: function(data) {
                        if (data.success) {
                            notify('success', data.message || (wasEditing ? 'Note updated' :
                                'Note saved'), 'toast');

                            if (data.html) {
                                const $new = $(data.html);
                                if (wasEditing) {
                                    $(`.note-card[data-id="${wasEditing}"]`).replaceWith($new);
                                } else {
                                    $('#notesListArea .empty-state').remove();
                                    $('#notesListArea').prepend($new);
                                    bumpListCount(1);
                                }
                            }

                            resetEditor();
                            closeEditor();
                        } else {
                            notify('error', data.message, 'toast');
                        }
                    },
                    error: function(error) {
                        notify('error', error.responseJSON?.message || 'Could not save note',
                            'toast');
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                    }
                });
            });

            function loadNoteIntoEditor($card) {
                editingNoteId = $card.data('id');
                $('#noteTitle').val($card.data('title'));
                quill.root.innerHTML = $card.data('content') || '';
                setPickedTopic($card.data('topic-id'));
                setPickedStatus($card.data('status') || 'todo');
                setPickedPriority($card.data('priority') || 'medium');
                const rem = $card.data('reminder-at');
                reminderAt = rem ? new Date(rem).getTime() : null;
                updateReminderUI();
                $('#reminderInput').toggle(!!reminderAt);
                $('#editorCardTitle').text('Editing note');
                $('#btnSaveNote').text('Update note');
                openEditor();
            }

            // Clicking the card body now opens the editor directly —
            // no separate view-only modal step. Clicks on the action
            // buttons (Done/Undo) are excluded so they don't also open it.
            $(document).on('click', '.note-card', function(e) {
                if ($(e.target).closest('.note-card-actions').length) return;
                loadNoteIntoEditor($(this));
            });

            resetEditor();
        });
    </script>
@endpush
