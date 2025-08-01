<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Title -->
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-gray-900">Category Details</h1>
                <p class="text-gray-600 mt-1">View and manage category information</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border">
                <!-- Category Header -->
                <div class="px-6 py-6 border-b">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-lg font-medium text-gray-700">{{ $category->id }}</span>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900"># {{ $category->id }}</h2>
                            <p class="text-gray-500">{{ $category->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Category Information -->
                <div class="px-6 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                                <p class="text-gray-900">{{ $category->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                                <p class="text-gray-900">{{ $category->description ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Created At</label>
                                <p class="text-gray-900">{{ $category->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Updated At</label>
                                <p class="text-gray-900">{{ $category->updated_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
                    <div class="flex space-x-3">
                        <a href="{{ route('categories.edit', $category) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                            Edit Category
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-md text-sm font-medium transition">
                                Delete
                            </button>
                        </form>
                    </div>
                    <a href="{{ route('categories.index') }}"
                        class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                        ← Back to Categories
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
