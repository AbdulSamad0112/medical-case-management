<x-guest-layout>
    <div class="bg-white py-8 px-6 shadow-sm ring-1 ring-slate-900/5 rounded-2xl sm:px-10">
        <h2 class="text-xl font-semibold text-slate-900 mb-6 text-center">Sign in to your account</h2>

        @if (session('status'))
            <div class="mb-4 p-3 rounded-lg bg-teal-50 border border-teal-200 text-teal-800 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-sm">
                <p class="font-medium">Please correct the following errors:</p>
                <ul class="list-disc list-inside mt-1 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
                <div class="mt-1">
                    <input id="email" name="email" type="email" autocomplete="email" required
                           value="{{ old('email') }}"
                           class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('email') border-rose-300 @enderror"
                           placeholder="user@jajalmedical.com">
                </div>
                @error('email')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('password') border-rose-300 @enderror">
                </div>
                @error('password')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                           class="h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    <label for="remember" class="ml-2 block text-sm text-slate-600">Remember me</label>
                </div>
            </div>

            <div>
                <button type="submit"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition duration-150">
                    Sign In
                </button>
            </div>
        </form>

        <!-- Dummy Credentials Box for Demo & Reviewers -->
        <div class="mt-8 pt-6 border-t border-slate-200/80">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3 text-center">
                Demo Accounts (Click to Fill)
            </h3>
            <div class="grid grid-cols-2 gap-3 text-xs">
                <button type="button"
                        onclick="fillCredentials('admin@jajalmedical.com', 'Admin@123456')"
                        class="p-3 text-left rounded-xl bg-slate-50 hover:bg-teal-50/60 border border-slate-200 transition">
                    <div class="flex items-center space-x-1.5 font-semibold text-slate-800">
                        <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                        <span>Admin</span>
                    </div>
                    <div class="text-slate-500 mt-1 truncate">admin@jajalmedical.com</div>
                    <div class="text-slate-400 font-mono mt-0.5">Admin@123456</div>
                </button>

                <button type="button"
                        onclick="fillCredentials('viewer@jajalmedical.com', 'Viewer@123456')"
                        class="p-3 text-left rounded-xl bg-slate-50 hover:bg-sky-50/60 border border-slate-200 transition">
                    <div class="flex items-center space-x-1.5 font-semibold text-slate-800">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                        <span>Viewer</span>
                    </div>
                    <div class="text-slate-500 mt-1 truncate">viewer@jajalmedical.com</div>
                    <div class="text-slate-400 font-mono mt-0.5">Viewer@123456</div>
                </button>
            </div>
        </div>
    </div>

    <script>
        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</x-guest-layout>
