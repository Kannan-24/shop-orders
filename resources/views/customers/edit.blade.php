<x-app-layout>
    <x-slot name="page-title">Edit Customer</x-slot>
    <div class="py-0 lg:py-12">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6">
            <!-- Page Title -->
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Edit Customer</h1>
                <p class="text-gray-600 mt-1">Update customer information below</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border">
                <!-- Header -->
                <div class="px-2 sm:px-4 py-4 border-b">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-lg font-medium text-gray-700">#</span>
                        </div>
                        <div class="ml-3">
                            <h2 class="text-lg font-semibold text-gray-900">Edit Customer</h2>
                            <p class="text-gray-500">Modify the customer information below</p>
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="px-2 sm:px-4 py-3 border-b bg-red-50">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Customer Form -->
                <form method="POST" action="{{ route('customers.update', $customer) }}">
                    @csrf
                    @method('PUT')
                    <div class="px-2 sm:px-4 py-4 flex justify-center">
                        <div class="w-full sm:w-3/4 md:w-1/2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-500 mb-1">
                                        Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}"
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-500 mb-1">Phone</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-500 mb-1">Address</label>
                                    <textarea name="address" id="address" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address', $customer->address) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="px-2 sm:px-4 py-3 bg-gray-50 border-t flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
                        <div class="flex space-x-2 w-full sm:w-auto">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition w-full sm:w-auto">
                                Update Customer
                            </button>
                        </div>
                        <a href="{{ route('customers.index') }}"
                            class="text-gray-500 hover:text-gray-700 text-sm font-medium w-full sm:w-auto text-center">
                            ← Back to Customers
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
