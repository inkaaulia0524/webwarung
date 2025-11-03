@extends('admin.layout')

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <h2 class="mb-5 text-2xl font-bold text-gray-800">Data Barang</h2>

                <!-- Pesan sukses -->
                @if (session('success'))
                    <div class="mb-4 p-3 text-green-700 bg-green-100 border border-green-300 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('barang.index') }}" class="mb-4 flex items-center">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by product name or producer..."
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    <button
                        type="submit"
                        class="px-4 py-2 text-white bg-blue-600 rounded-r-md hover:bg-blue-700">
                        Search
                    </button>
                </form>

                <!-- Tabel Barang -->
                <table class="min-w-full bg-white border border-gray-300 table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 text-left border-b">Product Name</th>
                            <th class="py-2 px-4 text-left border-b">Unit</th>
                            <th class="py-2 px-4 text-left border-b">Type</th>
                            <th class="py-2 px-4 text-left border-b">Quantity</th>
                            <th class="py-2 px-4 text-left border-b">Producer</th>
                            <th class="py-2 px-4 text-left border-b">Information</th>
                            <th class="py-2 px-4 text-left border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangs as $product)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $product->product_name }}</td>
                                <td class="py-2 px-4 border-b">{{ $product->unit }}</td>
                                <td class="py-2 px-4 border-b">{{ $product->type }}</td>
                                <td class="py-2 px-4 border-b">{{ $product->qty }}</td>
                                <td class="py-2 px-4 border-b">{{ $product->producer }}</td>
                                <td class="py-2 px-4 border-b">{{ $product->information }}</td>
                                <td class="py-2 px-4 border-b space-x-2">
                                    <a href="{{ route('barang.edit', $product->id) }}"
                                       class="bg-yellow-400 text-black px-4 py-2 rounded-md hover:bg-yellow-500">
                                       Edit
                                    </a>
                                    <form action="{{ route('barang.destroy', $product->id) }}"
                                          method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center text-gray-500">
                                    No products found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Tombol Tambah Barang -->
                <div class="mt-4">
                    <a href="{{ route('barang.create') }}"
                       class="inline-flex justify-center px-4 py-2 text-sm font-medium text-black bg-blue-500 border rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create new product
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
