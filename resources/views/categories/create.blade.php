<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Title -->
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-gray-900">Create Category</h1>
                <p class="text-gray-600 mt-1">Add a new category to the system</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border">
                <!-- Header -->
                <div class="px-6 py-6 border-b">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-lg font-medium text-gray-700">#</span>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900">Add Category</h2>
                            <p class="text-gray-500">Fill in the category information below</p>
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

                <!-- Category Form -->
                <form method="POST" action="{{ route('categories.store') }}">
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
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                                    <textarea name="description" id="description" rows="4"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
                        <div class="flex space-x-3">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                                Save Category
                            </button>
                        </div>
                        <a href="{{ route('categories.index') }}"
                            class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                            ← Back to Categories
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
