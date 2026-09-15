@extends('admin.layout.app')

@section('content')
    <div class="card p-4">
        <div class="filter-bar-wrapper">
            <div class="filter-bar">
                <div class="dropdown">
                    <button class="filter-btn dropdown-toggle" type="button" id="topicFilterBtn"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-hashtag"></i> Topic <span id="topicFilterValue">All</span>
                    </button>
                    <ul class="dropdown-menu topic-picker-menu filter-menu" id="topicFilterMenu"></ul>
                </div>

                <div class="dropdown">
                    <button class="filter-btn dropdown-toggle" type="button" id="statusFilterBtn"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-circle-dot"></i> Status <span id="statusFilterValue">All</span>
                    </button>
                    <ul class="dropdown-menu topic-picker-menu filter-menu" id="statusFilterMenu"></ul>
                </div>

                <div class="dropdown">
                    <button class="filter-btn dropdown-toggle" type="button" id="priorityFilterBtn"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-flag"></i> Priority <span id="priorityFilterValue">All</span>
                    </button>
                    <ul class="dropdown-menu topic-picker-menu filter-menu" id="priorityFilterMenu"></ul>
                </div>

                <div class="dropdown">
                    <button class="filter-btn dropdown-toggle" type="button" id="dateFilterBtn"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        <i class="fa-solid fa-calendar"></i> Date <span id="dateFilterValue">Any time</span>
                    </button>
                    <div class="dropdown-menu date-filter-box" aria-labelledby="dateFilterBtn">
                        <div class="field-row">
                            <label>From</label>
                            <input type="date" id="filterFrom">
                        </div>
                        <div class="field-row" style="margin-bottom:12px;">
                            <label>To</label>
                            <input type="date" id="filterTo">
                        </div>
                        <div class="df-actions">
                            <button class="btn-apply" id="btnApplyDate">Apply</button>
                            <button id="btnClearDate">Clear</button>
                        </div>
                    </div>
                </div>

                <button class="filter-clear-all" id="btnClearAllFilters" style="display: none;">
                    <i class="fa-solid fa-rotate-left"></i> Clear filters
                </button>
            </div>

            <div class="card-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Search notes...">
            </div>
        </div>
    </div>

    <div class="card p-4" style="min-height: 100px">
        <div class="list-meta-row">
            <div class="list-count" id="listCount">0 notes</div>
            <div class="header-actions">
                <button class="btn-new-note-main" id="btnNewNoteMain"><i class="fa-solid fa-plus"></i> New
                    note</button>
                
            </div>
        </div>

        <div id="notesListArea"></div>

        <div id="notesLoadMoreWrap" style="text-align:center; margin-top:18px; display:none;">
            <button class="btn-cancel-edit" id="btnLoadMore" type="button">Load more</button>
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
                                <span class="topic-dot dot-topic-pink" id="topicPickerDot"></span>
                                <span id="topicPickerLabel">General</span>
                            </button>
                            <ul class="dropdown-menu topic-picker-menu" id="topicPickerMenu"></ul>
                        </div>
                    </div>

                    <div class="editor-second-row">
                        <div class="topic-picker dropdown">
                            <button class="topic-picker-btn dropdown-toggle" type="button" id="statusPickerBtn"
                                data-bs-toggle="dropdown">
                                <span class="status-dot dot-status-todo" id="statusPickerDot"></span>
                                <span id="statusPickerLabel">To do</span>
                            </button>
                            <ul class="dropdown-menu topic-picker-menu" id="statusPickerMenu"></ul>
                        </div>

                        <div class="topic-picker dropdown">
                            <button class="topic-picker-btn dropdown-toggle" type="button" id="priorityPickerBtn"
                                data-bs-toggle="dropdown">
                                <i class="fa-solid fa-flag dot-priority-medium" id="priorityPickerIcon"></i>
                                <span id="priorityPickerLabel">Medium</span>
                            </button>
                            <ul class="dropdown-menu topic-picker-menu" id="priorityPickerMenu"></ul>
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
                    <label class="form-label d-block mt-3 mb-1">Color</label>
                    <div class="swatch-row" id="colorSwatchRow"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-soft" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-dark-primary" id="btnConfirmAddTopic">Create topic</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete this?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="deleteModalText" style="font-size:13.5px; color:var(--ink-soft);">This action can't be
                        undone.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-soft" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-dark-primary" id="btnConfirmDelete"
                        style="background:var(--a-coral); border-color:var(--a-coral);">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- TOAST -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:2000;">
        <div id="appToast" class="toast align-items-center border-0" style="background:var(--ink); color:#fff;">
            <div class="d-flex">
                <div class="toast-body" id="appToastMsg">Saved</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @include('admin.tasknote.templates')
@endsection


@push('css')
    {{-- Quill isn't loaded elsewhere in the app yet, so it's added here --}}
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

        .topic-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            flex-shrink: 0;
            display: inline-block;
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
        }

        .filter-clear-all:hover {
            border-color: var(--a-coral);
            color: var(--a-coral);
        }

        .filter-item-remove {
            color: var(--ink-faint);
            font-size: 11px;
            padding: 2px 4px;
            margin-left: auto;
        }

        .filter-item-remove:hover {
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

        .note-card-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 8px;
        }

        .meta-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .meta-pill i {
            font-size: 10px;
        }

        .pill-reminder {
            background: #eef0ff;
            color: #5b5fef;
        }

        .pill-reminder.overdue {
            background: #fdeceb !important;
            color: #b91c1c !important;
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

        .date-group-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--ink-faint);
            margin: 26px 0 12px;
            letter-spacing: 0.01em;
        }

        .date-group-label:first-of-type {
            margin-top: 0;
        }

        .note-card {
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 16px 18px;
            margin-bottom: 10px;
            background: var(--paper);
            transition: border-color .12s ease, box-shadow .12s ease;
            cursor: pointer;
        }

        .note-card:hover {
            border-color: var(--line-strong);
            box-shadow: 0 4px 14px rgba(16, 16, 20, 0.06);
        }

        .note-card-top {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
        }

        .note-topic-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 9px 3px 7px;
            border-radius: 20px;
        }

        .note-card-title {
            font-size: 15.5px;
            font-weight: 600;
            color: var(--ink);
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .note-card-time {
            font-size: 11.5px;
            color: var(--ink-faint);
            font-weight: 500;
            flex-shrink: 0;
        }

        .note-card-preview {
            font-size: 13px;
            color: var(--ink-soft);
            line-height: 1.5;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .note-card-preview p {
            margin: 0;
        }

        .note-card-actions {
            display: flex;
            gap: 6px;
            margin-left: 8px;
        }

        .note-card-actions button {
            width: 28px;
            height: 28px;
            border: none;
            background: transparent;
            color: var(--ink-faint);
            border-radius: 6px;
            font-size: 12px;
        }

        .note-card-actions button:hover {
            background: var(--panel-deep);
            color: var(--ink);
        }

        .note-card-actions .del-btn:hover {
            color: var(--a-coral);
            background: #fdeceb;
        }

        .empty-state {
            text-align: center;
            padding: 70px 20px;
            color: var(--ink-faint);
        }

        .empty-state i {
            font-size: 30px;
            margin-bottom: 14px;
            display: block;
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

        
        .swatch-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .swatch {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 11px;
        }

        .swatch.selected {
            border-color: var(--ink);
            box-shadow: 0 0 0 2px var(--paper);
        }

        .swatch-row .swatch:nth-child(1) { background: var(--a-indigo); }
        .swatch-row .swatch:nth-child(2) { background: var(--a-teal); }
        .swatch-row .swatch:nth-child(3) { background: var(--a-amber); }
        .swatch-row .swatch:nth-child(4) { background: var(--a-coral); }
        .swatch-row .swatch:nth-child(5) { background: var(--a-violet); }
        .swatch-row .swatch:nth-child(6) { background: var(--a-pink); }
        .swatch-row .swatch:nth-child(7) { background: var(--a-slate); }

        

        .dot-all { background: var(--ink); }

        .dot-topic-indigo, .tag-topic-indigo .topic-dot { background: var(--a-indigo); }
        .dot-topic-teal,   .tag-topic-teal   .topic-dot { background: var(--a-teal); }
        .dot-topic-amber,  .tag-topic-amber  .topic-dot { background: var(--a-amber); }
        .dot-topic-coral,  .tag-topic-coral  .topic-dot { background: var(--a-coral); }
        .dot-topic-violet, .tag-topic-violet .topic-dot { background: var(--a-violet); }
        .dot-topic-pink,   .tag-topic-pink   .topic-dot { background: var(--a-pink); }
        .dot-topic-slate,  .tag-topic-slate  .topic-dot { background: var(--a-slate); }

        .tag-topic-indigo { background: rgba(91, 95, 239, 0.1);  color: var(--a-indigo); }
        .tag-topic-teal   { background: rgba(18, 165, 148, 0.1); color: var(--a-teal); }
        .tag-topic-amber  { background: rgba(220, 155, 48, 0.1); color: var(--a-amber); }
        .tag-topic-coral  { background: rgba(230, 96, 76, 0.1);  color: var(--a-coral); }
        .tag-topic-violet { background: rgba(139, 92, 246, 0.1); color: var(--a-violet); }
        .tag-topic-pink   { background: rgba(232, 119, 154, 0.1); color: var(--a-pink); }
        .tag-topic-slate  { background: rgba(113, 113, 122, 0.1); color: var(--a-slate); }

        .dot-status-todo     { background: #9a9aa2; }
        .dot-status-progress { background: var(--a-indigo); }
        .dot-status-done     { background: var(--a-teal); }

        .pill-status-todo     { background: rgba(154, 154, 162, 0.1); color: #9a9aa2; }
        .pill-status-progress { background: rgba(91, 95, 239, 0.1);  color: var(--a-indigo); }
        .pill-status-done     { background: rgba(18, 165, 148, 0.1); color: var(--a-teal); }

        .dot-priority-all    { color: var(--ink); }
        .dot-priority-low    { color: #9a9aa2; }
        .dot-priority-medium { color: var(--a-amber); }
        .dot-priority-high   { color: var(--a-coral); }
        .dot-priority-urgent { color: #b91c1c; }

        .pill-priority-low    { background: rgba(154, 154, 162, 0.1); color: #9a9aa2; }
        .pill-priority-medium { background: rgba(220, 155, 48, 0.1); color: var(--a-amber); }
        .pill-priority-high   { background: rgba(230, 96, 76, 0.1);  color: var(--a-coral); }
        .pill-priority-urgent { background: rgba(185, 28, 28, 0.1); color: #b91c1c; }

        
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

        .toast {
            font-family: 'Poppins', sans-serif;
            border-radius: 10px;
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
@endpush

@push('js')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>

    <script>
        
        $(function () {

            
            const API = {
                notes: '/admin/notes',
                topics: '/admin/topics'
            };

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            
            const PALETTE_KEYS = ['indigo', 'teal', 'amber', 'coral', 'violet', 'pink', 'slate'];

            const STATUS_DEFS = [
                { key: 'todo', label: 'To do' },
                { key: 'progress', label: 'In progress' },
                { key: 'done', label: 'Done' }
            ];
            const PRIORITY_DEFS = [
                { key: 'low', label: 'Low' },
                { key: 'medium', label: 'Medium' },
                { key: 'high', label: 'High' },
                { key: 'urgent', label: 'Urgent' }
            ];
            function statusDef(key) { return STATUS_DEFS.find(s => s.key === key) || STATUS_DEFS[0]; }
            function priorityDef(key) { return PRIORITY_DEFS.find(p => p.key === key) || PRIORITY_DEFS[1]; }
            
            
            
            function cloneTemplate(id) {
                return $(document.getElementById(id).content.firstElementChild.cloneNode(true));
            }

            
            let topics = [];
            let notes = [];
            let meta = { current_page: 1, last_page: 1, total: 0 };
            let counts = { all: 0, topics: {}, statuses: {}, priorities: {} };
            let lastGroupLabel = null;

            let activeTopicId = 'all';
            let activeStatusFilter = 'all';
            let activePriorityFilter = 'all';
            let searchQuery = '';
            let dateFrom = null;
            let dateTo = null;
            let currentPage = 1;

            let editingNoteId = null;
            let pickedTopicId = null;
            let pickedStatus = 'todo';
            let pickedPriority = 'medium';
            let reminderAt = null;
            let pendingDelete = null;

            
            const quill = new Quill('#editor-container', {
                theme: 'snow',
                placeholder: 'Write what you need to remember...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        [{ color: [] }],
                        ['blockquote', 'link'],
                        ['clean']
                    ]
                }
            });

            
            function topicById(id) { return topics.find(t => t.id == id); }
            function isSameDay(a, b) {
                return a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a.getDate() === b.getDate();
            }
            
            
            function friendlyDateLabel(ts) {
                const d = new Date(ts);
                const now = new Date();
                const yest = new Date(now); yest.setDate(now.getDate() - 1);
                if (isSameDay(d, now)) return 'Today';
                if (isSameDay(d, yest)) return 'Yesterday';
                return d.toLocaleDateString(undefined, { weekday: 'short', day: 'numeric', month: 'short', year: d.getFullYear() !== now.getFullYear() ? 'numeric' : undefined });
            }
            function timeLabel(ts) {
                return new Date(ts).toLocaleTimeString(undefined, { hour: 'numeric', minute: '2-digit' });
            }
            function toInputDateTime(ts) {
                const d = new Date(ts);
                const pad = n => String(n).padStart(2, '0');
                return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
            }
            function formatReminder(ts) {
                return new Date(ts).toLocaleString(undefined, { month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit' });
            }
            
            
            function showToast(msg, fallback) {
                $('#appToastMsg').text(msg || fallback || 'Done');
                new bootstrap.Toast(document.getElementById('appToast'), { delay: 2200 }).show();
            }
            
            
            
            
            function firstValidationError(xhr, fallback) {
                const body = xhr.responseJSON;
                if (body && body.errors) {
                    const firstKey = Object.keys(body.errors)[0];
                    if (firstKey && body.errors[firstKey] && body.errors[firstKey][0]) {
                        return body.errors[firstKey][0];
                    }
                }
                return (body && body.message) || fallback;
            }

            
            function fetchTopics() {
                return $.get(API.topics).then(function (res) {
                    topics = (res.data || res).map(t => ({ id: t.id, name: t.name, colorKey: t.color_key }));
                    renderTopicPickerMenu();
                });
            }

            function renderTopicPickerMenu() {
                const $menu = $('#topicPickerMenu').empty();
                topics.forEach(t => {
                    const $item = cloneTemplate('tpl-topic-item');
                    $item.find('.js-count, .js-remove').remove();
                    $item.find('a').toggleClass('active', t.id === pickedTopicId).attr('data-id', t.id);
                    $item.find('.topic-dot').addClass('dot-topic-' + t.colorKey);
                    $item.find('.js-label').text(t.name);
                    $menu.append($item);
                });
                $menu.append(`<li><hr class="dropdown-divider"></li>`);
                $menu.append(`<li><a class="dropdown-item" href="#" id="pickerAddTopic"><i class="fa-solid fa-plus" style="width:9px;"></i> New topic</a></li>`);
                if (pickedTopicId != null) setPickedTopic(pickedTopicId);
            }
            function setPickedTopic(id) {
                const t = topicById(id) || topics[0];
                if (!t) return;
                pickedTopicId = t.id;
                $('#topicPickerDot').attr('class', 'topic-dot dot-topic-' + t.colorKey);
                $('#topicPickerLabel').text(t.name);
                $('#topicPickerMenu .dropdown-item').removeClass('active');
                $(`#topicPickerMenu .dropdown-item[data-id="${t.id}"]`).addClass('active');
            }
            $(document).on('click', '#topicPickerMenu .dropdown-item[data-id]', function (e) {
                e.preventDefault();
                setPickedTopic($(this).data('id'));
            });
            $(document).on('click', '#pickerAddTopic', function (e) {
                e.preventDefault();
                openAddTopicModal();
            });

            
            function renderTopicList() {
                const $list = $('#topicFilterMenu').empty();
                $list.append(`
                    <li><a class="dropdown-item ${activeTopicId === 'all' ? 'active' : ''}" href="#" data-id="all">
                      <span class="topic-dot dot-all"></span> All notes <span class="topic-count" style="margin-left:auto;">${counts.all || 0}</span>
                    </a></li>
                `);
                topics.forEach(t => {
                    const count = (counts.topics && counts.topics[t.id]) || 0;
                    const $item = cloneTemplate('tpl-topic-item');
                    $item.find('a').toggleClass('active', activeTopicId == t.id).attr('data-id', t.id);
                    $item.find('.topic-dot').addClass('dot-topic-' + t.colorKey);
                    $item.find('.js-label').text(t.name);
                    $item.find('.js-count').text(count);
                    $item.find('.js-remove').attr('data-remove-topic', t.id);
                    $list.append($item);
                });
                $list.append(`<li><hr class="dropdown-divider"></li>`);
                $list.append(`<li><a class="dropdown-item" href="#" id="filterAddTopic"><i class="fa-solid fa-plus" style="width:9px;"></i> New topic</a></li>`);
                $('#topicFilterValue').text(activeTopicId === 'all' ? 'All' : (topicById(activeTopicId)?.name || 'All'));
                $('#topicFilterBtn').toggleClass('is-active', activeTopicId !== 'all');
            }
            $(document).on('click', '#topicFilterMenu .dropdown-item[data-id]', function (e) {
                if ($(e.target).closest('[data-remove-topic]').length) return;
                e.preventDefault();
                activeTopicId = $(this).data('id');
                fetchNotes(1, false);
            });
            $(document).on('click', '#filterAddTopic', function (e) {
                e.preventDefault();
                openAddTopicModal();
            });
            $(document).on('click', '[data-remove-topic]', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const id = $(this).data('remove-topic');
                const t = topicById(id);
                if (!t) return;
                const count = (counts.topics && counts.topics[id]) || 0;
                $('#deleteModalText').text(
                    count > 0
                        ? `"${t.name}" has ${count} note${count > 1 ? 's' : ''}. Deleting it will move ${count > 1 ? 'them' : 'it'} to General.`
                        : `Delete the topic "${t.name}"? This can't be undone.`
                );
                pendingDelete = { type: 'topic', id };
                new bootstrap.Modal('#deleteModal').show();
            });

            
            let selectedSwatch = PALETTE_KEYS[0];
            function renderSwatches() {
                const $row = $('#colorSwatchRow').empty();
                PALETTE_KEYS.forEach(key => {
                    $row.append(`<div class="swatch ${key === selectedSwatch ? 'selected' : ''}" data-key="${key}"></div>`);
                });
            }
            $(document).on('click', '.swatch', function () {
                selectedSwatch = $(this).data('key');
                renderSwatches();
            });
            function openAddTopicModal() {
                $('#newTopicName').val('');
                selectedSwatch = PALETTE_KEYS[Math.floor(Math.random() * PALETTE_KEYS.length)];
                renderSwatches();
                new bootstrap.Modal('#topicModal').show();
                setTimeout(() => $('#newTopicName').focus(), 250);
            }
            $('#btnConfirmAddTopic').on('click', function () {
                const name = $('#newTopicName').val().trim();
                if (!name) { $('#newTopicName').focus(); return; }
                const $btn = $(this).prop('disabled', true);
                $.ajax({ url: API.topics, method: 'POST', data: { name, color_key: selectedSwatch } })
                    .done(function (res) {
                        bootstrap.Modal.getInstance(document.getElementById('topicModal')).hide();
                        showToast(res.message, `Topic "${name}" created`);
                        
                        
                        fetchTopics().then(function () {
                            const created = topics.find(t => t.name === name);
                            if (created) setPickedTopic(created.id);
                            renderTopicList();
                        });
                    })
                    
                    
                    .fail(function (xhr) {
                        showToast(firstValidationError(xhr, 'Could not create topic'));
                    })
                    .always(function () { $btn.prop('disabled', false); });
            });

            
            function buildNotesParams(page) {
                const params = { page: page || currentPage };
                if (activeTopicId !== 'all') params.topic = activeTopicId;
                if (activeStatusFilter !== 'all') params.status = activeStatusFilter;
                if (activePriorityFilter !== 'all') params.priority = activePriorityFilter;
                if (searchQuery) params.q = searchQuery;
                if (dateFrom) params.from = dateFrom;
                if (dateTo) params.to = dateTo;
                return params;
            }

            function fetchNotes(page, append) {
                page = page || 1;
                const $area = $('#notesListArea');
                if (!append) $area.css('opacity', 0.55);

                return $.get(API.notes, buildNotesParams(page))
                    .done(function (res) {
                        meta = res.meta;
                        counts = res.counts;
                        currentPage = res.meta.current_page;

                        if (append) {
                            notes = notes.concat(res.data);
                        } else {
                            notes = res.data;
                            lastGroupLabel = null;
                            $area.empty();
                        }

                        $('#listCount').text(`${meta.total} note${meta.total === 1 ? '' : 's'}`);

                        if (notes.length === 0) {
                            $area.append(cloneTemplate('tpl-empty-state'));
                        } else {
                            res.data.forEach(renderNoteCard);
                        }

                        renderTopicList();
                        renderStatusFilterList();
                        renderPriorityFilterList();
                        updateClearAllVisibility();
                        updateLoadMoreUI();
                    })
                    .fail(function () {
                        showToast(null, "Couldn't load notes — check your connection");
                    })
                    .always(function () {
                        $area.css('opacity', 1);
                    });
            }

            function renderNoteCard(n) {
                const label = friendlyDateLabel(n.created_at);
                if (label !== lastGroupLabel) {
                    $('#notesListArea').append(`<div class="date-group-label">${label}</div>`);
                    lastGroupLabel = label;
                }
                const t = topicById(n.topic_id) || { name: 'General', colorKey: 'slate' };
                const s = statusDef(n.status || 'todo');
                const p = priorityDef(n.priority || 'medium');
                
                const isOverdue = !!n.is_overdue;

                const $card = cloneTemplate('tpl-note-card').attr('data-id', n.id);
                $card.find('.topic-dot').addClass('dot-topic-' + t.colorKey);
                $card.find('.note-topic-tag').addClass('tag-topic-' + t.colorKey);
                $card.find('.js-topic-name').text(t.name);
                $card.find('.js-title').text(n.title);
                $card.find('.js-time').text(timeLabel(n.created_at));
                $card.find('.js-status-pill').addClass('pill-status-' + s.key);
                $card.find('.js-status-label').text(s.label);
                $card.find('.js-priority-pill').addClass('pill-priority-' + p.key);
                $card.find('.js-priority-label').text(p.label);
                if (n.reminder_at) {
                    $card.find('.js-reminder-pill').toggleClass('overdue', isOverdue).show();
                    $card.find('.js-reminder-label').text(formatReminder(n.reminder_at));
                }
                
                
                $card.find('.js-preview').html(n.content);

                $('#notesListArea').append($card);
            }

            function updateLoadMoreUI() {
                if (meta.current_page < meta.last_page) {
                    $('#notesLoadMoreWrap').show();
                    $('#btnLoadMore').text(`Load more (${meta.total - notes.length} remaining)`);
                } else {
                    $('#notesLoadMoreWrap').hide();
                }
            }
            $('#btnLoadMore').on('click', function () {
                fetchNotes(currentPage + 1, true);
            });

            
            function renderStatusFilterList() {
                const $list = $('#statusFilterMenu').empty();
                $list.append(`
                    <li><a class="dropdown-item ${activeStatusFilter === 'all' ? 'active' : ''}" href="#" data-key="all">
                      <span class="status-dot dot-all"></span> All <span class="topic-count" style="margin-left:auto;">${counts.all || 0}</span>
                    </a></li>
                `);
                STATUS_DEFS.forEach(s => {
                    const count = (counts.statuses && counts.statuses[s.key]) || 0;
                    const $item = cloneTemplate('tpl-status-item');
                    $item.find('a').toggleClass('active', activeStatusFilter === s.key).attr('data-key', s.key);
                    $item.find('.status-dot').addClass('dot-status-' + s.key);
                    $item.find('.js-label').text(s.label);
                    $item.find('.js-count').text(count);
                    $list.append($item);
                });
                $('#statusFilterValue').text(activeStatusFilter === 'all' ? 'All' : statusDef(activeStatusFilter).label);
                $('#statusFilterBtn').toggleClass('is-active', activeStatusFilter !== 'all');
            }
            function renderPriorityFilterList() {
                const $list = $('#priorityFilterMenu').empty();
                $list.append(`
                    <li><a class="dropdown-item ${activePriorityFilter === 'all' ? 'active' : ''}" href="#" data-key="all">
                      <i class="fa-solid fa-flag dot-priority-all" style="width:9px; font-size:10px;"></i> All <span class="topic-count" style="margin-left:auto;">${counts.all || 0}</span>
                    </a></li>
                `);
                PRIORITY_DEFS.forEach(p => {
                    const count = (counts.priorities && counts.priorities[p.key]) || 0;
                    const $item = cloneTemplate('tpl-priority-item');
                    $item.find('a').toggleClass('active', activePriorityFilter === p.key).attr('data-key', p.key);
                    $item.find('i').addClass('dot-priority-' + p.key).attr('style', 'width:9px; font-size:10px;');
                    $item.find('.js-label').text(p.label);
                    $item.find('.js-count').text(count);
                    $list.append($item);
                });
                $('#priorityFilterValue').text(activePriorityFilter === 'all' ? 'All' : priorityDef(activePriorityFilter).label);
                $('#priorityFilterBtn').toggleClass('is-active', activePriorityFilter !== 'all');
            }
            $(document).on('click', '#statusFilterMenu .dropdown-item[data-key]', function (e) {
                e.preventDefault();
                activeStatusFilter = $(this).data('key');
                fetchNotes(1, false);
            });
            $(document).on('click', '#priorityFilterMenu .dropdown-item[data-key]', function (e) {
                e.preventDefault();
                activePriorityFilter = $(this).data('key');
                fetchNotes(1, false);
            });

            
            function renderStatusPickerMenu() {
                const $menu = $('#statusPickerMenu').empty();
                STATUS_DEFS.forEach(s => {
                    const $item = cloneTemplate('tpl-status-item');
                    $item.find('.js-count').remove();
                    $item.find('a').toggleClass('active', s.key === pickedStatus).attr('data-key', s.key);
                    $item.find('.status-dot').addClass('dot-status-' + s.key);
                    $item.find('.js-label').text(s.label);
                    $menu.append($item);
                });
            }
            function setPickedStatus(key) {
                const s = statusDef(key);
                pickedStatus = s.key;
                $('#statusPickerDot').attr('class', 'status-dot dot-status-' + s.key);
                $('#statusPickerLabel').text(s.label);
                $('#statusPickerMenu .dropdown-item').removeClass('active');
                $(`#statusPickerMenu .dropdown-item[data-key="${s.key}"]`).addClass('active');
            }
            $(document).on('click', '#statusPickerMenu .dropdown-item[data-key]', function (e) {
                e.preventDefault();
                setPickedStatus($(this).data('key'));
            });

            function renderPriorityPickerMenu() {
                const $menu = $('#priorityPickerMenu').empty();
                PRIORITY_DEFS.forEach(p => {
                    const $item = cloneTemplate('tpl-priority-item');
                    $item.find('.js-count').remove();
                    $item.find('a').toggleClass('active', p.key === pickedPriority).attr('data-key', p.key);
                    $item.find('i').addClass('dot-priority-' + p.key).attr('style', 'width:11px;');
                    $item.find('.js-label').text(p.label);
                    $menu.append($item);
                });
            }
            function setPickedPriority(key) {
                const p = priorityDef(key);
                pickedPriority = p.key;
                $('#priorityPickerIcon').attr('class', 'fa-solid fa-flag dot-priority-' + p.key);
                $('#priorityPickerLabel').text(p.label);
                $('#priorityPickerMenu .dropdown-item').removeClass('active');
                $(`#priorityPickerMenu .dropdown-item[data-key="${p.key}"]`).addClass('active');
            }
            $(document).on('click', '#priorityPickerMenu .dropdown-item[data-key]', function (e) {
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
            $('#reminderBtn').on('click', function () {
                $('#reminderInput').toggle();
                if ($('#reminderInput').is(':visible')) $('#reminderInput').trigger('focus').trigger('click');
            });
            $('#reminderInput').on('change', function () {
                const val = $(this).val();
                reminderAt = val ? new Date(val).getTime() : null;
                updateReminderUI();
            });
            $('#reminderClearBtn').on('click', function (e) {
                e.stopPropagation();
                reminderAt = null;
                updateReminderUI();
                $('#reminderInput').hide();
            });

            
            $('#btnConfirmDelete').on('click', function () {
                if (!pendingDelete) return;
                const $btn = $(this).prop('disabled', true);

                if (pendingDelete.type === 'note') {
                    $.ajax({ url: `${API.notes}/${pendingDelete.id}`, method: 'DELETE' })
                        .done(function (res) {
                            if (editingNoteId === pendingDelete.id) resetEditor();
                            showToast(res.message, 'Note deleted');
                            fetchNotes(1, false);
                        })
                        .fail(function (xhr) { showToast(firstValidationError(xhr, 'Could not delete note')); })
                        .always(finishDelete);
                } else if (pendingDelete.type === 'topic') {
                    
                    $.ajax({ url: `${API.topics}/${pendingDelete.id}`, method: 'DELETE' })
                        .done(function (res) {
                            if (activeTopicId === pendingDelete.id) activeTopicId = 'all';
                            showToast(res.message, 'Topic deleted');
                            fetchTopics().then(function () { fetchNotes(1, false); });
                        })
                        .fail(function (xhr) { showToast(firstValidationError(xhr, 'Could not delete topic')); })
                        .always(finishDelete);
                }

                function finishDelete() {
                    $btn.prop('disabled', false);
                    pendingDelete = null;
                    bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
                }
            });

            
            const editorModalEl = document.getElementById('editorModal');
            const editorModal = new bootstrap.Modal(editorModalEl);

            function resetEditor() {
                editingNoteId = null;
                $('#noteTitle').val('');
                quill.setContents([]);
                setPickedTopic(activeTopicId !== 'all' ? activeTopicId : (topics[0] ? topics[0].id : null));
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
            function openNewNote() {
                resetEditor();
                openEditor();
            }
            $('#btnNewNoteMain').on('click', openNewNote);
            $('#btnCloseEditor').on('click', closeEditor);
            $('#btnCancelEdit').on('click', function () {
                resetEditor();
                closeEditor();
            });

            $('#btnSaveNote').on('click', function () {
                const title = $('#noteTitle').val().trim();
                const html = quill.root.innerHTML;
                const isEmpty = quill.getText().trim().length === 0;
                if (!title && isEmpty) { $('#noteTitle').focus(); return; }

                const payload = {
                    title: title || 'Untitled note',
                    
                    
                    content: html,
                    topic_id: pickedTopicId,
                    status: pickedStatus,
                    priority: pickedPriority,
                    reminder_at: reminderAt ? toInputDateTime(reminderAt) : null
                };

                const $btn = $(this).prop('disabled', true);
                
                
                const url = editingNoteId ? `${API.notes}/${editingNoteId}` : API.notes;

                $.ajax({ url, method: 'POST', data: payload })
                    .done(function (res) {
                        showToast(res.message, editingNoteId ? 'Note updated' : 'Note saved');
                        resetEditor();
                        closeEditor();
                        fetchNotes(1, false);
                    })
                    
                    
                    .fail(function (xhr) {
                        showToast(firstValidationError(xhr, 'Could not save note'));
                    })
                    .always(function () { $btn.prop('disabled', false); });
            });

            function loadNoteIntoEditor(id) {
                
                
                const n = notes.find(x => x.id == id);
                if (!n) return;
                editingNoteId = id;
                $('#noteTitle').val(n.title);
                quill.root.innerHTML = n.content;
                setPickedTopic(n.topic_id);
                setPickedStatus(n.status || 'todo');
                setPickedPriority(n.priority || 'medium');
                reminderAt = n.reminder_at ? new Date(n.reminder_at).getTime() : null;
                updateReminderUI();
                $('#reminderInput').toggle(!!reminderAt);
                $('#editorCardTitle').text('Editing note');
                $('#btnSaveNote').text('Update note');
                openEditor();
            }

            $(document).on('click', '.note-card', function (e) {
                if ($(e.target).closest('.note-card-actions').length) return;
                loadNoteIntoEditor($(this).data('id'));
            });
            $(document).on('click', '.edit-btn', function (e) {
                e.stopPropagation();
                loadNoteIntoEditor($(this).closest('.note-card').data('id'));
            });
            $(document).on('click', '.del-btn', function (e) {
                e.stopPropagation();
                const id = $(this).closest('.note-card').data('id');
                const n = notes.find(x => x.id == id);
                pendingDelete = { type: 'note', id };
                $('#deleteModalText').text(`Delete "${n ? n.title : 'this note'}"? This can't be undone.`);
                new bootstrap.Modal('#deleteModal').show();
            });

            
            let searchTimer = null;
            $('#searchInput').on('input', function () {
                clearTimeout(searchTimer);
                const val = $(this).val();
                searchTimer = setTimeout(function () {
                    searchQuery = val.trim();
                    fetchNotes(1, false);
                }, 150);
            });

            
            function updateDateFilterLabel() {
                let label = 'Any time';
                if (dateFrom && dateTo) label = `${dateFrom} → ${dateTo}`;
                else if (dateFrom) label = `From ${dateFrom}`;
                else if (dateTo) label = `Until ${dateTo}`;
                $('#dateFilterValue').text(label);
                $('#dateFilterBtn').toggleClass('is-active', !!(dateFrom || dateTo));
            }
            $('#btnApplyDate').on('click', function () {
                dateFrom = $('#filterFrom').val() || null;
                dateTo = $('#filterTo').val() || null;
                updateDateFilterLabel();
                fetchNotes(1, false);
                bootstrap.Dropdown.getOrCreateInstance(document.getElementById('dateFilterBtn')).hide();
            });
            $('#btnClearDate').on('click', function () {
                dateFrom = null; dateTo = null;
                $('#filterFrom').val(''); $('#filterTo').val('');
                updateDateFilterLabel();
                fetchNotes(1, false);
            });

            
            function updateClearAllVisibility() {
                const anyActive = activeTopicId !== 'all' || activeStatusFilter !== 'all' || activePriorityFilter !== 'all' || dateFrom || dateTo || searchQuery;
                $('#btnClearAllFilters').css('display', anyActive ? 'inline-flex' : 'none');
            }
            $('#btnClearAllFilters').on('click', function () {
                activeTopicId = 'all';
                activeStatusFilter = 'all';
                activePriorityFilter = 'all';
                dateFrom = null; dateTo = null;
                searchQuery = '';
                $('#searchInput').val('');
                $('#filterFrom').val(''); $('#filterTo').val('');
                updateDateFilterLabel();
                fetchNotes(1, false);
            });

            
            renderStatusPickerMenu();
            renderPriorityPickerMenu();
            updateDateFilterLabel();

            fetchTopics().then(function () {
                resetEditor();
                fetchNotes(1, false);
            });
        });
    </script>
@endpush