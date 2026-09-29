<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>⚡ Turbo Laravel Studio</title>


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }


        body {
            background: linear-gradient(135deg, #eef2f7, #d9e4f5);
            min-height: 100vh;
            padding: 40px;
            color: #1f2937;
        }


        .container {
            max-width: 1150px;
            margin: auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08);
            position: relative;
        }


        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
        }


        h1 {
            color: #1e293b;
            font-size: 26px;
            font-weight: 800;
        }


        .header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }


        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            border: none;
            border-radius: 9px;
            cursor: pointer;
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.25s ease;
        }


        .btn-primary { background: #4f46e5; }
        .btn-primary:hover { background: #4338ca; transform: translateY(-1px); }

        .btn-secondary { background: #64748b; }
        .btn-secondary:hover { background: #475569; }

        .btn-success { background: #10b981; }
        .btn-success:hover { background: #059669; }

        .btn-warning { background: #f59e0b; color: #1e293b; }
        .btn-warning:hover { background: #d97706; color: #fff; }

        .btn-danger { background: #ef4444; }
        .btn-danger:hover { background: #dc2626; }

        .btn-activity {
            background: #8b5cf6;
            color: white;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);
        }

        .btn-activity:hover {
            background: #7c3aed;
            transform: translateY(-2px);
        }


        /* ==========================================
           TOAST NOTIFICATIONS (DYNAMIC FLASH STREAM)
        ========================================== */
        .toast-container {
            position: fixed;
            top: 25px;
            right: 25px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 380px;
            pointer-events: none;
        }


        .toast {
            pointer-events: auto;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-left: 5px solid #4f46e5;
            animation: slideInRight 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            transition: all 0.3s ease;
        }


        @keyframes slideInRight {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }


        .toast-success { border-left-color: #10b981; }
        .toast-error { border-left-color: #ef4444; }
        .toast-warning { border-left-color: #f59e0b; }
        .toast-info { border-left-color: #3b82f6; }


        .toast-icon { font-size: 20px; }
        .toast-message { flex: 1; font-weight: 600; font-size: 14px; color: #1e293b; }

        .toast-close {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #94a3b8;
        }

        .toast-close:hover { color: #1e293b; }


        /* ==========================================
           SLIDING LIVE ACTIVITY FEED DRAWER
        ========================================== */
        .activity-drawer {
            position: fixed;
            top: 0;
            right: -420px;
            width: 400px;
            height: 100vh;
            background: #ffffff;
            box-shadow: -10px 0 35px rgba(0, 0, 0, 0.15);
            z-index: 9990;
            transition: right 0.35s ease;
            display: flex;
            flex-direction: column;
        }

        .activity-drawer.active {
            right: 0;
        }

        .drawer-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(2px);
            z-index: 9980;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .drawer-backdrop.active {
            opacity: 1;
            pointer-events: auto;
        }

        .drawer-header {
            padding: 20px 24px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .drawer-title { font-size: 17px; color: #1e293b; }

        .drawer-actions { display: flex; align-items: center; gap: 10px; }

        .btn-clear-activity {
            background: #fee2e2;
            color: #b91c1c;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .drawer-close-btn {
            background: transparent;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: #64748b;
        }

        .drawer-body {
            flex: 1;
            overflow-y: auto;
            padding: 16px 20px;
        }

        .activity-list { display: flex; flex-direction: column; gap: 10px; }

        .activity-item {
            padding: 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .activity-item:hover {
            background: #ffffff;
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .activity-main { display: flex; gap: 12px; align-items: flex-start; }

        .activity-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #e0e7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .activity-details { flex: 1; }
        .activity-desc { font-size: 13.5px; font-weight: 600; color: #334155; line-height: 1.4; }
        .activity-time { font-size: 11.5px; color: #94a3b8; margin-top: 4px; }
        .empty-activities { text-align: center; padding: 40px 20px; color: #94a3b8; font-size: 14px; }


        /* ==========================================
           DRAG & DROP MULTI-FILE UPLOADER & PREVIEW
        ========================================== */
        .dropzone-container {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .dropzone-area {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            background: #f8fafc;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .dropzone-area:hover, .dropzone-area.drag-over {
            border-color: #6366f1;
            background: #eef2ff;
        }

        .dropzone-file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .dropzone-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            pointer-events: none;
        }

        .drop-icon { font-size: 38px; color: #6366f1; }

        .drop-text strong { font-size: 15px; color: #1e293b; display: block; }
        .drop-text span { font-size: 13px; color: #64748b; }

        .file-preview-queue {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 14px;
        }

        .preview-thumb {
            width: 85px;
            height: 85px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
        }

        .preview-file-chip {
            padding: 8px 14px;
            background: #f1f5f9;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #334155;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* ATTACHMENTS GRID */
        .attachments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .attachment-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            transition: all 0.25s ease;
        }

        .attachment-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            border-color: #cbd5e1;
        }

        .attachment-preview {
            width: 100%;
            height: 110px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 8px;
            background: #f8fafc;
        }

        .attachment-img-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .attachment-doc-icon { font-size: 42px; }

        .attachment-info {
            text-align: center;
            margin-top: 8px;
            width: 100%;
        }

        .attachment-name {
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .attachment-meta { font-size: 11px; color: #64748b; margin-top: 2px; }

        .attachment-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .attachment-btn-view, .attachment-btn-delete {
            padding: 5px 9px;
            border-radius: 6px;
            font-size: 12px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .attachment-btn-view { background: #e0e7ff; color: #4338ca; }
        .attachment-btn-delete { background: #fee2e2; color: #b91c1c; }


        /* ROW ATTACHMENT THUMBNAILS */
        .row-attachments {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
        }

        .row-attachment-thumb {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #cbd5e1;
        }

        .row-attachment-file { font-size: 16px; }

        .row-attachment-more {
            font-size: 11px;
            font-weight: 700;
            background: #e2e8f0;
            color: #475569;
            padding: 3px 7px;
            border-radius: 10px;
        }


        /* STATUS BADGE BUTTON */
        .status-btn {
            border: none;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .status-btn:hover {
            transform: scale(1.06);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-published { background: #dcfce7; color: #15803d; }
        .status-draft { background: #fef3c7; color: #b45309; }


        /* FORM LAYOUTS */
        .form-group { margin-bottom: 20px; }
        .form-actions { margin-top: 25px; }

        label {
            display: block;
            font-weight: 700;
            color: #334155;
            margin-bottom: 8px;
            font-size: 14.5px;
        }

        input[type="text"], input[type="date"], textarea, select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px;
            background: #ffffff;
            transition: all 0.2s ease;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        }

        textarea { min-height: 130px; resize: vertical; }

        .card {
            background: #f8fafc;
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 15px;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .alert-success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-error { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

        .validation-errors {
            background: #fee2e2;
            color: #b91c1c;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .empty-state { padding: 40px; text-align: center; color: #64748b; background: #f8fafc; border-radius: 12px; }

    </style>

</head>

<body>

    {{-- Floating Toast Notifications Container --}}

    <div id="toast-container" class="toast-container"></div>


    {{-- Main Container --}}

    <div class="container">

        <header class="main-header">

            <h1>⚡ Turbo Laravel Studio</h1>


            <div class="header-actions">

                <button type="button" class="btn btn-activity" onclick="toggleActivityDrawer()">

                    📊 Live Activity Studio

                </button>

            </div>

        </header>


        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-error">

                {{ session('error') }}

            </div>

        @endif


        @if($errors->any())

            <div class="validation-errors">

                <strong>Please fix the following validation errors:</strong>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        @yield('content')

    </div>


    {{-- Sliding Live Activity Feed Drawer --}}

    @include('activities.drawer')


    <script>

        // Toggle Activity Drawer Sidebar
        function toggleActivityDrawer() {
            const drawer = document.getElementById('activity-drawer');
            const backdrop = document.getElementById('drawer-backdrop');
            if (drawer && backdrop) {
                drawer.classList.toggle('active');
                backdrop.classList.toggle('active');
            }
        }


        // Handle Drag & Drop File Selection and Live Preview
        function handleFileSelect(input, postId) {
            const queue = document.getElementById(`file-preview-queue-${postId}`);
            const uploadBtn = document.getElementById(`upload-btn-${postId}`);
            if (!queue) return;

            queue.innerHTML = '';

            if (input.files && input.files.length > 0) {
                Array.from(input.files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        img.className = 'preview-thumb';
                        queue.appendChild(img);
                    } else {
                        const chip = document.createElement('div');
                        chip.className = 'preview-file-chip';
                        chip.innerHTML = `📄 ${file.name}`;
                        queue.appendChild(chip);
                    }
                });

                if (uploadBtn) {
                    uploadBtn.style.display = 'inline-block';
                }
            } else {
                if (uploadBtn) {
                    uploadBtn.style.display = 'none';
                }
            }
        }


        // Setup Drag & Drop hover highlight
        document.addEventListener('DOMContentLoaded', () => {
            setupDragAndDrop();
            autoDismissToasts();
        });

        document.addEventListener('turbo:load', () => {
            setupDragAndDrop();
            autoDismissToasts();
        });


        function setupDragAndDrop() {
            const dropAreas = document.querySelectorAll('.dropzone-area');
            dropAreas.forEach(area => {
                ['dragenter', 'dragover'].forEach(eventName => {
                    area.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        area.classList.add('drag-over');
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    area.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        area.classList.remove('drag-over');
                    }, false);
                });
            });
        }


        // Auto dismiss toast notifications after 4 seconds
        function autoDismissToasts() {
            const observer = new MutationObserver((mutations) => {
                mutations.forEach(mutation => {
                    mutation.addedNodes.forEach(node => {
                        if (node.nodeType === 1 && (node.classList.contains('toast') || node.querySelector('.toast'))) {
                            setTimeout(() => {
                                const toast = node.classList.contains('toast') ? node : node.querySelector('.toast');
                                if (toast) {
                                    toast.style.opacity = '0';
                                    toast.style.transform = 'translateX(100%)';
                                    setTimeout(() => toast.remove(), 350);
                                }
                            }, 4000);
                        }
                    });
                });
            });

            const container = document.getElementById('toast-container');
            if (container) {
                observer.observe(container, { childList: true, subtree: true });
            }
        }

    </script>

</body>

</html>