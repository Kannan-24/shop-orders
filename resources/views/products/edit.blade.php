<x-app-layout>
    <x-slot name="page-title">Edit Product</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Title -->
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-gray-900">Edit Product</h1>
                <p class="text-gray-600 mt-1">Update product details below</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border">
                <!-- Header -->
                <div class="px-6 py-6 border-b">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-lg font-medium text-gray-700">#</span>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900">Edit Product</h2>
                            <p class="text-gray-500">Modify the product information below</p>
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

                <!-- Product Form -->
                <form method="POST" action="{{ route('products.update', $product) }}">
                    @csrf
                    @method('PUT')
                    <div class="px-6 py-6 flex justify-center">
                        <div class="gap-8 w-1/2">
                            <div class="space-y-6">
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-500 mb-1">
                                        Category <span class="text-red-500">*</span>
                                    </label>
                                    <select name="category_id" id="category_id" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-500 mb-1">
                                        Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-500 mb-1">
                                        Description
                                    </label>
                                    <textarea name="description" id="description" rows="4"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
                                </div>

                                <div>
                                    <label for="unit_type" class="block text-sm font-medium text-gray-500 mb-1">
                                        Unit Type <span class="text-red-500">*</span>
                                    </label>
                                    <select name="unit_type" id="unit_type" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select Unit Type</option>
                                        <option value="kg" {{ old('unit_type', $product->unit_type) == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                        <option value="g" {{ old('unit_type', $product->unit_type) == 'g' ? 'selected' : '' }}>Gram (g)</option>
                                        <option value="l" {{ old('unit_type', $product->unit_type) == 'l' ? 'selected' : '' }}>Liter (l)</option>
                                        <option value="ml" {{ old('unit_type', $product->unit_type) == 'ml' ? 'selected' : '' }}>Milliliter (ml)</option>
                                        <option value="pcs" {{ old('unit_type', $product->unit_type) == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="unit_value" class="block text-sm font-medium text-gray-500 mb-1">
                                        Unit Value <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="unit_value" id="unit_value" value="{{ old('unit_value', $product->unit_value) }}"
                                        required min="0" step="0.01"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="base_price" class="block text-sm font-medium text-gray-500 mb-1">
                                        Base Price <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="base_price" id="base_price" value="{{ old('base_price', $product->base_price) }}"
                                        required min="0" step="0.01"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
                        <div class="flex space-x-3">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                                Update Product
                            </button>
                        </div>
                        <a href="{{ route('products.index') }}"
                            class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                            ← Back to Products
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
