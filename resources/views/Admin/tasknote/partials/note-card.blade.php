@php
    $topic = $topics->firstWhere('id', $note->topic_id);
    $colorClass = $topic ? $topic->id % 7 : 6;
    $topicName = $topic->name ?? 'General';
@endphp
<div class="note-item" data-id="{{ $note->id }}">

    <div class="note-card {{ ($note->status ?? 'todo') === 'done' ? 'note-card-done' : '' }}"
        data-id="{{ $note->id }}" data-title="{{ $note->title }}" data-content="{{ $note->content }}"
        data-topic-id="{{ $note->topic_id }}" data-status="{{ $note->status ?? 'todo' }}"
        data-priority="{{ $note->priority ?? 'medium' }}" data-reminder-at="{{ $note->reminder_at }}">

        <div class="note-card-top">
            <div class="note-card-left">
                <div class="note-title-row">
                    <span class="note-card-time" data-bs-toggle="tooltip"
                        title="{{ format_date($note->created_at, 'd F Y - h:iA [l]') }}">
                        <i class="fa-regular fa-clock"></i>
                        <span>{{ format_date($note->created_at, 'h:iA') }}</span>
                    </span>

                    <span class="note-card-title" title="{{ $note->title }}">
                        {{ $note->title }}
                    </span>
                </div>
            </div>

            <div class="note-card-meta">
                <span class="note-topic-tag">
                    <span class="topic-dot dot-topic-{{ $colorClass }}"></span><span>{{ $topicName }}</span>
                </span>
                <span class="meta-pill pill-priority-{{ $note->priority ?? 'medium' }}">
                    <i class="fa-solid fa-flag"></i><span>{{ ucfirst($note->priority ?? 'medium') }}</span>
                </span>
                <span class="meta-pill pill-status-{{ $note->status ?? 'todo' }}">
                    <i
                        class="fa-solid fa-circle-dot"></i><span>{{ ucfirst($note->status === 'progress' ? 'In progress' : $note->status ?? 'To do') }}</span>
                </span>
                @if ($note->reminder_at)
                    <span class="meta-pill pill-reminder {{ $note->is_overdue ? 'overdue' : '' }}">
                        <i class="fa-solid fa-bell"></i>{{ format_date($note->reminder_at, 'M j, g:iA') }}
                    </span>
                @endif

                <span class="note-card-time d-none">
                    {{-- <i class="fa-regular fa-calendar"></i> --}}
                    <i class="fa-regular fa-clock"></i>
                    <span data-bs-toggle="tooltip" title="{{ format_date($note->created_at, 'd F Y - h:iA [l]') }}">
                        {{ format_date($note->created_at, 'h:iA') }}
                    </span>
                </span>
            </div>
        </div>

        <div class="note-card-preview">{!! $note->content !!}</div>

        <div class="note-card-actions">
            <button class="done-btn {{ ($note->status ?? 'todo') === 'done' ? 'revert-btn' : '' }}" type="button"
                title="{{ ($note->status ?? 'todo') === 'done' ? 'Move back to To do' : 'Mark as done' }}">
                <i class="fa-solid {{ ($note->status ?? 'todo') === 'done' ? 'fa-arrows-rotate' : 'fa-check' }}"></i>
                <span>{{ ($note->status ?? 'todo') === 'done' ? 'Undo' : 'Done' }}</span>
            </button>
        </div>
    </div>
</div>
