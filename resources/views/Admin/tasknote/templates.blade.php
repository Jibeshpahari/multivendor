<template id="tpl-topic-item">
    <li><a class="dropdown-item" href="#">
        <span class="topic-dot"></span><span class="js-label"></span>
        <span class="topic-count js-count" style="margin-left:auto;"></span>
        <span class="filter-item-remove js-remove" title="Delete topic" style="margin-left:6px;"><i class="fa-solid fa-xmark"></i></span>
    </a></li>
</template>

<template id="tpl-status-item">
    <li><a class="dropdown-item" href="#">
        <span class="status-dot"></span><span class="js-label"></span>
        <span class="topic-count js-count" style="margin-left:auto;"></span>
    </a></li>
</template>

<template id="tpl-priority-item">
    <li><a class="dropdown-item" href="#">
        <i class="fa-solid fa-flag"></i><span class="js-label"></span>
        <span class="topic-count js-count" style="margin-left:auto;"></span>
    </a></li>
</template>

<template id="tpl-note-card">
    <div class="note-card">
        <div class="note-card-top">
            <span class="note-topic-tag">
                <span class="topic-dot"></span><span class="js-topic-name"></span>
            </span>
            <span class="note-card-title js-title"></span>
            <span class="note-card-time js-time"></span>
            <div class="note-card-actions">
                <button class="edit-btn" type="button" title="Edit"><i class="fa-solid fa-pen"></i></button>
                <button class="del-btn" type="button" title="Delete"><i class="fa-solid fa-trash"></i></button>
            </div>
        </div>
        <div class="note-card-meta">
            <span class="meta-pill js-status-pill"><i class="fa-solid fa-circle-dot"></i><span class="js-status-label"></span></span>
            <span class="meta-pill js-priority-pill"><i class="fa-solid fa-flag"></i><span class="js-priority-label"></span></span>
            <span class="meta-pill pill-reminder js-reminder-pill" style="display:none;"><i class="fa-solid fa-bell"></i><span class="js-reminder-label"></span></span>
        </div>
        <div class="note-card-preview js-preview"></div>
    </div>
</template>

<template id="tpl-empty-state">
    <div class="empty-state">
        <i class="fa-regular fa-note-sticky"></i>
        <h6>Nothing here yet</h6>
        <p>Try a different topic, search term or date range — or create your first note.</p>
    </div>
</template>