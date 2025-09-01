<x-app-layout>
    <x-slot name="page-title">Users</x-slot>

    <div class="bg-gray-100 min-h-screen py-0 *:lg:py-12">
        <div class="max-w-7xl mx-auto sm:px-0 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">Users</h1>
                <a href="{{ route('users.create') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 sm:px-5 py-2 rounded-xl shadow transition-all duration-300 w-full sm:w-auto justify-center">
                    <span class="font-semibold">Create User</span>
                </a>
            </div>

            <form method="GET" action="{{ route('users.index') }}"
                class="mb-6 flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..."
                    class="border border-gray-300 bg-white text-gray-800 rounded-lg px-4 py-2 w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                    class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg shadow w-full sm:w-auto">Search</button>
                @if (request('search'))
                    <a href="{{ route('users.index') }}"
                        class="text-blue-600 hover:underline w-full sm:w-auto text-center">Clear</a>
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
                            <th class="px-2 sm:px-6 py-3 font-semibold text-gray-700 text-center text-xs sm:text-base">#
                            </th>
                            <th class="px-2 sm:px-6 py-3 font-semibold text-gray-700 text-center text-xs sm:text-base">
                                Name</th>
                            <th class="px-2 sm:px-6 py-3 font-semibold text-gray-700 text-center text-xs sm:text-base">
                                Phone</th>
                            <th class="px-2 sm:px-6 py-3 font-semibold text-gray-700 text-center text-xs sm:text-base">
                                Role</th>
                            <th class="px-2 sm:px-6 py-3 font-semibold text-gray-700 text-center text-xs sm:text-base">
                                Status</th>
                            <th class="px-2 sm:px-6 py-3 font-semibold text-gray-700 text-center text-xs sm:text-base">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition-all text-center">
                                <td class="px-2 sm:px-6 py-4 text-xs sm:text-base">
                                    {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                <td class="px-2 sm:px-6 py-4 font-medium text-gray-900 text-xs sm:text-base">
                                    {{ $user->name }}</td>
                                <td class="px-2 sm:px-6 py-4 text-xs sm:text-base">{{ $user->phone }}</td>
                                <td class="px-2 sm:px-6 py-4 text-xs sm:text-base">{{ ucfirst($user->role) }}</td>
                                <td class="px-2 sm:px-6 py-4 text-xs sm:text-base">
                                    @if ($user->is_active)
                                        <span class="text-green-600 font-semibold">Active</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-2 sm:px-6 py-4">
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        <!-- View -->
                                        <a href="{{ route('users.show', $user) }}"
                                            class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-2 rounded-lg transition-all duration-200"
                                            title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="text-yellow-600 hover:text-yellow-800 hover:bg-yellow-50 p-2 rounded-lg transition-all duration-200"
                                            title="Edit User">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this user?')"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-all duration-200"
                                                title="Delete User">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="px-2 sm:px-6 py-4 text-center text-gray-500 text-xs sm:text-base">No users
                                    found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layout>
