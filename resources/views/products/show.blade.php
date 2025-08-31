<x-app-layout>
    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6">
            <!-- Page Title -->
            <div class="mb-4 sm:mb-6">
                <h1 class="text-2xl sm:text-3xl font-semibold text-gray-900">Product Details</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">View and manage product information</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border">
                <!-- Product Header -->
                <div class="px-2 sm:px-4 py-2 sm:py-4 border-b">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-base sm:text-lg font-medium text-gray-700">{{ substr($product->name, 0, 1) }}</span>
                        </div>
                        <div class="mt-2 sm:mt-0 sm:ml-4">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-900">{{ $product->name }}</h2>
                            <p class="text-gray-500 text-sm sm:text-base">{{ $product->category->name ?? 'No Category' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="px-2 sm:px-4 py-2 sm:py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div class="space-y-3 sm:space-y-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 mb-1">Description</label>
                                <p class="text-gray-900 text-sm sm:text-base">{{ $product->description ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 mb-1">Unit Type</label>
                                <p class="text-gray-900 text-sm sm:text-base">{{ $product->unit_type ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 mb-1">Unit Value</label>
                                <p class="text-gray-900 text-sm sm:text-base">{{ $product->unit_value ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 mb-1">Price</label>
                                <p class="text-gray-900 text-lg font-semibold">₹{{ number_format($product->base_price, 2) }}</p>
                            </div>
                        </div>
                        <div class="space-y-3 sm:space-y-4 md:mt-0">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 mb-1">Created At</label>
                                <p class="text-gray-900 text-sm sm:text-base">{{ $product->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                                <p class="text-gray-900 text-sm sm:text-base">{{ $product->updated_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-2 sm:px-4 py-2 sm:py-3 bg-gray-50 border-t flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-2 sm:space-y-0">
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                        <a href="{{ route('products.edit', $product) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition text-center">
                            Edit Product
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-md text-sm font-medium transition text-center w-full sm:w-auto">
                                Delete
                            </button>
                        </form>
                    </div>
                    <a href="{{ route('products.index') }}"
                        class="text-gray-500 hover:text-gray-700 text-sm font-medium mt-2 sm:mt-0">
                        ← Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
