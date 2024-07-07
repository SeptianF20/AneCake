{{-- @extends('pages.landing.product')
@section('title')
    Topup | Anecake
@endsection
@section('content')
    <section class="bg-base-200 p-8">
        <div class="container min-h-screen mt-10">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-primary">Top Up</h1>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Nama</span>
                        </div>
                        <input type="text" value="{{ $member->nama }}" class="input input-bordered w-full max-w-xs"
                            readonly />
                    </label>
                    <label class="form-control w-full max-w-xs mt-4">
                        <div class="label">
                            <span class="label-text">Saldo Anda Sekarang</span>
                        </div>
                        <input type="text" value="{{ moneyformat($saldo ? $saldo->saldo : 'Saldo tidak ditemukan') }}"
                            class="input input-bordered w-full max-w-xs" readonly />
                    </label>
                    <div class="mt-6">
                        <button class="btn btn-primary btn-block text-white" type="button" onclick="showModal()">Top
                            Up</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box bg-white p-6 rounded-lg shadow-lg">
            <h3 class="font-bold text-lg text-center mb-6">Top Up Saldo</h3>
            <form id="topupForm" method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label class="label">
                        <span class="label-text">Jumlah Top Up</span>
                    </label>
                    <input type="number" name="amount" class="input input-bordered w-full"
                        placeholder="Masukkan jumlah saldo" required />
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary text-white mr-2" id="btn-topup">Top Up</button>
                    <button type="button" class="btn btn-outline" onclick="closeModal()">Close</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            window.showModal = function() {
                var modal = document.getElementById('my_modal_5');
                modal.showModal();
            }

            window.closeModal = function() {
                var modal = document.getElementById('my_modal_5');
                modal.close();
            }

            document.getElementById('topupForm').onsubmit = function(event) {
                event.preventDefault();
                var form = this;

                var transactionData = {
                    amount: form.amount.value,
                };

                // Send transaction data to the controller
                fetch('{{ route('topup.checkout') }}', {
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
                        // Initiate the payment process with Midtrans Snap
                        snap.pay(data.snapToken, {
                            onSuccess: function(result) {
                                saveTransaction(result);
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
                document.getElementById('btn-topup').onclick = function(event) {
                    event.preventDefault();
                    sendDataToController();
                    closeModal();
                };
            };

            function saveTransaction(result) {
                const transactionData = {
                    orderId: result.order_id,
                    transactionStatus: result.transaction_status,
                    grossAmount: result.gross_amount,
                    paymentType: result.payment_type,
                    transactionTime: result.transaction_time,
                };

                fetch('{{ route('topup.update') }}', {
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
                                throw new Error(text);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Transaction saved:', data);
                    })
                    .catch(error => {
                        console.error('Error saving transaction:', error);
                    });
            }

        });
    </script>
@endsection --}}

@extends('pages.landing.product')
@section('title')
    Topup | Anecake
@endsection
@section('content')
    <section class="bg-base-200 p-8">
        <div class="container min-h-screen mt-10">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-primary">Top Up</h1>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Nama</span>
                        </div>
                        {{-- <input type="text" value="{{ $saldo->nama }}" class="input input-bordered w-full max-w-xs"
                            readonly /> --}}
                    </label>
                    <label class="form-control w-full max-w-xs mt-4">
                        <div class="label">
                            <span class="label-text">Saldo Anda Sekarang</span>
                        </div>
                        {{-- <input type="text" value="{{ moneyformat($saldo ? $saldo->saldo : 'Saldo tidak ditemukan') }}"
                            class="input input-bordered w-full max-w-xs" readonly /> --}}
                    </label>

                    <form id="topupForm" class="mt-6">
                        @csrf
                        <div class="mb-4">
                            <label class="label">
                                <span class="label-text">Jumlah Top Up</span>
                            </label>
                            <input type="number" name="amount" class="input input-bordered w-full"
                                placeholder="Masukkan jumlah saldo" required />
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="btn btn-primary text-white" id="btn-topup" data-id="{{$member->id}}">Top Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('topupForm').onsubmit = function(event) {
                event.preventDefault();
                var form = this;

                var memberId = document.getElementById('btn-topup').getAttribute('data-id');

                var transactionData = {
                    amount: form.amount.value,
                };

                // Send transaction data to the controller
                fetch('{{ route('topup.checkout') }}', {
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
                        // Initiate the payment process with Midtrans Snap
                        snap.pay(data.snapToken, {
                            onSuccess: function(result) {
                                // Call the update saldo API
                                fetch('{{ route('topup.updateSaldo') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        memberId: memberId,
                                        amount: transactionData.amount
                                    })
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
                                    alert('Payment succeeded and saldo updated!');
                                    location.reload(); // Reload the page
                                })
                                .catch(error => console.error('Error:', error));
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
            };
        });

    </script>
@endsection
