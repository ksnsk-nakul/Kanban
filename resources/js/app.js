import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('taskBoard', (initial) => ({
    columns: {
        todo: initial?.todo ?? [],
        in_progress: initial?.in_progress ?? [],
        done: initial?.done ?? [],
    },
    dragging: null,

    dragStart(id, fromColumn) {
        this.dragging = { id, fromColumn };
    },

    drop(toColumn) {
        if (!this.dragging) return;

        const { id, fromColumn } = this.dragging;
        this.dragging = null;

        if (!this.columns[fromColumn] || !this.columns[toColumn]) return;

        if (fromColumn === toColumn) return;

        const index = this.columns[fromColumn].findIndex((t) => t.id === id);
        if (index === -1) return;

        const [task] = this.columns[fromColumn].splice(index, 1);
        this.columns[toColumn].unshift(task);

        this.persist();
    },

    toggleDone(id) {
        const inDone = this.columns.done.some((t) => t.id === id);

        if (inDone) {
            this.move(id, 'done', 'todo');
        } else if (this.columns.todo.some((t) => t.id === id)) {
            this.move(id, 'todo', 'done');
        } else if (this.columns.in_progress.some((t) => t.id === id)) {
            this.move(id, 'in_progress', 'done');
        }
    },

    move(id, fromColumn, toColumn) {
        const index = this.columns[fromColumn].findIndex((t) => t.id === id);
        if (index === -1) return;

        const [task] = this.columns[fromColumn].splice(index, 1);
        this.columns[toColumn].unshift(task);

        this.persist();
    },

    async persist() {
        const url = window.__devlife?.reorderUrl;
        const csrf = window.__devlife?.csrf;
        if (!url || !csrf) return;

        const payload = {
            columns: {
                todo: this.columns.todo.map((t) => t.id),
                in_progress: this.columns.in_progress.map((t) => t.id),
                done: this.columns.done.map((t) => t.id),
            },
        };

        try {
            await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload),
            });
        } catch (e) {
            // no-op: UI stays responsive even if persist fails
        }
    },
}));

Alpine.start();
