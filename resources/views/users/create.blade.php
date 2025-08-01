<x-app-layout>
    <x-slot name="page-title">Create User</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Title -->
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-gray-900">Add User</h1>
                <p class="text-gray-600 mt-1">Fill in the user details below</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border">
                <!-- Header -->
                <div class="px-6 py-6 border-b">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-lg font-medium text-gray-700">+</span>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900">Create User</h2>
                            <p class="text-gray-500">Enter the new user information below</p>
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="px-6 py-4 border-b bg-red-50">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- User Form -->
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="px-6 py-6 flex justify-center">
                        <div class="gap-8 w-1/2">
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-500 mb-1">
                                        Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-500 mb-1">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-500 mb-1">
                                        Phone
                                    </label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-500 mb-1">
                                        Role <span class="text-red-500">*</span>
                                    </label>
                                    <select name="role" id="role" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                    </select>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="mr-2">
                                    <label for="is_active" class="font-medium text-sm text-gray-500">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
                        <div class="flex space-x-3">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                                Save
                            </button>
                        </div>
                        <a href="{{ route('users.index') }}"
                            class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                            ← Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
