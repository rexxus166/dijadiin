<x-app-layout>
    {{-- Prism.js: VS Code Dark+ theme + all languages --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.css">
    <style>
        /* ===== Override Prism theme to closer match VS Code Dark+ ===== */
        pre[class*="language-"] {
            background: #1e1e1e !important;
            margin: 0 !important;
            border-radius: 0 !important;
            font-size: 13px !important;
            font-family: 'Consolas', 'JetBrains Mono', 'Fira Code', monospace !important;
            line-height: 1.6 !important;
            tab-size: 4;
        }

        code[class*="language-"] {
            font-family: 'Consolas', 'JetBrains Mono', 'Fira Code', monospace !important;
            font-size: 13px !important;
            line-height: 1.6 !important;
        }

        /* Line numbers */
        .line-numbers .line-numbers-rows {
            border-right: 1px solid #333 !important;
            background: #1e1e1e !important;
            width: 50px !important;
            left: -60px !important;
            top: 0;
            padding-top: 24px;
            padding-bottom: 24px;
            height: calc(100% + 48px);
            margin-top: -24px;
        }

        .line-numbers-rows>span:before {
            color: #858585 !important;
            padding-right: 10px;
        }

        /* ===== Editor overlay layout ===== */
        #editor-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        /* The highlighted pre sits BEHIND the textarea */
        #code-highlight {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            pointer-events: none;
            padding: 24px 24px 24px 70px !important;
            font-family: 'Consolas', 'JetBrains Mono', 'Fira Code', monospace;
            font-size: 13px;
            line-height: 1.6;
            white-space: pre;
            word-wrap: normal;
            box-sizing: border-box;
            background: #1e1e1e;
        }

        /* Transparent textarea sits ON TOP for interaction */
        #code-viewer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 24px 24px 24px 70px !important;
            font-family: 'Consolas', 'JetBrains Mono', 'Fira Code', monospace;
            font-size: 13px;
            line-height: 1.6;
            white-space: pre;
            word-wrap: normal;
            box-sizing: border-box;
            background: transparent;
            color: transparent;
            caret-color: #aeafad;
            border: none;
            outline: none;
            resize: none;
            tab-size: 4;
            overflow: auto;
            z-index: 2;
            spellcheck: false;
        }

        /* Scrollbar style */
        #code-viewer::-webkit-scrollbar,
        #code-highlight::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        #code-viewer::-webkit-scrollbar-track,
        #code-highlight::-webkit-scrollbar-track {
            background: #1e1e1e;
        }

        #code-viewer::-webkit-scrollbar-thumb,
        #code-highlight::-webkit-scrollbar-thumb {
            background: #424242;
            border-radius: 4px;
        }

        #code-viewer::-webkit-scrollbar-thumb:hover,
        #code-highlight::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Tabs styling */
        #editor-tabs::-webkit-scrollbar {
            height: 4px;
        }

        #editor-tabs::-webkit-scrollbar-track {
            background: #1e1e1e;
        }

        #editor-tabs::-webkit-scrollbar-thumb {
            background: #424242;
        }

        /* Auto Save Toggle animation */
        input:checked~.toggle-bg {
            background-color: #4ade80;
        }

        input:checked~.toggle-dot {
            transform: translateX(100%);
        }

        /* ===== Lint Error Banner ===== */
        #lint-error-panel {
            background: #1a1200;
            border-bottom: 1px solid #7c5a00;
            padding: 6px 12px;
            font-family: 'Consolas', 'JetBrains Mono', monospace;
            font-size: 12px;
            line-height: 1.6;
            max-height: 120px;
            overflow-y: auto;
            display: none;
        }

        .lint-error-row {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 2px 0;
            color: #facc15;
        }

        .lint-error-row .lint-line-badge {
            background: #7c5a00;
            color: #fde68a;
            border-radius: 3px;
            padding: 0 5px;
            font-size: 10px;
            white-space: nowrap;
            flex-shrink: 0;
            line-height: 1.7;
        }

        .lint-error-row .lint-msg {
            color: #fde68a;
            word-break: break-all;
        }

        /* File tree items with error — red tint */
        .file-item.has-lint-error {
            color: #f87171 !important;
        }

        .file-item.has-lint-error .lint-badge {
            display: inline-flex;
        }

        .lint-badge {
            display: none;
            align-items: center;
            justify-content: center;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #ef4444;
            color: white;
            font-size: 9px;
            font-weight: 700;
            flex-shrink: 0;
            margin-left: 2px;
        }

        /* ===== Fullscreen Mode ===== */
        body.explorer-fullscreen {
            overflow: hidden;
        }

        body.explorer-fullscreen nav,
        body.explorer-fullscreen header,
        body.explorer-fullscreen aside,
        body.explorer-fullscreen footer,
        body.explorer-fullscreen #mobile-nav,
        body.explorer-fullscreen>div>nav {
            display: none !important;
        }

        body.explorer-fullscreen #explorer-root {
            position: fixed;
            inset: 0;
            z-index: 9999;
            border-radius: 0;
            height: 100vh !important;
            padding: 0 !important;
        }

        body.explorer-fullscreen #explorer-root>div {
            border-radius: 0;
            height: 100vh !important;
        }

        /* Tree file rows */
        .tree-row {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 2px 6px;
            border-radius: 4px;
            cursor: pointer;
            user-select: none;
            font-size: 12.5px;
            white-space: nowrap;
            transition: background 0.1s;
        }

        .tree-row:hover {
            background: rgba(255, 255, 255, 0.06);
        }

        .tree-row.active-file {
            background: rgba(99, 102, 241, 0.25);
        }

        .tree-chevron {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            transition: transform 0.15s;
            color: #6b7280;
        }

        .tree-chevron.open {
            transform: rotate(90deg);
        }

        /* ===== Fullscreen Header Auto-hide ===== */
        :fullscreen header,
        :-webkit-full-screen header,
        :-moz-full-screen header {
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10000;
            transform: translateY(-110%);
            transition: transform 0.22s cubic-bezier(0.4, 0, 0.2, 1),
                box-shadow 0.22s ease;
            will-change: transform;
        }

        :fullscreen header.fs-visible,
        :-webkit-full-screen header.fs-visible,
        :-moz-full-screen header.fs-visible {
            transform: translateY(0);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
        }

        /* Hover trigger strip — strip 8px transparan di atas layar */
        #fs-hover-trigger {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            z-index: 10001;
            cursor: default;
        }

        :fullscreen #fs-hover-trigger,
        :-webkit-full-screen #fs-hover-trigger,
        :-moz-full-screen #fs-hover-trigger {
            display: block;
        }
    </style>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
                {{ $projectName ?? 'Project Explorer' }}
            </h2>
            <div class="flex items-center gap-3">
                <button id="generate-project-btn"
                    class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white text-sm px-4 py-1.5 rounded-lg shadow-lg flex items-center gap-2 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                        </path>
                    </svg>
                    Auto Generate App
                </button>
                <a href="{{ route('project.explorer.download', ['project' => $projectName]) }}"
                    class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm px-4 py-1.5 rounded-lg shadow-lg flex items-center gap-2 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                        </path>
                    </svg>
                    Download Project
                </a>
                <a href="{{ route('project.generator.index') }}"
                    class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 flex items-center gap-1 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard
                </a>
                <!-- Fullscreen Toggle -->
                <button id="fullscreen-btn" title="Full Screen (F11)"
                    class="bg-[#1e1e2e] hover:bg-[#2d2d3f] text-gray-300 hover:text-white text-sm px-3 py-1.5 rounded-lg border border-gray-600 flex items-center gap-2 transition-all">
                    <svg id="fullscreen-icon-expand" class="w-4 h-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                        </path>
                    </svg>
                    <svg id="fullscreen-icon-shrink" class="w-4 h-4 hidden" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25">
                        </path>
                    </svg>
                    <span id="fullscreen-label" class="text-xs font-medium">Fullscreen</span>
                </button>
            </div>
        </div>
    </x-slot>

    {{-- Hover trigger strip: muncul saat fullscreen, gerakkan mouse ke atas untuk tampilkan header --}}
    <div id="fs-hover-trigger"></div>

    <div id="explorer-root" class="py-6 h-[calc(100vh-100px)]">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 h-full">
            <div
                class="bg-white dark:bg-gray-800 shadow-xl border border-gray-200 dark:border-gray-700 sm:rounded-xl overflow-hidden h-full flex flex-col md:flex-row shadow-[0_8px_30px_rgb(0,0,0,0.12)]">

                <!-- LEFT PANE: Directory Tree -->
                <div
                    class="w-full md:w-1/4 lg:w-1/5 bg-gray-50 dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 flex flex-col h-full overflow-hidden shrink-0">
                    <div
                        class="p-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/50 flex justify-between items-center">
                        <span
                            class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Explorer</span>
                        <button id="refresh-tree" class="text-gray-400 hover:text-indigo-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-2" id="file-tree-container">
                        <!-- Loading Tree State -->
                        <div class="flex items-center justify-center h-20 text-indigo-500" id="tree-loading">
                            <svg class="animate-spin h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium">Loading files...</span>
                        </div>

                        <!-- File Tree will be injected here via JS -->
                        <ul id="file-tree-root" class="text-sm font-mono text-gray-700 dark:text-gray-300 space-y-1">
                        </ul>
                    </div>
                </div>

                <!-- MIDDLE PANE: Code Preview -->
                <div class="w-full md:flex-1 flex flex-col h-full bg-[#1e1e1e] border-r border-[#333]">
                    <!-- Editor Header / Tabs -->
                    <div class="bg-[#2d2d2d] flex items-center border-b border-[#1e1e1e] justify-between pr-4 relative">
                        <!-- Left: Scrollable Tabs -->
                        <div id="editor-tabs"
                            class="flex-1 flex overflow-x-auto bg-[#1a1a1a] border-b border-[#2d2d2d] select-none">
                            <!-- Fallback empty state -->
                            <div id="tab-empty-state"
                                class="py-2 px-4 text-[#888888] text-[13px] italic border-t-2 border-transparent">No
                                file open</div>
                        </div>

                        <!-- Right: Auto Save & Controls -->
                        <div class="flex items-center gap-3 shrink-0 ml-4 py-1.5">
                            <label class="flex items-center cursor-pointer group" title="Auto Save edited files">
                                <span
                                    class="text-xs text-gray-400 mr-2 group-hover:text-gray-300 transition-colors font-medium">Auto
                                    Save</span>
                                <div class="relative">
                                    <input type="checkbox" id="auto-save-toggle" class="sr-only" checked>
                                    <div
                                        class="w-8 h-4 bg-gray-600 rounded-full shadow-inner toggle-bg transition-colors duration-200">
                                    </div>
                                    <div
                                        class="toggle-dot absolute w-4 h-4 bg-white rounded-full shadow inset-y-0 left-0 transition-transform duration-200">
                                    </div>
                                </div>
                            </label>

                            <!-- Save status indicator -->
                            <span id="save-status-msg"
                                class="text-[10px] text-gray-500 w-16 text-right transition-opacity duration-300 opacity-0">Saved</span>

                            <!-- Hidden info for Active file, kept for compatibility -->
                            <span id="active-file-name" class="hidden"></span>
                            <input type="hidden" id="active-file-path" value="">

                            <!-- Diff Controls (Hidden by default) -->
                            <div id="diff-controls" class="hidden flex gap-2">
                                <button id="accept-diff"
                                    class="text-xs bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1 rounded">Accept
                                    Changes</button>
                                <button id="reject-diff"
                                    class="text-xs bg-[#444] hover:bg-[#555] text-white px-3 py-1 rounded">Reject</button>
                            </div>
                        </div>
                    </div>

                    {{-- Editor Content Container --}}
                    <div class="flex-1 relative overflow-hidden flex flex-col" id="editor-container">

                        {{-- Lint Error Banner --}}
                        <div id="lint-error-panel">
                            <div class="flex items-center gap-2 mb-1">
                                <svg class="w-3.5 h-3.5 text-yellow-400 shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-yellow-400 font-semibold text-[11px] uppercase tracking-wider">Syntax
                                    Errors Detected</span>
                                <button onclick="document.getElementById('lint-error-panel').style.display='none'"
                                    class="ml-auto text-yellow-600 hover:text-yellow-400 text-xs">✕ Dismiss</button>
                            </div>
                            <div id="lint-error-list"></div>
                        </div>

                        {{-- Original View Edit Panel --}}
                        <div class="flex-1 h-full relative" id="original-view-pane">
                            <div id="editor-wrapper">
                                {{-- Highlighted code (background) --}}
                                <pre id="code-highlight" class="line-numbers"
                                    aria-hidden="true"><code id="code-highlight-inner" class="language-php"></code></pre>
                                {{-- Transparent editable textarea (foreground) --}}
                                <textarea id="code-viewer" spellcheck="false" autocorrect="off" autocapitalize="off"
                                    autocomplete="off" placeholder="Select a file from the explorer..."></textarea>
                            </div>
                        </div>

                        <!-- Diff View (Modified) Hidden -->
                        <div class="w-1/2 h-full bg-[#1e1e1e] border-l border-[#444] hidden relative"
                            id="diff-view-pane">
                            <div class="absolute top-0 right-0 p-1 text-xs text-yellow-500 bg-[#333] rounded-bl">Gemini
                                Suggestion</div>
                            <pre class="w-full h-full p-6 m-0 text-emerald-400 font-mono text-sm overflow-auto"
                                id="diff-viewer"><code></code></pre>
                        </div>

                        <!-- Loading Code Overlay -->
                        <div id="code-loading"
                            class="absolute inset-0 bg-[#1e1e1e]/80 backdrop-blur-sm hidden items-center justify-center flex-col z-10 transition-all duration-300 opacity-0 pointer-events-none">
                            <div
                                class="w-8 h-8 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin">
                            </div>
                            <span class="mt-3 text-sm text-indigo-400 font-mono">Loading content...</span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT PANE: Gemini Agent -->
                <div class="w-full md:w-1/4 lg:w-[300px] flex flex-col h-full bg-white dark:bg-gray-900 shrink-0">
                    <div
                        class="p-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/50 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-12h2v6h-2zm0 8h2v2h-2z" />
                        </svg>
                        <span class="font-bold text-gray-700 dark:text-gray-200">Gemini Builder</span>
                    </div>

                    <div class="flex-1 overflow-y-auto p-4 flex flex-col gap-4" id="chat-history">
                        <!-- Welcome MSG -->
                        <div
                            class="bg-gray-100 dark:bg-gray-800 p-3 rounded-lg text-sm text-gray-700 dark:text-gray-300 shadow-sm border border-gray-200 dark:border-gray-700">
                            Hi! I'm your AI Engineer. Select a file on the left, then tell me what you want to change in
                            it.
                        </div>
                    </div>

                    <div class="p-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <textarea id="chat-input" rows="3"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm p-3 resize-none"
                            placeholder="e.g. Turn this layout into a grid with 3 columns..."></textarea>
                        <button id="chat-send"
                            class="mt-2 w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center gap-2 transition-all">
                            <span>Ask Gemini</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        window.ProjectConfig = {
            projectName: "{{ $projectName ?? '' }}",
            apiTreeUrl: "{{ route('project.explorer.tree', ['project' => $projectName ?? '']) }}",
            apiFileUrl: "{{ route('project.explorer.file', ['project' => $projectName ?? '']) }}",
            apiLintUrl: "{{ route('project.explorer.lint', ['project' => $projectName ?? '']) }}",
            aiPrompt: {!! json_encode($aiPrompt ?? '') !!}
        };

        document.addEventListener('DOMContentLoaded', () => {
            let autoTriggerGenModal = false;
            const sessionKey = 'dijadiin_scaffold_triggered_' + window.ProjectConfig.projectName;
            const treeContainer = document.getElementById('file-tree-root');
            const treeLoading = document.getElementById('tree-loading');
            const codeViewer = document.getElementById('code-viewer');
            const codeHighlight = document.getElementById('code-highlight-inner');
            const codeLoading = document.getElementById('code-loading');
            const activeFileName = document.getElementById('active-file-name');
            const editorTabsContainer = document.getElementById('editor-tabs');
            const autoSaveToggle = document.getElementById('auto-save-toggle');
            const saveStatusMsg = document.getElementById('save-status-msg');
            let currentLanguage = 'plaintext';
            const lintErrorPanel = document.getElementById('lint-error-panel');
            const lintErrorList = document.getElementById('lint-error-list');

            // ===== Fullscreen Toggle (Native Browser Fullscreen API) =====
            const fullscreenBtn = document.getElementById('fullscreen-btn');
            const fsIconExpand = document.getElementById('fullscreen-icon-expand');
            const fsIconShrink = document.getElementById('fullscreen-icon-shrink');
            const fsLabel = document.getElementById('fullscreen-label');

            function enterFullscreen() {
                const el = document.documentElement;
                if (el.requestFullscreen) el.requestFullscreen();
                else if (el.webkitRequestFullscreen) el.webkitRequestFullscreen();
                else if (el.mozRequestFullScreen) el.mozRequestFullScreen();
                else if (el.msRequestFullscreen) el.msRequestFullscreen();
            }

            function exitFullscreen() {
                if (document.exitFullscreen) document.exitFullscreen();
                else if (document.webkitExitFullscreen) document.webkitExitFullscreen();
                else if (document.mozCancelFullScreen) document.mozCancelFullScreen();
                else if (document.msExitFullscreen) document.msExitFullscreen();
            }

            function updateFsUI(isFs) {
                fsIconExpand.classList.toggle('hidden', isFs);
                fsIconShrink.classList.toggle('hidden', !isFs);
                fsLabel.textContent = isFs ? 'Exit Fullscreen' : 'Fullscreen';
            }

            fullscreenBtn?.addEventListener('click', () => {
                !!document.fullscreenElement ? exitFullscreen() : enterFullscreen();
            });

            // ── Header auto-hide dalam fullscreen ──────────────────────────────
            const fsAppHeader = document.querySelector('header');
            const fsHoverTrigger = document.getElementById('fs-hover-trigger');
            let fsHeaderTimer = null;

            // Siapkan transition style sekali
            if (fsAppHeader) {
                fsAppHeader.style.transition = 'transform 0.22s cubic-bezier(0.4,0,0.2,1), box-shadow 0.22s ease';
                fsAppHeader.style.willChange = 'transform';
            }

            function showFsHeader() {
                if (!fsAppHeader) return;
                fsAppHeader.style.transform = 'translateY(0)';
                fsAppHeader.style.boxShadow = '0 8px 32px rgba(0,0,0,0.6)';
                clearTimeout(fsHeaderTimer);
                fsHeaderTimer = setTimeout(hideFsHeader, 2500);
            }

            function hideFsHeader() {
                if (!fsAppHeader) return;
                fsAppHeader.style.transform = 'translateY(-110%)';
                fsAppHeader.style.boxShadow = '';
                clearTimeout(fsHeaderTimer);
            }


            function applyFullscreenHeader(isFs) {
                if (!fsAppHeader) return;

                // Elemen layout yang perlu di-adjust
                const explorerRoot = document.getElementById('explorer-root');
                const innerWrap = explorerRoot?.firstElementChild;          // max-w-8xl div
                const editorPanel = innerWrap?.firstElementChild;             // the card flex row

                if (isFs) {
                    // ── Header: position fixed, siap untuk slide ke atas ──
                    fsAppHeader.style.position = 'fixed';
                    fsAppHeader.style.top = '0';
                    fsAppHeader.style.left = '0';
                    fsAppHeader.style.right = '0';
                    fsAppHeader.style.zIndex = '10000';
                    // Tunda agar browser sempat paint, lalu slide ke atas
                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => hideFsHeader());
                    });
                    if (fsHoverTrigger) fsHoverTrigger.style.display = 'block';

                    // ── Sidebar: sembunyikan ──
                    document.querySelectorAll('nav, aside').forEach(el => {
                        el.dataset.fsDisplay = el.style.display || '';
                        el.style.display = 'none';
                    });

                    // ── Explorer root: fixed full viewport ──
                    if (explorerRoot) {
                        explorerRoot.style.position = 'fixed';
                        explorerRoot.style.inset = '0';
                        explorerRoot.style.height = '100vh';
                        explorerRoot.style.padding = '0';
                        explorerRoot.style.zIndex = '9000';
                    }
                    if (innerWrap) {
                        innerWrap.style.height = '100%';
                        innerWrap.style.maxWidth = 'none';
                        innerWrap.style.padding = '0';
                        innerWrap.style.margin = '0';
                    }
                    if (editorPanel) {
                        editorPanel.style.height = '100%';
                        editorPanel.style.borderRadius = '0';
                        editorPanel.style.border = 'none';
                    }

                } else {
                    // ── Reset semua ──
                    clearTimeout(fsHeaderTimer);
                    fsAppHeader.style.position = '';
                    fsAppHeader.style.top = '';
                    fsAppHeader.style.left = '';
                    fsAppHeader.style.right = '';
                    fsAppHeader.style.zIndex = '';
                    fsAppHeader.style.transform = '';
                    fsAppHeader.style.boxShadow = '';
                    if (fsHoverTrigger) fsHoverTrigger.style.display = 'none';

                    if (explorerRoot) {
                        explorerRoot.style.position = '';
                        explorerRoot.style.inset = '';
                        explorerRoot.style.height = '';
                        explorerRoot.style.padding = '';
                        explorerRoot.style.zIndex = '';
                    }
                    if (innerWrap) {
                        innerWrap.style.height = '';
                        innerWrap.style.maxWidth = '';
                        innerWrap.style.padding = '';
                        innerWrap.style.margin = '';
                    }
                    if (editorPanel) {
                        editorPanel.style.height = '';
                        editorPanel.style.borderRadius = '';
                        editorPanel.style.border = '';
                    }

                    // ── Sidebar: tampilkan kembali ──
                    document.querySelectorAll('nav, aside').forEach(el => {
                        el.style.display = el.dataset.fsDisplay || '';
                        delete el.dataset.fsDisplay;
                    });
                }
            }

            // Mouse masuk hover strip → tampilkan header
            fsHoverTrigger?.addEventListener('mouseenter', showFsHeader);

            // Mouse di atas header → batalkan auto-hide timer
            fsAppHeader?.addEventListener('mouseenter', () => {
                clearTimeout(fsHeaderTimer);
                showFsHeader();
            });

            // Mouse keluar header → hide setelah 500ms
            fsAppHeader?.addEventListener('mouseleave', () => {
                clearTimeout(fsHeaderTimer);
                fsHeaderTimer = setTimeout(hideFsHeader, 500);
            });

            ['fullscreenchange', 'webkitfullscreenchange', 'mozfullscreenchange'].forEach(ev => {
                document.addEventListener(ev, () => {
                    const isFs = !!(document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement);
                    updateFsUI(isFs);
                    applyFullscreenHeader(isFs);
                });
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'F11') {
                    e.preventDefault();
                    !!document.fullscreenElement ? exitFullscreen() : enterFullscreen();
                }
            });

            // ===== Colorful Folder Icons by name =====
            function getFolderIcon(name) {
                const n = name.toLowerCase();
                const colors = {
                    'app': ['#60a5fa', '#3b82f6'],  // blue
                    'controllers': ['#818cf8', '#6366f1'],  // indigo
                    'models': ['#4ade80', '#22c55e'],  // green
                    'views': ['#f472b6', '#ec4899'],  // pink
                    'routes': ['#fb923c', '#f97316'],  // orange
                    'database': ['#a78bfa', '#8b5cf6'],  // purple
                    'migrations': ['#c084fc', '#a855f7'],  // violet
                    'seeders': ['#86efac', '#4ade80'],  // light green
                    'public': ['#67e8f9', '#22d3ee'],  // cyan
                    'storage': ['#fcd34d', '#f59e0b'],  // amber
                    'resources': ['#f9a8d4', '#f472b6'],  // rose
                    'config': ['#94a3b8', '#64748b'],  // slate
                    'lang': ['#fde68a', '#fbbf24'],  // yellow
                    'tests': ['#6ee7b7', '#34d399'],  // emerald
                    'bootstrap': ['#fca5a1', '#f87171'],  // red
                    'vendor': ['#9ca3af', '#6b7280'],  // gray
                    'node_modules': ['#6b7280', '#4b5563'],  // dark gray
                    'js': ['#fde68a', '#f59e0b'],  // yellow
                    'css': ['#93c5fd', '#3b82f6'],  // blue
                    'images': ['#86efac', '#22c55e'],  // green
                    'http': ['#fb923c', '#f97316'],  // orange
                    'middleware': ['#c4b5fd', '#a78bfa'],  // purple
                    'requests': ['#fda4af', '#fb7185'],  // rose
                    'services': ['#67e8f9', '#06b6d4'],  // cyan
                    'providers': ['#a5b4fc', '#818cf8'],  // indigo
                    'console': ['#6ee7b7', '#10b981'],  // emerald
                    'exceptions': ['#fca5a1', '#ef4444'],  // red
                    'mail': ['#fde68a', '#f59e0b'],  // yellow
                    'events': ['#c084fc', '#9333ea'],  // purple
                    'listeners': ['#86efac', '#16a34a'],  // green
                    'jobs': ['#fb923c', '#ea580c'],  // orange
                    'factories': ['#a78bfa', '#7c3aed'],  // violet
                    'policies': ['#fda4af', '#e11d48'],  // rose
                    'helpers': ['#7dd3fc', '#0284c7'],  // light blue
                    'traits': ['#bfdbfe', '#2563eb'],  // blue
                    'interfaces': ['#d9f99d', '#65a30d'],  // lime
                    'components': ['#fed7aa', '#f97316'],  // orange
                    'layouts': ['#fce7f3', '#db2777'],  // pink
                    'partials': ['#e9d5ff', '#7c3aed'],  // purple
                    'pages': ['#cffafe', '#0891b2'],  // cyan
                    'page': ['#cffafe', '#0891b2'],  // cyan
                    'api': ['#dcfce7', '#16a34a'],  // green
                    'auth': ['#fee2e2', '#dc2626'],  // red
                };
                const [topColor, botColor] = colors[n] || ['#6b7280', '#4b5563'];
                return `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0">
                    <path d="M2 6a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" fill="${topColor}"/>
                    <path d="M2 9h20v8a2 2 0 01-2 2H4a2 2 0 01-2-2V9z" fill="${botColor}"/>
                </svg>`;
            }

            // ===== File Icons by extension =====
            function getFileIcon(filename) {
                const lower = filename.toLowerCase();
                const ext = lower.split('.').pop();

                // Detect blade.php
                if (lower.endsWith('.blade.php')) {
                    return `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#ff2d20"/><text x="4" y="22" font-size="11" fill="white" font-family="monospace" font-weight="bold">BL</text></svg>`;
                }

                const icons = {
                    // PHP
                    'php': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#4F5B93"/><text x="4" y="22" font-size="11" fill="white" font-family="monospace" font-weight="bold">PHP</text></svg>`,
                    // JS
                    'js': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#f7df1e"/><text x="5" y="22" font-size="11" fill="#000" font-family="monospace" font-weight="bold">JS</text></svg>`,
                    'mjs': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#f7df1e"/><text x="3" y="22" font-size="10" fill="#000" font-family="monospace" font-weight="bold">MJS</text></svg>`,
                    // TS
                    'ts': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#3178c6"/><text x="5" y="22" font-size="11" fill="white" font-family="monospace" font-weight="bold">TS</text></svg>`,
                    // CSS
                    'css': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#2965f1"/><text x="3" y="22" font-size="11" fill="white" font-family="monospace" font-weight="bold">CSS</text></svg>`,
                    'scss': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#cc6699"/><text x="2" y="22" font-size="10" fill="white" font-family="monospace" font-weight="bold">SCSS</text></svg>`,
                    // HTML
                    'html': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#e44d26"/><text x="2" y="22" font-size="10" fill="white" font-family="monospace" font-weight="bold">HTM</text></svg>`,
                    'htm': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#e44d26"/><text x="2" y="22" font-size="10" fill="white" font-family="monospace" font-weight="bold">HTM</text></svg>`,
                    // JSON
                    'json': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#fbbf24"/><text x="2" y="22" font-size="9" fill="#1a1a1a" font-family="monospace" font-weight="bold">JSON</text></svg>`,
                    // MD
                    'md': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#083fa1"/><text x="5" y="22" font-size="11" fill="white" font-family="monospace" font-weight="bold">MD</text></svg>`,
                    // SQL
                    'sql': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#00758f"/><text x="3" y="22" font-size="10" fill="white" font-family="monospace" font-weight="bold">SQL</text></svg>`,
                    // YAML
                    'yaml': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#cb171e"/><text x="2" y="22" font-size="9" fill="white" font-family="monospace" font-weight="bold">YAML</text></svg>`,
                    'yml': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#cb171e"/><text x="3" y="22" font-size="10" fill="white" font-family="monospace" font-weight="bold">YML</text></svg>`,
                    // ENV
                    'env': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#ecd53f"/><text x="2" y="22" font-size="9" fill="#1a1a1a" font-family="monospace" font-weight="bold">ENV</text></svg>`,
                    // Bash / sh
                    'sh': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#4eaa25"/><text x="5" y="22" font-size="11" fill="white" font-family="monospace" font-weight="bold">SH</text></svg>`,
                    // Vue
                    'vue': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#41b883"/><text x="3" y="22" font-size="10" fill="white" font-family="monospace" font-weight="bold">VUE</text></svg>`,
                    // XML / SVG
                    'xml': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#f16529"/><text x="2" y="22" font-size="10" fill="white" font-family="monospace" font-weight="bold">XML</text></svg>`,
                    'svg': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#ffb13b"/><text x="3" y="22" font-size="10" fill="#1a1a1a" font-family="monospace" font-weight="bold">SVG</text></svg>`,
                    // Images
                    'png': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#10b981"/><text x="3" y="22" font-size="10" fill="white" font-family="monospace" font-weight="bold">IMG</text></svg>`,
                    'jpg': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#10b981"/><text x="3" y="22" font-size="10" fill="white" font-family="monospace" font-weight="bold">IMG</text></svg>`,
                    'gif': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#10b981"/><text x="3" y="22" font-size="10" fill="white" font-family="monospace" font-weight="bold">GIF</text></svg>`,
                    // Lock / gitignore
                    'lock': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#6b7280"/><text x="2" y="22" font-size="9" fill="white" font-family="monospace" font-weight="bold">LOCK</text></svg>`,
                    'txt': `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#6b7280"/><text x="3" y="22" font-size="10" fill="white" font-family="monospace" font-weight="bold">TXT</text></svg>`,
                };

                return icons[ext] || `<svg width="15" height="15" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect width="32" height="32" rx="4" fill="#374151"/><text x="5" y="22" font-size="11" fill="#9ca3af" font-family="monospace">\u2609</text></svg>`;
            }


            // ── Per-file lint error state ────────────────────────────────
            const lintErrors = {}; // { path: [{line, message}, ...] }

            function lintFile(path) {
                const url = window.ProjectConfig.apiLintUrl + `?path=${encodeURIComponent(path)}`;
                fetch(url)
                    .then(r => r.json())
                    .then(data => {
                        lintErrors[path] = data.errors || [];
                        renderLintPanel(path);
                        // Update tree node appearance
                        const treeEl = document.querySelector(`.file-item[data-path="${CSS.escape(path)}"]`);
                        if (treeEl) {
                            if (lintErrors[path].length > 0) {
                                treeEl.classList.add('has-lint-error');
                                const badge = treeEl.querySelector('.lint-badge');
                                if (badge) badge.textContent = lintErrors[path].length > 9 ? '!' : lintErrors[path].length;
                            } else {
                                treeEl.classList.remove('has-lint-error');
                                const badge = treeEl.querySelector('.lint-badge');
                                if (badge) badge.textContent = '';
                            }
                        }
                        // Re-render tab
                        const tabEl = document.getElementById(`tab-${path}`);
                        if (tabEl) {
                            const nameSpan = tabEl.querySelector('span');
                            if (nameSpan) {
                                nameSpan.style.color = lintErrors[path].length > 0 ? '#f87171' : '';
                            }
                        }
                    })
                    .catch(() => { }); // silent fail
            }

            function renderLintPanel(path) {
                const errs = lintErrors[path] || [];
                if (errs.length === 0) {
                    lintErrorPanel.style.display = 'none';
                    lintErrorList.innerHTML = '';
                    return;
                }
                lintErrorPanel.style.display = 'block';
                lintErrorList.innerHTML = errs.map(e => `
                    <div class="lint-error-row">
                        ${e.line ? `<span class="lint-line-badge">Line ${e.line}</span>` : `<span class="lint-line-badge">—</span>`}
                        <span class="lint-msg">${e.message.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</span>
                    </div>
                `).join('');
            }

            // State management
            let openFiles = []; // Array of {path, name, content}
            let activeFilePath = null;
            let autoSaveTimeout = null;

            // ===== Detect language from filename extension =====
            function detectLanguage(filename) {
                const ext = filename.split('.').pop().toLowerCase();
                const map = {
                    'php': 'php', 'blade.php': 'php',
                    'js': 'javascript', 'mjs': 'javascript', 'cjs': 'javascript',
                    'ts': 'typescript',
                    'json': 'json', 'jsonc': 'json',
                    'css': 'css', 'scss': 'scss', 'sass': 'scss',
                    'html': 'markup', 'htm': 'markup', 'xml': 'markup', 'svg': 'markup',
                    'md': 'markdown', 'markdown': 'markdown',
                    'sh': 'bash', 'bash': 'bash', 'zsh': 'bash',
                    'sql': 'sql',
                    'yaml': 'yaml', 'yml': 'yaml',
                    'env': 'bash', 'gitignore': 'bash',
                    'vue': 'markup', 'jsx': 'jsx', 'tsx': 'typescript',
                };
                // Check for blade specifically
                if (filename.endsWith('.blade.php')) return 'markup';
                return map[ext] || 'plaintext';
            }

            // ===== Sync highlighting with textarea =====
            function updateHighlight(code, filename) {
                const lang = detectLanguage(filename || 'file.php');
                currentLanguage = lang;
                codeHighlight.className = `language-${lang}`;
                // Escape HTML entities
                const escaped = code
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;');
                codeHighlight.innerHTML = escaped;
                Prism.highlightElement(codeHighlight);
            }

            // ===== Sync scroll between textarea and pre =====
            codeViewer.addEventListener('scroll', () => {
                document.getElementById('code-highlight').scrollTop = codeViewer.scrollTop;
                document.getElementById('code-highlight').scrollLeft = codeViewer.scrollLeft;
            });

            // ===== Re-highlight & Auto Save on input =====
            codeViewer.addEventListener('input', () => {
                updateHighlight(codeViewer.value, activeFileName.textContent);

                // Update current buffer
                if (activeFilePath) {
                    const fileObj = openFiles.find(f => f.path === activeFilePath);
                    if (fileObj) {
                        fileObj.content = codeViewer.value;

                        // Tab dot un-saved indicator
                        const tabEl = document.getElementById(`tab-${activeFilePath}`);
                        if (tabEl) {
                            tabEl.querySelector('.save-dot').classList.remove('opacity-0');
                        }

                        // Trigger auto save if enabled
                        if (autoSaveToggle.checked) {
                            scheduleAutoSave(activeFilePath);
                        }
                    }
                }
            });

            if (!window.ProjectConfig.projectName) return;

            function loadTree() {
                treeLoading.style.display = 'flex';
                treeContainer.innerHTML = '';

                fetch(window.ProjectConfig.apiTreeUrl)
                    .then(res => res.json())
                    .then(data => {
                        treeLoading.style.display = 'none';
                        if (data.error) {
                            treeContainer.innerHTML = `<li class="text-red-500 bg-red-100 p-2 rounded">${data.error}</li>`;
                            return;
                        }
                        treeContainer.appendChild(buildTreeDom(data));

                        // Auto-trigger Gen Modal
                        if (autoTriggerGenModal) {
                            autoTriggerGenModal = false;
                            setTimeout(() => {
                                document.getElementById('generate-project-btn').click();
                                setTimeout(() => {
                                    document.getElementById('start-generate-btn').click();
                                }, 500);
                            }, 500);
                        }
                    })
                    .catch(e => {
                        treeLoading.style.display = 'none';
                        treeContainer.innerHTML = `<li class="text-red-500 bg-red-100 p-2 rounded">Failed to load tree.</li>`;
                    });
            }

            function buildTreeDom(items) {
                const ul = document.createElement('ul');
                ul.className = 'pl-4 space-y-1';

                items.forEach(item => {
                    const li = document.createElement('li');

                    if (item.type === 'directory') {
                        const chevron = `<svg class="tree-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>`;
                        const folderIcon = getFolderIcon(item.name);

                        const rowDiv = document.createElement('div');
                        rowDiv.className = 'tree-row';
                        rowDiv.innerHTML = `${chevron}${folderIcon}<span class="text-gray-300 font-medium">${item.name}</span>`;

                        const childrenUl = buildTreeDom(item.children);
                        childrenUl.style.display = 'none';
                        childrenUl.classList.add('pl-3', 'border-l', 'border-[#2d2d2d]', 'ml-2');

                        rowDiv.addEventListener('click', (e) => {
                            e.stopPropagation();
                            const isOpen = childrenUl.style.display !== 'none';
                            childrenUl.style.display = isOpen ? 'none' : 'block';
                            rowDiv.querySelector('.tree-chevron').classList.toggle('open', !isOpen);
                        });

                        li.appendChild(rowDiv);
                        li.appendChild(childrenUl);
                    } else {
                        // File HTML
                        const fileIcon = getFileIcon(item.name);
                        const rowDiv = document.createElement('div');
                        rowDiv.className = 'tree-row file-item';
                        rowDiv.dataset.path = item.path;
                        rowDiv.innerHTML = `${fileIcon}<span class="truncate text-[#cccccc]" style="max-width:120px">${item.name}</span><span class="lint-badge" title="Syntax errors">!</span>`;

                        rowDiv.addEventListener('click', (e) => {
                            e.stopPropagation();
                            document.querySelectorAll('.file-item').forEach(el => el.classList.remove('active-file'));
                            rowDiv.classList.add('active-file');
                            loadFile(item.path, item.name);
                        });

                        li.appendChild(rowDiv);
                    }

                    ul.appendChild(li);
                });
                return ul;
            }

            function renderTabs() {
                editorTabsContainer.innerHTML = '';
                if (openFiles.length === 0) {
                    editorTabsContainer.innerHTML = `<div id="tab-empty-state" class="py-2 px-4 text-[#888888] text-[13px] italic border-t-2 border-transparent">No file open</div>`;
                    codeViewer.value = '';
                    updateHighlight('', 'blank.txt');
                    activeFilePath = null;
                    document.getElementById('active-file-path').value = '';
                    activeFileName.textContent = '';
                    return;
                }

                openFiles.forEach(fileObj => {
                    const isActive = fileObj.path === activeFilePath;
                    const tab = document.createElement('div');
                    tab.id = `tab-${fileObj.path}`;
                    tab.className = `px-3 py-1.5 flex items-center gap-2 cursor-pointer border-t-2 transition-colors duration-150 min-w-max group
                        ${isActive ? 'border-indigo-500 bg-[#1e1e1e] text-white' : 'border-transparent bg-[#141414] text-[#888] hover:bg-[#1a1a1a] hover:text-[#ccc]'}`;

                    // Tab content inner HTML
                    tab.innerHTML = `
                        <svg class="w-3.5 h-3.5 ${isActive ? 'text-emerald-400' : 'text-gray-500'} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-[12px] truncate max-w-[150px]">${fileObj.name}</span>
                        <div class="h-2 w-2 rounded-full bg-white opacity-0 transition-opacity save-dot shrink-0" title="Unsaved changes"></div>
                        <button type="button" class="ml-1 text-gray-500 hover:text-red-400 hover:bg-gray-700/50 rounded p-0.5 shrink-0 close-tab-btn opacity-0 group-hover:opacity-100 transition-opacity ${isActive ? 'opacity-100' : ''}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    `;

                    // Select tab
                    tab.addEventListener('click', (e) => {
                        if (e.target.closest('.close-tab-btn')) return; // Ignore close clicks
                        switchTab(fileObj.path);
                    });

                    // Close tab
                    tab.querySelector('.close-tab-btn').addEventListener('click', (e) => {
                        e.stopPropagation();
                        closeTab(fileObj.path);
                    });

                    editorTabsContainer.appendChild(tab);
                });
            }

            function switchTab(path) {
                // If switching away, could do something. But state is already saved on input.
                activeFilePath = path;
                const fileObj = openFiles.find(f => f.path === path);

                document.getElementById('active-file-path').value = path;
                activeFileName.textContent = fileObj.name;

                codeViewer.value = fileObj.content;
                updateHighlight(fileObj.content, fileObj.name);

                renderTabs(); // visually update active tab

                // Show lint panel for this tab (from cached state)
                renderLintPanel(path);
            }

            function closeTab(path) {
                const idx = openFiles.findIndex(f => f.path === path);
                if (idx === -1) return;

                // Fire a final manual save before closing just in case
                if (autoSaveToggle.checked) {
                    saveFileContent(path, openFiles[idx].content);
                }

                openFiles.splice(idx, 1);

                if (openFiles.length === 0) {
                    activeFilePath = null;
                } else if (activeFilePath === path) {
                    // Closed active tab, switch to another
                    const nextIdx = idx >= openFiles.length ? openFiles.length - 1 : idx;
                    activeFilePath = openFiles[nextIdx].path;
                }

                if (activeFilePath) switchTab(activeFilePath);
                else renderTabs(); // triggers empty state
            }

            function loadFile(path, name) {
                // Check if already open
                if (openFiles.some(f => f.path === path)) {
                    switchTab(path);
                    return;
                }

                codeLoading.style.display = 'flex';
                // Hide diff view if it was open
                document.getElementById('diff-view-pane').classList.add('hidden');
                document.getElementById('diff-controls').classList.add('hidden');

                const url = window.ProjectConfig.apiFileUrl + `?path=${encodeURIComponent(path)}`;

                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        codeLoading.style.display = 'none';
                        if (data.error) {
                            codeViewer.value = `Error: ${data.error}`;
                            updateHighlight(`Error: ${data.error}`, 'error.txt');
                            autoTriggerGemini = false;
                        } else {
                            openFiles.push({
                                path: path,
                                name: name,
                                content: data.content
                            });
                            switchTab(path);
                            // Run lint check after file is loaded
                            lintFile(path);
                        }
                    })
                    .catch((err) => {
                        console.error(err);
                        codeLoading.style.display = 'none';
                        alert(`Error failed to fetch file`);
                    });
            }

            function showSaveStatus(text, colorClass = 'text-gray-500') {
                saveStatusMsg.textContent = text;
                saveStatusMsg.className = `text-[10px] w-16 text-right transition-opacity duration-300 opacity-100 ${colorClass}`;
                setTimeout(() => {
                    saveStatusMsg.classList.remove('opacity-100');
                    saveStatusMsg.classList.add('opacity-0');
                }, 2000);
            }

            function scheduleAutoSave(path) {
                if (autoSaveTimeout) clearTimeout(autoSaveTimeout);

                // Set pending visually
                saveStatusMsg.textContent = 'Saving...';
                saveStatusMsg.className = "text-[10px] text-gray-400 w-16 text-right opacity-100";

                autoSaveTimeout = setTimeout(() => {
                    const contentObj = openFiles.find(f => f.path === path);
                    if (contentObj) {
                        saveFileContent(path, contentObj.content, true);
                    }
                }, 1000);
            }

            function saveFileContent(path, content, isAuto = false) {
                if (!path) return;

                if (!isAuto) showSaveStatus('Saving...');

                fetch(`/ai-builder/explorer/${window.ProjectConfig.projectName}/save-file`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ path, content: content })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showSaveStatus('Saved', 'text-emerald-400');
                            // Remove dirty dot from tab
                            const tabEl = document.getElementById(`tab-${path}`);
                            if (tabEl) {
                                const dot = tabEl.querySelector('.save-dot');
                                if (dot) dot.classList.add('opacity-0');
                            }
                        } else {
                            showSaveStatus('Error', 'text-red-400');
                        }
                    })
                    .catch(() => showSaveStatus('Fail', 'text-red-400'));
            }

            // Ctrl+S functionality
            document.addEventListener('keydown', function (e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    if (activeFilePath) {
                        const contentObj = openFiles.find(f => f.path === activeFilePath);
                        if (contentObj) {
                            saveFileContent(activeFilePath, contentObj.content, false);
                        }
                    }
                }
            });

            // Prevent Tab key from leaving the textarea natively, and indent instead
            codeViewer.addEventListener('keydown', function (e) {
                if (e.key == 'Tab') {
                    e.preventDefault();
                    var start = this.selectionStart;
                    var end = this.selectionEnd;
                    this.value = this.value.substring(0, start) + "\t" + this.value.substring(end);
                    this.selectionStart = this.selectionEnd = start + 1;
                }
            });

            document.getElementById('refresh-tree').addEventListener('click', loadTree);

            // Gemini Integration Logic
            const chatSendBtn = document.getElementById('chat-send');
            const chatInput = document.getElementById('chat-input');
            const chatHistory = document.getElementById('chat-history');

            function addChatMessage(role, text) {
                const div = document.createElement('div');
                div.className = `p-3 rounded-lg text-sm shadow-sm border ${role === 'user' ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-200 dark:border-indigo-800 ml-4' : 'bg-gray-100 dark:bg-gray-800 border-gray-200 dark:border-gray-700 mr-4'}`;
                div.textContent = text;
                chatHistory.appendChild(div);
                chatHistory.scrollTop = chatHistory.scrollHeight;
                return div;
            }

            function setDiffMode(newCode) {
                const diffPane = document.getElementById('diff-view-pane');
                const diffViewer = document.getElementById('diff-viewer');
                const diffControls = document.getElementById('diff-controls');

                const newBlock = document.createElement('code');
                newBlock.textContent = newCode;
                diffViewer.innerHTML = '';
                diffViewer.appendChild(newBlock);

                diffPane.classList.remove('hidden');
                diffControls.classList.remove('hidden');
            }

            chatInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    chatSendBtn.click();
                }
            });

            chatSendBtn.addEventListener('click', () => {
                const prompt = chatInput.value.trim();
                const path = document.getElementById('active-file-path').value;
                const currentContent = codeViewer.value;

                if (!prompt) return;

                addChatMessage('user', prompt);
                chatInput.value = '';
                const loadMsg = addChatMessage('bot', 'Thinking...');
                loadMsg.classList.add('animate-pulse');

                fetch('/ai-builder/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        prompt,
                        file_content: currentContent,
                        project: window.ProjectConfig.projectName
                    })
                })
                    .then(async res => {
                        if (!res.ok && res.status !== 422 && res.status !== 500) {
                            throw new Error('Network response was not ok');
                        }
                        return res.json();
                    })
                    .then(data => {
                        loadMsg.remove();
                        if (data.errors) {
                            let msgs = Object.values(data.errors).flat().join(' ');
                            addChatMessage('bot', `Peringatan: ${msgs}`);
                        } else if (data.error) {
                            addChatMessage('bot', `Error: ${data.error}`);
                        } else if (data.success && data.files) {
                            addChatMessage('bot', `I have successfully applied the changes. ${data.message || ''}`);

                            // Re-load the tree to pick up any newly generated files
                            loadTree();

                            // Update active editor buffers if affected
                            let affectedActive = false;

                            data.files.forEach(f => {
                                // If this file is currently open in a tab, update the buffer
                                const existingTab = openFiles.find(tabFile => tabFile.path === f.path);
                                if (existingTab) {
                                    existingTab.content = f.content;
                                    // Remove unsaved dot since AI just saved it strictly to disk
                                    const dot = document.getElementById(`tab-${f.path}`)?.querySelector('.save-dot');
                                    if (dot) dot.classList.add('opacity-0');
                                }

                                // If it's the specific file currently in view
                                if (activeFilePath === f.path) {
                                    codeViewer.value = f.content;
                                    updateHighlight(f.content, activeFileName.textContent);
                                    affectedActive = true;
                                }
                            });

                            // If they just created new files but weren't looking at them, we could optionally open the first one
                            // Check if current file was one of the edited
                            if (!affectedActive && data.files.length > 0) {
                                // Just visual hint that files were saved
                            }

                        } else {
                            addChatMessage('bot', `I couldn't process the files correctly. Please try again!`);
                        }
                    })
                    .catch((err) => {
                        loadMsg.remove();
                        addChatMessage('bot', `Communication failed: ${err.message || 'Unknown error'}`);
                    });
            });

            // Initial load
            loadTree();
        });
    </script>

    <!-- Project Generation Modal -->
    <div id="generate-modal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center">
        <div class="bg-gray-900 border border-gray-700 rounded-2xl w-full max-w-2xl p-6 shadow-2xl relative">
            <button id="close-modal-btn" class="absolute top-4 right-4 text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <h3 class="text-xl font-bold text-white mb-2 flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                    </path>
                </svg>
                AI Project Architect
            </h3>
            <p class="text-gray-400 text-sm mb-6">Ceritakan fitur apa saja yang ingin kamu buat. Gemini akan
                meng-generate file Migration, Controller, Views (Blade), dan Routes secara otomatis.</p>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Nama Aplikasi / Konsep</label>
                    <input type="text" id="app-concept"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg text-white px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="e.g. Sistem Manajemen Gudang" value="{{ $projectDescription ?? '' }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Daftar Fitur Utama (AI Prompt)</label>
                    <textarea id="app-features" rows="4"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg text-white px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="e.g. 
- CRUD Barang (Nama, Deskripsi, Harga, Stok)
- CRUD Kategori (Nama)
- Relasi Barang belongsTo Kategori">{{ $aiPrompt ?? '' }}</textarea>
                </div>
                <div class="pt-2">
                    <button id="start-generate-btn"
                        class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold py-3 rounded-xl shadow-lg transition-all flex justify-center items-center gap-2">
                        <span>Mulai Generate File Setup</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Generation Progress (Hidden initially) -->
            <div id="generation-progress"
                class="hidden mt-6 bg-black/30 rounded-lg p-4 font-mono text-xs text-emerald-400 h-48 overflow-y-auto">
                <div>> Architect engine initialized...</div>
            </div>
        </div>
    </div>

    {{-- Prism.js core + autoloader (all languages) + line-numbers plugin --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
    <script>
        // Set autoloader path so all language grammars are loaded on demand
        if (typeof Prism !== 'undefined' && Prism.plugins?.autoloader) {
            Prism.plugins.autoloader.languages_path = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/';
        }

        // Generation Modal Logic
        const genModal = document.getElementById('generate-modal');
        const openModalBtn = document.getElementById('generate-project-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const startGenBtn = document.getElementById('start-generate-btn');
        const progressBox = document.getElementById('generation-progress');
        let genEventSource = null;

        openModalBtn.addEventListener('click', () => {
            genModal.classList.remove('hidden');
        });

        closeModalBtn.addEventListener('click', () => {
            genModal.classList.add('hidden');
            if (genEventSource) {
                genEventSource.close();
            }
        });

        function addLog(text, color = 'text-emerald-400') {
            const div = document.createElement('div');
            div.className = `mt-1 ${color}`;
            div.textContent = `> ${text}`;
            progressBox.appendChild(div);
            progressBox.scrollTop = progressBox.scrollHeight;
        }

        startGenBtn.addEventListener('click', () => {
            const concept = document.getElementById('app-concept').value.trim();
            const features = document.getElementById('app-features').value.trim();

            if (!concept || !features) {
                alert('Tolong isi nama aplikasi dan fitur-fiturnya!');
                return;
            }

            // Disable UI
            startGenBtn.disabled = true;
            startGenBtn.classList.add('opacity-50', 'cursor-not-allowed');
            startGenBtn.querySelector('span').textContent = 'Generating... Please Wait';

            progressBox.classList.remove('hidden');
            progressBox.innerHTML = '';
            addLog(`Memulai AI Architect Pipeline untuk "${concept}"...`, 'text-blue-400 font-bold');

            const payload = {
                concept: concept,
                features: features,
                project: window.ProjectConfig.projectName
            };

            const queryParam = encodeURIComponent(JSON.stringify(payload));
            genEventSource = new EventSource(`{{ route('project.generator.auto-scaffold') }}?payload=${queryParam}`);

            genEventSource.onmessage = function (event) {
                const data = JSON.parse(event.data);

                if (data.type === 'info') {
                    addLog(data.message, 'text-gray-300');
                } else if (data.type === 'success') {
                    addLog(data.message, 'text-emerald-400 font-bold');
                } else if (data.type === 'error') {
                    addLog(`[ERROR] ${data.message}`, 'text-red-500 font-bold');
                    genEventSource.close();
                    resetBtnUI();
                } else if (data.type === 'done') {
                    addLog(`[SELESAI] Semua file telah di-generate!`, 'text-purple-400 font-bold');
                    addLog(`Silakan refresh File Explorer (Icon Refresh) di sebelah kiri.`, 'text-white font-bold');
                    genEventSource.close();
                    resetBtnUI();
                }
            };

            genEventSource.onerror = function (err) {
                addLog(`[FATAL] Koneksi terputus dari server.`, 'text-red-500');
                genEventSource.close();
                resetBtnUI();
            };
        });

        function resetBtnUI() {
            startGenBtn.disabled = false;
            startGenBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            startGenBtn.querySelector('span').textContent = 'Mulai Generate File Setup';
        }
    </script>
</x-app-layout>