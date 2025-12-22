{{-- resources/views/admin/products/partials/form.blade.php --}}

@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    {{-- SISI KIRI: IDENTITAS PRODUK --}}
    <div class="space-y-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400 mb-6 flex items-center gap-2">
                <i class="bi bi-info-circle text-indigo-500"></i> Informasi Dasar
            </h3>

            <div class="space-y-5">
                {{-- Nama Produk --}}
                <div class="space-y-1.5">
                    <label for="name" class="text-sm font-semibold text-slate-700">Nama Produk</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $product->name ?? '') }}"
                           placeholder="Masukkan nama lengkap produk"
                           class="block w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 text-slate-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-slate-400
                           @error('name') border-rose-500 bg-rose-50 @enderror" required>
                    @error('name')<p class="text-rose-500 text-[10px] font-bold uppercase tracking-wider mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Kategori --}}
                <div class="space-y-1.5">
                    <label for="category_id" class="text-sm font-semibold text-slate-700">Kategori</label>
                    <div class="relative">
                        <select name="category_id" id="category_id"
                                class="appearance-none block w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 text-slate-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all
                                @error('category_id') border-rose-500 bg-rose-50 @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>
                    @error('category_id')<p class="text-rose-500 text-[10px] font-bold uppercase tracking-wider mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Deskripsi --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400 mb-6 flex items-center gap-2">
                <i class="bi bi-text-paragraph text-indigo-500"></i> Detail Deskripsi
            </h3>
            <div class="space-y-1.5">
                <textarea name="description" id="description" rows="6"
                          placeholder="Jelaskan spesifikasi dan keunggulan produk..."
                          class="block w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 text-slate-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all resize-none
                          @error('description') border-rose-500 bg-rose-50 @enderror">{{ old('description', $product->description ?? '') }}</textarea>
                @error('description')<p class="text-rose-500 text-[10px] font-bold uppercase tracking-wider mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    {{-- SISI KANAN: HARGA & LOGISTIK --}}
    <div class="space-y-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400 mb-6 flex items-center gap-2">
                <i class="bi bi-tag text-indigo-500"></i> Harga & Persediaan
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Harga --}}
                <div class="space-y-1.5">
                    <label for="price" class="text-sm font-semibold text-slate-700">Harga (Rp)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 text-sm font-bold">Rp</span>
                        <input type="number" name="price" id="price"
                               value="{{ old('price', $product->price ?? '') }}"
                               class="block w-full pl-11 pr-4 py-3 rounded-xl border-slate-200 bg-slate-50 text-slate-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all
                               @error('price') border-rose-500 bg-rose-50 @enderror" required>
                    </div>
                    @error('price')<p class="text-rose-500 text-[10px] font-bold uppercase tracking-wider mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Stok --}}
                <div class="space-y-1.5">
                    <label for="stock" class="text-sm font-semibold text-slate-700">Jumlah Stok</label>
                    <div class="relative">
                        <input type="number" name="stock" id="stock"
                               value="{{ old('stock', $product->stock ?? '') }}"
                               class="block w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 text-slate-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all
                               @error('stock') border-rose-500 bg-rose-50 @enderror" required>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 text-[10px] font-bold uppercase tracking-widest">Unit</span>
                    </div>
                    @error('stock')<p class="text-rose-500 text-[10px] font-bold uppercase tracking-wider mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Help Card (Optional) --}}
        <div class="bg-indigo-50 p-6 rounded-2xl border border-indigo-100">
            <div class="flex gap-4">
                <div class="h-10 w-10 shrink-0 rounded-lg bg-indigo-500 flex items-center justify-center text-white shadow-md shadow-indigo-200">
                    <i class="bi bi-lightbulb"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-indigo-900">Tips Penjualan</h4>
                    <p class="text-xs text-indigo-700 leading-relaxed mt-1">Pastikan nama produk jelas dan deskripsi mencakup spesifikasi teknis untuk meningkatkan kepercayaan pembeli.</p>
                </div>
            </div>
        </div>
    </div>
</div>
