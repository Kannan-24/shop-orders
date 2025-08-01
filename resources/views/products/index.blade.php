<x-app-layout>
    <x-slot name="page-title">Products</x-slot>

    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-4xl font-bold text-gray-800">Products</h1>
                <a href="{{ route('products.create') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-xl shadow transition-all duration-300">
                    <span class="font-semibold">+ Create Product</span>
                </a>
            </div>

            <form method="GET" action="{{ route('products.index') }}" class="mb-6 flex flex-wrap items-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                    class="border border-gray-300 bg-white text-gray-800 rounded-lg px-4 py-2 w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                    class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg shadow">Search</button>
                @if(request('search'))
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Clear</a>
                @endif
            </form>

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
                <table class="min-w-full divide-y divide-gray-300 text-center">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">#</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Name</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Category</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Price</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Unit</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition-all text-center">
                                <td class="px-6 py-4">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-6 py-4">{{ $product->category?->name }}</td>
                                <td class="px-6 py-4">{{ number_format($product->base_price, 2) }}</td>
                                <td class="px-6 py-4"> ({{ rtrim(rtrim($product->unit_value, '0'), '.') }}){{ $product->unit_type }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        <a href="{{ route('products.show', $product) }}"
                                            class="text-sm font-semibold text-blue-600 hover:text-blue-800 px-3 py-1 rounded">View</a>
                                        <a href="{{ route('products.edit', $product) }}"
                                            class="text-sm font-semibold text-yellow-600 hover:text-yellow-800 px-3 py-1 rounded">Edit</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this product?')"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-sm font-semibold text-red-600 hover:text-red-800 px-3 py-1 rounded">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">{{ $products->links() }}</div>
        </div>
    </div>
</x-app-layout>