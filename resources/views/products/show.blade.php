<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Title -->
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-gray-900">Product Details</h1>
                <p class="text-gray-600 mt-1">View and manage product information</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border">
                <!-- Product Header -->
                <div class="px-6 py-6 border-b">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-lg font-medium text-gray-700">{{ substr($product->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900">{{ $product->name }}</h2>
                            <p class="text-gray-500">{{ $product->category->name ?? 'No Category' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="px-6 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                                <p class="text-gray-900">{{ $product->description ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Unit Type</label>
                                <p class="text-gray-900">{{ $product->unit_type ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Unit Value</label>
                                <p class="text-gray-900">{{ $product->unit_value ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Price</label>
                                <p class="text-gray-900 text-lg font-semibold">₹{{ number_format($product->base_price, 2) }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Created At</label>
                                <p class="text-gray-900">{{ $product->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                                <p class="text-gray-900">{{ $product->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
                    <div class="flex space-x-3">
                        <a href="{{ route('products.edit', $product) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                            Edit Product
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" 
                              onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-md text-sm font-medium transition">
                                Delete
                            </button>
                        </form>
                    </div>
                    <a href="{{ route('products.index') }}" 
                       class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                        ← Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
