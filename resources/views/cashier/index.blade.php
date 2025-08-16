<x-app-layout>
    <div x-data="{
        cart: [],
        products: {{ $products }},
        search: '',
        isLoading: false,
        message: '',
        amountPaid: '',

        get filteredProducts() {
            if (this.search === '') {
                return this.products;
            }
            return this.products.filter(product =>
                product.name.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        get change() {
            if (this.amountPaid === '' || isNaN(this.amountPaid) || this.amountPaid < this.total) {
                return 0;
            }
            return this.amountPaid - this.total;
        },
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
    }" class="h-full">
        <div class="flex h-full">
            <!-- Kolom Kiri: Daftar Produk -->
            <div class="w-3/5 p-6 overflow-y-auto">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Pilih Produk</h1>
                <div class="mb-6">
                    <input type="text" x-model.debounce.300ms="search" placeholder="Cari nama produk..." class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <div @click="addToCart(product)"
                             class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-xl hover:-translate-y-1 transition-all duration-200">
                            <div class="relative">
                                <div x-show="product.image">
                                    <img :src="`/storage/${product.image}`" :alt="product.name" class="w-full h-32 object-cover">
                                </div>
                                <div x-show="!product.image" class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-4xl text-gray-400"></i>
                                </div>
                                <div class="absolute top-2 right-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full" x-text="`Stok: ${product.stock}`"></div>
                            </div>
                            <div class="p-4">
                                <h2 class="font-semibold text-gray-800 truncate" x-text="product.name"></h2>
                                <p class="text-gray-600 font-bold mt-1" x-text="`Rp ${Number(product.price).toLocaleString('id-ID')}`"></p>
                            </div>
                        </div>
                    </template>
                     <div x-show="filteredProducts.length === 0" class="col-span-full text-center text-gray-500 py-10">
                        Tidak ada produk yang cocok dengan pencarian.
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Keranjang Belanja -->
            <div class="w-2/5 bg-white h-full p-6 shadow-lg flex flex-col border-l border-gray-200">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Keranjang</h1>

                <div x-show="message" x-text="message" class="p-4 mb-4 text-sm rounded-lg"
                    :class="{ 'bg-green-100 text-green-700': message.startsWith('Sukses'), 'bg-red-100 text-red-700': message.startsWith('Error') }">
                </div>

                <div class="flex-grow space-y-4 overflow-y-auto pr-2">
                    <template x-for="item in cart" :key="item.id">
                        <div class="flex items-center border-b pb-4">
                            <img :src="item.image ? `/storage/${item.image}` : 'https://via.placeholder.com/150'" class="w-16 h-16 object-cover rounded-lg mr-4">
                            <div class="flex-grow">
                                <p class="font-semibold" x-text="item.name"></p>
                                <p class="text-sm text-gray-600" x-text="`Rp ${Number(item.price).toLocaleString('id-ID')}`"></p>
                            </div>
                            <div class="flex items-center">
                                <input type="number" x-model.number="item.quantity" min="1" :max="item.stock" class="w-16 text-center border rounded-md">
                                <button @click="removeFromCart(item.id)" class="ml-3 text-gray-400 hover:text-red-500 transition">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                    <div x-show="cart.length === 0" class="text-center text-gray-400 py-10">
                        <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                        <p>Keranjang masih kosong.</p>
                    </div>
                </div>

                <div class="mt-auto pt-6 border-t space-y-4">
                    <div class="flex justify-between font-semibold text-lg text-gray-700">
                        <span>Total</span>
                        <span x-text="`Rp ${total.toLocaleString('id-ID')}`"></span>
                    </div>

                    <div>
                        <label for="amount_paid" class="block text-sm font-medium text-gray-700">Jumlah Uang Bayar</label>
                        <input type="number" id="amount_paid" x-model.number="amountPaid" placeholder="Masukkan jumlah uang"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-lg">
                    </div>

                    <div class="flex justify-between font-bold text-xl text-green-600" x-show="isPaidEnough">
                        <span>Kembalian</span>
                        <span x-text="`Rp ${change.toLocaleString('id-ID')}`"></span>
                    </div>

                    <button @click="processTransaction()" :disabled="!isPaidEnough || isLoading"
                            class="w-full bg-blue-600 text-white py-4 rounded-lg font-semibold text-lg hover:bg-blue-700 disabled:bg-blue-300 disabled:cursor-not-allowed flex items-center justify-center transition">
                        <span x-show="!isLoading">Proses Transaksi</span>
                        <span x-show="isLoading">
                            <i class="fas fa-spinner animate-spin mr-2"></i> Memproses...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
