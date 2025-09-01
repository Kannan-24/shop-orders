<x-app-layout>
    <div class="py-4 sm:py-12">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
            <!-- Page Title -->
            <div class="mb-4 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-semibold text-gray-900">Create Customer</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">Add a new customer to the system</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border">
                <!-- Header -->
                <div class="px-2 py-3 sm:px-6 sm:py-6 border-b">
                    <div class="flex items-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-base sm:text-lg font-medium text-gray-700">#</span>
                        </div>
                        <div class="ml-2 sm:ml-4">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Add Customer</h2>
                            <p class="text-gray-500 text-xs sm:text-sm">Fill in the customer information below</p>
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="px-2 py-2 sm:px-6 sm:py-4 border-b bg-red-50">
                        <ul class="list-disc list-inside text-xs sm:text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Customer Form -->
                <form method="POST" action="{{ route('customers.store') }}">
                    @csrf
                    <div class="px-2 py-3 sm:px-6 sm:py-6 flex justify-center">
                        <div class="w-full sm:w-1/2 gap-8">
                            <div class="space-y-4 sm:space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-500 mb-1">
                                        Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        required
                                        class="w-full px-2 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                </div>

                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="w-full px-2 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                </div>

                                <div>
                                    <label for="phone"
                                        class="block text-sm font-medium text-gray-500 mb-1">Phone <span class="text-red-500">*</span></label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                        required
                                        class="w-full px-2 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                </div>

                                <div>
                                    <label for="address"
                                        class="block text-sm font-medium text-gray-500 mb-1">Address</label>
                                    <textarea name="address" id="address" rows="3"
                                        class="w-full px-2 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="px-2 py-2 sm:px-6 sm:py-4 bg-gray-50 border-t flex flex-col sm:flex-row justify-between items-center gap-3 sm:gap-0">
                        <div class="flex space-x-2 sm:space-x-3 w-full sm:w-auto">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition w-full sm:w-auto">
                                Save Customer
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
