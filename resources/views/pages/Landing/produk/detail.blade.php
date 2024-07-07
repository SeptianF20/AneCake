@extends('pages.landing.product')
@section('title')
    Produk | Anecake
@endsection
@section('content')
    <section class="bg-base-200 p-8">
        <div class="container mx-auto mt-10">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Pilih Produk yang Anda Pesan</h1>
                <div>
                    <label for="order-date" class="mr-2 text-lg">Pilih Tanggal:</label>
                    <input type="date" id="order-date" name="order-date" class="input input-bordered p-2 rounded-lg border-gray-300 focus:ring focus:ring-blue-200 focus:border-blue-500" required>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                @foreach ($products as $item)
                    <div class="card w-full bg-base-100 shadow-xl">
                        <div class="card-body flex items-center justify-between">
                            <div class="flex"> <!-- Container untuk checkbox, gambar, nama, dan harga -->
                                <input type="checkbox" class="checkbox checkbox-primary mr-2" data-id="{{ $item->id }}" data-stock="{{ $item->stock }}"                                  onchange="toggleQuantity(this, '{{ $item->id }}')" {{ $item->stock == 0 ? 'disabled' : '' }} disabled>
                                <figure class="flex-shrink-0">
                                    <img src="{{ $item->thumbnail }}" alt="{{ $item->name }}"
                                        class="h-16 w-16 object-cover rounded-lg">
                                </figure>
                                <div class="ml-4"> <!-- Memberi margin kiri untuk memisahkan dari gambar -->
                                    <h2 class="card-title text-sm sm:text-base md:text-lg lg:text-xl">{{ $item->name }}</h2>
                                    <p class="text-lg font-semibold text-gray-700" data-role="harga">{{ moneyFormat($item->price) }}</p>
                                    @if($item->stock > 0)
                                        <p class="text-lg font-semibold text-gray-700">Stok: {{ $item->stock }}</p>
                                    @else
                                        <div class="badge badge-outline text-red-500">Stok habis</div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center mt-4 md:mt-0" id="quantity-container-{{ $item->id }}"> <!-- Container untuk tombol kuantitas -->
                                <button class="btn btn-outline btn-primary" onclick="changeQuantity('{{ $item->id }}', -1)">-</button>
                                <input type="number" id="quantity-{{ $item->id }}" value="0" min="0"
                                    class="input input-bordered w-16 mx-2 text-center" readonly>
                                <button class="btn btn-outline btn-primary" onclick="changeQuantity('{{ $item->id }}', 1)">+</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>            

            <div class="card mt-5">
                <div class="card-body">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <h1 class="text-xl md:text-2xl">Total Pembayaran</h1>
                        <h2 id="total-pembayaran" class="text-lg md:text-xl mt-3 md:mt-0 md:ml-4">Rp 0</h2>
                    </div>
                    <div class="mt-4">
                        <form action="">
                            <button class="btn btn-primary btn-block text-white" type="button"
                                onclick="showModal()">Checkout</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </section>
    <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle -z-10">
        <div class="modal-box bg-white p-6 rounded-lg shadow-lg">
            <h3 class="font-bold text-lg text-center mb-6">Detail Pesanan</h3>
            <form id="editForm" method="POST" action="">
                @csrf
                <input type="hidden" name="id" id="modal-id">
                <div class="py-4">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left">Nama Produk</th>
                                <th class="px-4 py-2 text-left">Kuantiti</th>
                                <th class="px-4 py-2 text-left">Harga</th>
                                <th class="px-4 py-2 text-left">Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody id="modal-tbody">
                            <!-- Data produk akan diisi disini -->
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-100">
                                <td colspan="3" class="px-4 py-2 text-left font-bold text-md">Jumlah Bayar</td>
                                <td id="modal-total-pembayaran" class="px-4 py-2 font-bold text-md">Rp 0</td>
                            </tr>
                            <tr class="bg-gray-100">
                                <td colspan="3" class="px-4 py-2 text-left font-bold text-md">Metode Pembayaran
                                </td>
                                <td class="px-4 py-2 font-bold text-md">Payment Gateway</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="flex justify-end mt-6">
                    <form id="transactionForm" method="POST" action="">
                        @csrf
                        <input type="hidden" id="transactionData" name="transactionData">
                        <button type="submit" class="btn btn-primary mr-2 text-white" id="btn-bayar">Bayar</button>
                        <button type="button" class="btn btn-outline" onclick="closeModal()">Close</button>
                    </form>
                </div>
            </form>
        </div>
    </dialog>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script>
        var totalBayar;
        document.addEventListener('DOMContentLoaded', function() {
        const orderDateInput = document.getElementById('order-date');

        orderDateInput.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                const stock = checkbox.getAttribute('data-stock');
                if (orderDateInput.value && stock > 0) {
                    checkbox.removeAttribute('disabled');
                } else {
                    checkbox.setAttribute('disabled', 'disabled');
                }
            });
        });

        window.toggleQuantity = function(checkbox, id) {
            const input = document.getElementById(`quantity-${id}`);
            if (checkbox.checked) {
                input.removeAttribute('readonly');
            } else {
                input.setAttribute('readonly', 'readonly');
                input.value = 0; // Reset quantity to 0 if checkbox is unchecked
            }
            calculateTotal();
        }

        window.changeQuantity = function(id, amount) {
            const input = document.getElementById(`quantity-${id}`);
            const checkbox = input.parentElement.parentElement.querySelector('input[type="checkbox"]');
            if (checkbox.checked) {
                let currentValue = parseInt(input.value);
                let newValue = currentValue + amount;
                if (newValue >= 0) {
                    input.value = newValue;
                }
            }
            calculateTotal();
        }

        window.calculateTotal = function() {
            let total = 0;
            const quantities = document.querySelectorAll('input[type="number"]');
            const prices = document.querySelectorAll('[data-role="harga"]');
            quantities.forEach((quantity, index) => {
                total += parseInt(quantity.value) * parseInt(prices[index].innerText.replace(/\D/g, ''));
            });
            document.getElementById('total-pembayaran').innerText = `Rp ${total.toLocaleString()}`;
        }

        window.showModal = function() {
            var modal = document.getElementById('my_modal_5');
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            var modalTable = modal.querySelector('table tbody');
            var totalBayar = 0;
            var formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });

            modalTable.innerHTML = '';

            checkboxes.forEach(function(checkbox) {
                var item = checkbox.closest('.card-body');
                var namaProduk = item.querySelector('.card-title').innerText;
                var kuantiti = parseInt(item.querySelector('input[type="number"]').value);
                var hargaProduk = parseInt(item.querySelector('[data-role="harga"]').innerText.replace(/\D/g, ''));
                var totalProduk = kuantiti * hargaProduk;

                modalTable.innerHTML += `
                <tr>
                    <td class="px-4 py-2 text-left">${namaProduk}</td>
                    <td class="px-4 py-2 text-left">${kuantiti}</td>
                    <td class="px-4 py-2 text-left">${formatter.format(hargaProduk)}</td>
                    <td class="px-4 py-2 text-left">${formatter.format(totalProduk)}</td>
                </tr>`;

                totalBayar += totalProduk;
            });

            var modalTotalPembayaran = document.getElementById('modal-total-pembayaran');
            modalTotalPembayaran.innerText = formatter.format(totalBayar);

            modal.showModal();
        }

        window.closeModal = function() {
            var modal = document.getElementById('my_modal_5');
            modal.close();
        }

        window.sendDataToController = function() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            var totalPembayaran = document.getElementById('modal-total-pembayaran').innerText.replace(/\D/g, '');
            var orderDate = document.getElementById('order-date').value;

            var transactionData = {
                items: [],
                totalPembayaran: totalPembayaran,
                orderDate: orderDate
            };

            checkboxes.forEach(function(checkbox) {
                var item = checkbox.closest('.card-body');
                var idProduk = checkbox.getAttribute('data-id');
                var namaProduk = item.querySelector('.card-title').innerText;
                var kuantiti = parseInt(item.querySelector('input[type="number"]').value);
                var hargaProduk = parseInt(item.querySelector('[data-role="harga"]').innerText.replace(/\D/g, ''));

                transactionData.items.push({
                    idProduk: idProduk,
                    namaProduk: namaProduk,
                    kuantiti: kuantiti,
                    hargaProduk: hargaProduk
                });
            });

            // Kirim data transaksi ke controller untuk mendapatkan snapToken
            fetch('{{ route('product.snaptoken') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(transactionData)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(text)
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    snap.pay(data.snapToken, {
                        onSuccess: function(result) {
                            // Tambahkan data tambahan untuk transaksi
                            transactionData.order_id = result.order_id;
                            transactionData.transaction_status = result.transaction_status;
                            transactionData.gross_amount = result.gross_amount;
                            transactionData.payment_type = result.payment_type;
                            transactionData.transaction_time = result.transaction_time;

                            // Kirim data transaksi ke controller untuk disimpan
                            fetch('{{ route('product.storeTransaction') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify(transactionData)
                            })
                            .then(response => {
                                console.log('Server response:', response);
                                if (!response.ok) {
                                    return response.text().then(text => {
                                        throw new Error(text)
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                alert('Payment succeeded and data stored successfully.');
                                window.location.reload();
                            })
                            .catch(error => console.error('Error storing transaction data:', error));
                        },
                        onPending: function(result) {
                            alert('Payment is pending');
                        },
                        onError: function(result) {
                            alert('Payment failed');
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        }


        document.getElementById('btn-bayar').onclick = function(event) {
            event.preventDefault();
            sendDataToController();
            closeModal();
        };
    });

    </script>
@endsection
