<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('AI Builder Project Generator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700 transition-all duration-300">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-purple-600">Scaffold New Laravel Project</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Set up a fresh installation tailored to your specific database environment.</p>
                    </div>

                    <form id="generator-form" action="{{ route('project.generator.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="bg-red-50 dark:bg-red-900/50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">There were errors with your submission</h3>
                                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                            <ul class="list-disc pl-5 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Project Details -->
                            <div class="space-y-6 bg-gray-50 dark:bg-gray-900/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                                <h4 class="font-semibold text-lg text-indigo-500 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                    Project Details
                                </h4>
                                
                                <div>
                                    <label for="project_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Name</label>
                                    <input type="text" name="project_name" id="project_name" required placeholder="e.g. ecommerce-app"
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors">
                                    <p class="mt-1 text-xs text-gray-500">Only alphanumeric, dashes, and underscores allowed.</p>
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                    <textarea name="description" id="description" rows="3" placeholder="Brief explanation of the project..."
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors"></textarea>
                                </div>
                            </div>

                            <!-- Database Configuration -->
                            <div class="space-y-6 bg-gray-50 dark:bg-gray-900/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                                <h4 class="font-semibold text-lg text-purple-500 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                                    Database Config
                                </h4>
                                
                                <div>
                                    <label for="db_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Database Connection Type</label>
                                    <select name="db_type" id="db_type" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm transition-colors">
                                        <option value="mysql">MySQL</option>
                                        <option value="pgsql">PostgreSQL</option>
                                        <option value="sqlite">SQLite</option>
                                    </select>
                                </div>

                                <div id="db-credentials" class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="db_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Database Name</label>
                                            <input type="text" name="db_name" id="db_name" placeholder="e.g. laravel_db" required
                                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm transition-colors">
                                        </div>
                                        <div>
                                            <label for="db_port" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Database Port</label>
                                            <input type="text" name="db_port" id="db_port" placeholder="e.g. 3306" value="3306"
                                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm transition-colors">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="db_username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                                            <input type="text" name="db_username" id="db_username" value="root"
                                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm transition-colors">
                                        </div>
                                        <div>
                                            <label for="db_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                                            <input type="password" name="db_password" id="db_password"
                                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm transition-colors">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- AI Context Area -->
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                            <h4 class="font-semibold text-lg text-emerald-500 flex items-center gap-2 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                AI Context Prompt (Gemini Builder)
                            </h4>
                            <div>
                                <label for="ai_prompt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tell Gemini what you want this project to be (Optional)</label>
                                <textarea name="ai_prompt" id="ai_prompt" rows="4" placeholder="e.g. I want to build a pos application with a dashboard for admin and pos for user..."
                                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-colors"></textarea>
                                <p class="mt-2 text-xs text-gray-500">The context prompt and gemini token will be automatically injected into your generated .env file.</p>
                            </div>
                        </div>

                        <!-- Submit Area -->
                        <div class="flex items-center justify-end pt-4 border-t border-gray-200 dark:border-gray-700 mt-6 pt-6">
                            <button type="submit" id="submit-btn" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02]">
                                <span id="btn-text">Generate Project</span>
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </button>
                        </div>
                    </form>

                    <!-- Loading State (Hidden initially) -->
                    <div id="loading-state" class="hidden mt-8 text-center p-12 bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700">
                        <div class="inline-block relative w-20 h-20">
                            <div class="absolute top-0 left-0 w-full h-full border-4 border-indigo-200 dark:border-indigo-900 rounded-full animate-pulse"></div>
                            <div class="absolute top-0 left-0 w-full h-full border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
                        </div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900 dark:text-white">Scaffolding Project...</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Downloading dependencies and crafting your fresh Laravel environment. This may take a minute.</p>
                        
                        <!-- Progress output logs placeholder -->
                        <div class="mt-6 text-left max-w-2xl mx-auto bg-black rounded-lg p-4 font-mono text-xs text-green-400 h-64 overflow-y-auto whitespace-pre-wrap flex flex-col" id="terminal-output">
                            <span>> Starting environment check...</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- UI Logic Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('generator-form');
            const submitBtn = document.getElementById('submit-btn');
            const loadingState = document.getElementById('loading-state');
            const dbType = document.getElementById('db_type');
            const dbCredentials = document.getElementById('db-credentials');

            const dbPort = document.getElementById('db_port');

            // Hide credentials if SQLite is selected, autofill ports for other engines
            dbType.addEventListener('change', (e) => {
                if(e.target.value === 'sqlite') {
                    dbCredentials.classList.add('opacity-50', 'pointer-events-none');
                } else {
                    dbCredentials.classList.remove('opacity-50', 'pointer-events-none');
                    if (e.target.value === 'pgsql') {
                        dbPort.value = '5432';
                    } else if (e.target.value === 'mysql') {
                        dbPort.value = '3306';
                    }
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent standard POST
                
                // Show loading state gracefully
                form.classList.add('hidden');
                loadingState.classList.remove('hidden');
                loadingState.classList.add('animate-fade-in');
                
                const formData = new FormData(form);
                const payload = {};
                formData.forEach((value, key) => { payload[key] = value });
                
                const terminalOutput = document.getElementById('terminal-output');
                terminalOutput.innerHTML = ''; // clear initial content

                // Serialize payload into URL
                const queryParam = encodeURIComponent(JSON.stringify(payload));
                const evtSource = new EventSource(`{{ route('project.generator.stream') }}?payload=${queryParam}`);

                evtSource.onmessage = function(event) {
                    const data = JSON.parse(event.data);
                    
                    if (data.type === 'log') {
                        // Append log
                        const span = document.createElement('span');
                        span.textContent = data.message; // safe text rendering
                        // simplistic handling of newlines natively if CSS white-space is pre-wrap
                        terminalOutput.appendChild(span);
                        terminalOutput.scrollTop = terminalOutput.scrollHeight;
                    } else if (data.type === 'info') {
                        const div = document.createElement('div');
                        div.className = "text-indigo-400 font-bold mt-2";
                        div.textContent = `>>> ${data.message} <<<`;
                        terminalOutput.appendChild(div);
                        terminalOutput.scrollTop = terminalOutput.scrollHeight;
                    } else if (data.type === 'error') {
                        const div = document.createElement('div');
                        div.className = "text-red-500 font-bold mt-2";
                        div.textContent = `[ERROR] ${data.message}`;
                        terminalOutput.appendChild(div);
                        terminalOutput.scrollTop = terminalOutput.scrollHeight;
                        evtSource.close();
                        
                        // Show back button
                        const backBtn = document.createElement('button');
                        backBtn.className = "mt-4 text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded";
                        backBtn.textContent = "Go Back & Retry";
                        backBtn.onclick = () => window.location.reload();
                        loadingState.appendChild(backBtn);
                        
                    } else if (data.type === 'done') {
                        const div = document.createElement('div');
                        div.className = "text-emerald-400 font-bold mt-2";
                        div.textContent = `[SUCCESS] Redirecting to project viewer...`;
                        terminalOutput.appendChild(div);
                        terminalOutput.scrollTop = terminalOutput.scrollHeight;
                        
                        evtSource.close();
                        setTimeout(() => {
                            window.location.href = `/ai-builder/explorer/${data.message}`;
                        }, 1500);
                    }
                };

                evtSource.onerror = function(err) {
                    console.error("EventSource failed:", err);
                    evtSource.close();
                };
            });
        });
    </script>
</x-app-layout>
