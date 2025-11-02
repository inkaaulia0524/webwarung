@extends('kasir.layout')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Profil Kasir</h1>

    <form method="POST" action="{{ route('kasir.profile.update') }}" class="space-y-4">
        @csrf
        @method('PATCH')

        <div>
            <label class="block mb-1 font-medium">Nama</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Password Baru (opsional)</label>
            <input type="password" name="password" class="w-full border rounded p-2">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan Perubahan
        </button>
    </form>
@endsection
