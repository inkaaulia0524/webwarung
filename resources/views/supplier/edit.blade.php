{{-- resources/views/admin/supplier/edit.blade.php --}}
@extends('admin.layout')

@section('content')
  <div style="display:flex;flex-direction:column;gap:16px;">
    <div>
      <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
        Edit Supplier
      </h2>

      {{-- ngecek apakah ada pesan sukses. akan menampilkan pesan sukses dari controller jika ada --}}
      @if (session('success'))
        <div style="
          padding:10px 12px;
          border:1px solid var(--border-color);
          background:#eefaf0;
          color:#1f7a1f;
          border-radius:6px;
          margin-bottom:12px;">
          {{ session('success') }}
        </div>
      @endif

      {{-- Form Edit Supplier menggunakan id. menggunakan method POST dengan spoofing method PUT --}}
      <form action="{{ route('supplier.update', $supplier->id) }}" method="POST" style="display:flex;flex-direction:column;gap:16px;"> 
        @csrf {{-- Token CSRF untuk keamanan --}}
        @method('PUT') {{-- Metode PUT untuk update --}}

        <div>
          {{-- Label dan input untuk nama supplier --}}
          <label for="name" style="font-size:16px;font-weight:600;color:var(--text-dark);">Supplier Name</label>
          {{-- required nama --}}
          <input type="text" id="name" name="name" value="{{ old('name', $supplier->name) }}" required
                 style="
                   padding:12px 16px;
                   border:1px solid var(--border-color);
                   border-radius:8px;
                   font-size:14px;
                   color:var(--text-dark);
                   outline:none;
                   width:100%;
                   box-sizing:border-box;">
          {{-- jika ada error pada field name, tampilkan pesan error --}}
          @error('name')
          {{-- pesan error untuk field name --}}
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        <div>
          {{-- Label dan input untuk email --}}
          <label for="email" style="font-size:16px;font-weight:600;color:var(--text-dark);">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email', $supplier->email) }}" required
                 style="
                   padding:12px 16px;
                   border:1px solid var(--border-color);
                   border-radius:8px;
                   font-size:14px;
                   color:var(--text-dark);
                   outline:none;
                   width:100%;
                   box-sizing:border-box;">
          {{-- jika ada error pada field email, tampilkan pesan error --}}
          @error('email')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        <div>
          {{-- Label dan input untuk no telp --}}
          <label for="phone" style="font-size:16px;font-weight:600;color:var(--text-dark);">Phone</label>
          <input type="text" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}" required
                 style="
                   padding:12px 16px;
                   border:1px solid var(--border-color);
                   border-radius:8px;
                   font-size:14px;
                   color:var(--text-dark);
                   outline:none;
                   width:100%;
                   box-sizing:border-box;">
          {{-- jika ada error pada field phone (no telp), tampilkan pesan error --}}
          @error('phone')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        <div>
          {{-- Label dan textarea untuk alamat --}}
          <label for="address" style="font-size:16px;font-weight:600;color:var(--text-dark);">Address</label>
          <textarea id="address" name="address" rows="4" required
                    style="
                      padding:12px 16px;
                      border:1px solid var(--border-color);
                      border-radius:8px;
                      font-size:14px;
                      color:var(--text-dark);
                      outline:none;
                      width:100%;
                      box-sizing:border-box;">{{ old('address', $supplier->address) }}</textarea>
          {{-- jika ada error pada field address, tampilkan pesan error --}}
          @error('address')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        {{-- Tombol Submit dan Kembali --}}
        <div style="display: flex; gap: 8px; align-items: center; justify-content: flex-start;">
          <button type="submit" style="
            display:inline-block;
            padding:12px 16px;
            background-color:var(--primary-hover);
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
            margin-top:12px;">
            Update
          </button>

          <a href="{{ route('supplier.index') }}" style="
            display:inline-block;
            padding:12px 16px;
            background-color:var(--primary-hover);
            color:white;
            border-radius:8px;
            text-decoration:none;
            margin-top:12px;">
            Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection
