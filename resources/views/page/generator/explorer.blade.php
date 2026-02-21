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
            <a href="{{ route('project.generator.index') }}"
                class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 flex items-center gap-1 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Generator
            </a>
        </div>
    </x-slot>

    <div class="py-6 h-[calc(100vh-100px)]">
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
                    <div
                        class="bg-[#2d2d2d] flex items-center border-b border-[#1e1e1e] overflow-x-auto justify-between pr-4">
                        <div
                            class="flex-1 py-2 px-4 bg-[#1e1e1e] text-[#cccccc] border-t-2 border-indigo-500 flex justify-between items-center text-sm font-sans min-w-max cursor-default">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span id="active-file-name">No file selected</span>
                                <input type="hidden" id="active-file-path" value="">
                            </div>
                            <button id="save-file-btn"
                                class="hidden bg-indigo-600/50 hover:bg-indigo-500 text-white text-[11px] px-2 py-0.5 rounded transition-all"
                                title="Save File (Ctrl+S)">Save (Ctrl+S)</button>
                        </div>

                        <!-- Diff Controls (Hidden by default) -->
                        <div id="diff-controls" class="hidden flex gap-2">
                            <button id="accept-diff"
                                class="text-xs bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1 rounded">Accept
                                Changes</button>
                            <button id="reject-diff"
                                class="text-xs bg-[#444] hover:bg-[#555] text-white px-3 py-1 rounded">Reject</button>
                        </div>
                    </div>

                    {{-- Editor Content Container --}}
                    <div class="flex-1 relative overflow-hidden flex" id="editor-container">
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
            apiFileUrl: "{{ route('project.explorer.file', ['project' => $projectName ?? '']) }}"
        };

        document.addEventListener('DOMContentLoaded', () => {
            const treeContainer = document.getElementById('file-tree-root');
            const treeLoading = document.getElementById('tree-loading');
            const codeViewer = document.getElementById('code-viewer');
            const codeHighlight = document.getElementById('code-highlight-inner');
            const codeLoading = document.getElementById('code-loading');
            const activeFileName = document.getElementById('active-file-name');
            let currentLanguage = 'plaintext';

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

            // ===== Re-highlight on input =====
            codeViewer.addEventListener('input', () => {
                updateHighlight(codeViewer.value, activeFileName.textContent);
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
                        // Dir HTML
                        li.innerHTML = `<div class="cursor-pointer flex items-center gap-2 hover:bg-gray-200 dark:hover:bg-gray-700 py-1 px-2 rounded group">
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h4l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path></svg>
                                            ${item.name}
                                        </div>`;
                        const childrenUl = buildTreeDom(item.children);
                        childrenUl.style.display = 'none'; // closed by default
                        li.appendChild(childrenUl);

                        // Toggle dir
                        li.firstElementChild.addEventListener('click', (e) => {
                            e.stopPropagation();
                            childrenUl.style.display = childrenUl.style.display === 'none' ? 'block' : 'none';
                        });
                    } else {
                        // File HTML
                        li.innerHTML = `<div class="cursor-pointer file-item flex items-center gap-2 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/40 py-1 px-2 rounded" data-path="${item.path}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            ${item.name}
                                        </div>`;

                        li.firstElementChild.addEventListener('click', (e) => {
                            e.stopPropagation();
                            document.querySelectorAll('.file-item').forEach(el => el.classList.remove('bg-indigo-100', 'dark:bg-indigo-800'));
                            li.firstElementChild.classList.add('bg-indigo-100', 'dark:bg-indigo-800');
                            loadFile(item.path, item.name);
                        });
                    }

                    ul.appendChild(li);
                });
                return ul;
            }

            function loadFile(path, name) {
                codeLoading.style.display = 'flex';
                activeFileName.textContent = name;
                document.getElementById('active-file-path').value = path;

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
                        } else {
                            codeViewer.value = data.content;
                            // ✨ Apply syntax highlighting
                            updateHighlight(data.content, name);
                            document.getElementById('save-file-btn').classList.remove('hidden');
                        }
                    })
                    .catch(() => {
                        codeLoading.style.display = 'none';
                        codeViewer.value = `Error failed to fetch file`;
                        updateHighlight(`Error failed to fetch file`, 'error.txt');
                    });
            }

            // Manual Save Functionality
            const saveFileBtn = document.getElementById('save-file-btn');

            function saveActiveFile() {
                const path = document.getElementById('active-file-path').value;
                const currentContent = codeViewer.value;
                if (!path) return;

                saveFileBtn.textContent = 'Saving...';
                saveFileBtn.classList.add('opacity-50', 'pointer-events-none');

                fetch(`/ai-builder/explorer/${window.ProjectConfig.projectName}/save-file`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ path, content: currentContent })
                })
                    .then(res => res.json())
                    .then(data => {
                        saveFileBtn.textContent = data.success ? 'Saved!' : 'Error';
                        setTimeout(() => {
                            saveFileBtn.textContent = 'Save (Ctrl+S)';
                            saveFileBtn.classList.remove('opacity-50', 'pointer-events-none');
                        }, 2000);
                    });
            }

            saveFileBtn.addEventListener('click', saveActiveFile);

            // Ctrl+S functionality
            document.addEventListener('keydown', function (e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    if (!saveFileBtn.classList.contains('hidden')) {
                        saveActiveFile();
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

            chatSendBtn.addEventListener('click', () => {
                const prompt = chatInput.value.trim();
                const path = document.getElementById('active-file-path').value;
                const currentContent = codeViewer.value;

                if (!prompt || !path) return;

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
                    body: JSON.stringify({ prompt, file_content: currentContent })
                })
                    .then(res => res.json())
                    .then(data => {
                        loadMsg.remove();
                        if (data.error) {
                            addChatMessage('bot', `Error: ${data.error}`);
                        } else {
                            addChatMessage('bot', `I have proposed a change. Review the diff panel!`);
                            setDiffMode(data.code);
                        }
                    })
                    .catch(() => {
                        loadMsg.remove();
                        addChatMessage('bot', `Communication failed.`);
                    });
            });

            // Accept / Reject Handlers
            document.getElementById('accept-diff').addEventListener('click', () => {
                const path = document.getElementById('active-file-path').value;
                const codeNode = document.getElementById('diff-viewer').querySelector('code');
                const newContent = codeNode ? codeNode.textContent : '';

                fetch(`/ai-builder/explorer/${window.ProjectConfig.projectName}/save-file`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ path, content: newContent })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            codeViewer.value = newContent; // visually update master
                            document.getElementById('diff-view-pane').classList.add('hidden');
                            document.getElementById('diff-controls').classList.add('hidden');
                            addChatMessage('bot', 'Changes accepted and saved securely.');
                        } else {
                            addChatMessage('bot', 'Failed to save changes.');
                        }
                    });
            });

            document.getElementById('reject-diff').addEventListener('click', () => {
                document.getElementById('diff-view-pane').classList.add('hidden');
                document.getElementById('diff-controls').classList.add('hidden');
                addChatMessage('bot', 'Changes rejected.');
            });

            // Initial load
            loadTree();
        });
    </script>

    {{-- Prism.js core + autoloader (all languages) + line-numbers plugin --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
    <script>
        // Set autoloader path so all language grammars are loaded on demand
        if (typeof Prism !== 'undefined' && Prism.plugins?.autoloader) {
            Prism.plugins.autoloader.languages_path =
                'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/';
        }
    </script>

</x-app-layout>