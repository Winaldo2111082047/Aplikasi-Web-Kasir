<x-app-layout>
    {{-- Kita tambahkan properti baru: amountPaid, change, dan isPaidEnough --}}
    <div x-data="{
        cart: [],
        products: {{ $products }},
        search: '',
        isLoading: false,
        message: '',
        amountPaid: '', // <-- Properti baru untuk uang yang dibayar

        // Computed property untuk memfilter produk
        get filteredProducts() {
            if (this.search === '') {
                return this.products;
            }
            return this.products.filter(product =>
                product.name.toLowerCase().includes(this.search.toLowerCase())
            );
        },

        // Computed property untuk menghitung kembalian
        get change() {
            // Pastikan amountPaid dan total adalah angka dan amountPaid cukup
            if (this.amountPaid === '' || isNaN(this.amountPaid) || this.amountPaid < this.total) {
                return 0;
            }
            return this.amountPaid - this.total;
        },

        // Computed property untuk memeriksa apakah pembayaran cukup
        get isPaidEnough() {
            return this.amountPaid >= this.total && this.cart.length > 0;
        },

        addToCart(product) {
            if (product.stock <= 0) {
                alert('Stok produk habis!');
                return;
            }
            let item = this.cart.find(i => i.id === product.id);
            if (item) {
                if(item.quantity < product.stock) {
                    item.quantity++;
                } else {
                    alert('Stok produk tidak mencukupi!');
                }
            } else {
                this.cart.push({...product, quantity: 1});
            }
        },
        removeFromCart(productId) {
            this.cart = this.cart.filter(i => i.id !== productId);
        },
        get total() {
            return this.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
        },
        async processTransaction() {
            if (!this.isPaidEnough) {
                alert('Jumlah uang yang dibayarkan tidak mencukupi!');
                return;
            }

            this.isLoading = true;
            this.message = '';

            try {
                const response = await fetch('{{ route('transaksi.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ cart: this.cart })
                });

                const result = await response.json();

                if (response.ok) {
                    this.message = 'Sukses: ' + result.message + ' Kembalian: Rp ' + this.change.toLocaleString('id-ID');
                    this.cart = [];
                    this.amountPaid = '';
                    setTimeout(() => window.location.reload(), 2500);
                } else {
                    this.message = 'Error: ' + result.message;
                }
            } catch (error) {
                this.message = 'Error: Tidak dapat terhubung ke server.';
            } finally {
                this.isLoading = false;
            }
        }
    }">
        <div class="flex">
            <!-- Kolom Kiri: Daftar Produk -->
            <div class="w-2/3 p-4">
                <h1 class="text-2xl font-bold mb-4">Pilih Produk</h1>
                <div class="mb-4">
                    <input type="text" x-model.debounce.300ms="search" placeholder="Cari nama produk..." class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <div @click="addToCart(product)"
                             class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-xl transition-shadow duration-200">
                            <div x-show="product.image">
                                <img :src="`/storage/${product.image}`" :alt="product.name" class="w-full h-32 object-cover">
                            </div>
                            <div x-show="!product.image" class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"></path></svg>
                            </div>
                            <div class="p-4">
                                <h2 class="font-bold text-lg truncate" x-text="product.name"></h2>
                                <p class="text-blue-600 font-semibold mt-1" x-text="`Rp ${Number(product.price).toLocaleString('id-ID')}`"></p>
                                <p class="text-xs text-gray-400 mt-1" x-text="`Stok: ${product.stock}`"></p>
                            </div>
                        </div>
                    </template>
                     <div x-show="filteredProducts.length === 0" class="col-span-full text-center text-gray-500 py-10">
                        Tidak ada produk yang cocok dengan pencarian.
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Keranjang Belanja -->
            <div class="w-1/3 bg-white h-screen p-4 shadow-lg flex flex-col">
                <h1 class="text-2xl font-bold mb-4">Keranjang</h1>

                <div x-show="message" x-text="message" class="p-4 mb-4 text-sm rounded-lg"
                    :class="{ 'bg-green-100 text-green-700': message.startsWith('Sukses'), 'bg-red-100 text-red-700': message.startsWith('Error') }">
                </div>

                <div class="flex-grow space-y-4 overflow-y-auto">
                    <template x-for="item in cart" :key="item.id">
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <p class="font-semibold" x-text="item.name"></p>
                                <p class="text-sm text-gray-600" x-text="`Rp ${Number(item.price).toLocaleString('id-ID')}`"></p>
                            </div>
                            <div class="flex items-center">
                                <input type="number" x-model.number="item.quantity" min="1" :max="item.stock" class="w-16 text-center border rounded-md">
                                <button @click="removeFromCart(item.id)" class="ml-2 text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                    <div x-show="cart.length === 0" class="text-center text-gray-500 py-6">
                        Keranjang masih kosong.
                    </div>
                </div>

                <!-- Total dan Tombol Bayar -->
                <div class="mt-auto pt-4 border-t space-y-4">
                    <div class="flex justify-between font-bold text-xl">
                        <span>Total</span>
                        <span x-text="`Rp ${total.toLocaleString('id-ID')}`"></span>
                    </div>

                    {{-- INPUT UANG BAYAR --}}
                    <div>
                        <label for="amount_paid" class="block text-sm font-medium text-gray-700">Jumlah Uang Bayar</label>
                        <input type="number" id="amount_paid" x-model.number="amountPaid" placeholder="Masukkan jumlah uang"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-lg">
                    </div>

                    {{-- TAMPILAN UANG KEMBALIAN --}}
                    <div class="flex justify-between font-medium text-lg" x-show="isPaidEnough">
                        <span>Kembalian</span>
                        <span x-text="`Rp ${change.toLocaleString('id-ID')}`"></span>
                    </div>

                    {{-- Tombol dinonaktifkan jika pembayaran tidak cukup --}}
                    <button @click="processTransaction()" :disabled="!isPaidEnough || isLoading"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 disabled:bg-blue-300 disabled:cursor-not-allowed flex items-center justify-center">
                        <span x-show="!isLoading">Proses Transaksi</span>
                        <span x-show="isLoading">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
