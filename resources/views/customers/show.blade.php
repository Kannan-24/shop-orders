<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Title -->
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-gray-900">Customer Details</h1>
                <p class="text-gray-600 mt-1">View and manage customer information</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border">
                <!-- Customer Header -->
                <div class="px-6 py-6 border-b">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-lg font-medium text-gray-700">{{ $customer->name[0] }}</span>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900">{{ $customer->name }}</h2>
                            <p class="text-gray-500">Email: {{ $customer->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="px-6 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Phone</label>
                                <p class="text-gray-900">{{ $customer->phone ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Address</label>
                                <p class="text-gray-900">{{ $customer->address ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Created At</label>
                                <p class="text-gray-900">{{ $customer->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Updated At</label>
                                <p class="text-gray-900">{{ $customer->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
                    <div class="flex space-x-3">
                        <a href="{{ route('customers.edit', $customer) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                            Edit Customer
                        </a>
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this customer?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-md text-sm font-medium transition">
                                Delete
                            </button>
                        </form>
                    </div>
                    <a href="{{ route('customers.index') }}"
                        class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                        ← Back to Customers
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
