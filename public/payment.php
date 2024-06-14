<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="css/payment.css">
    <link rel="stylesheet" href="css/popup.css">
    <link rel="stylesheet" href="css/rental.css">
</head>
<body>

    <div class="payment-container">
        <div class="image-container">
        <img src="images\crs.jpg" alt="cars">
        </div>
        <div class="payment-form">
            <div class="total-price">
                <p>Total Harga yang harus dibayar</p>
                <?php
                    $total = isset($_GET['total']) ? $_GET['total'] : 'Rp. 0';
                    echo "<p>Rp. " . number_format($total, 0, ',', '.') . "</p>";
                ?>
            </div>
            <div class="payment-methods">
                <p>Metode Pembayaran</p>
                <button class="payment-button" onclick="showInvoice('ShopeePay')">ShopeePay</button>
                <button class="payment-button" onclick="showInvoice('Bank BNI')">Bank BNI</button>
                <button class="payment-button" onclick="showInvoice('OVO')">OVO</button>
            </div>
        </div>
    </div>

    <div class="modal" id="invoicePopup">
        <div class="modal-content">
            <div class="modal-header">
                <h1>Invoice</h1>
            </div>
            <div class="modal-body">
                <p>Terima kasih atas pemesanan Anda. Berikut adalah detail transaksi Anda:</p>
                <div id="invoiceContent">
                    <!-- Invoice details will be populated here -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="close-btn" onclick="closePopup()">Tutup</button>
                <button class="view-orders-btn colored-button" onclick="viewOrders()">Lihat Pesanan</button>
            </div>
        </div>
    </div>

    <script>
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        function showInvoice(paymentMethod) {
            const car = getUrlParameter('car');
            const name = getUrlParameter('name');
            const ktp = getUrlParameter('ktp');
            const address = getUrlParameter('address');
            const phone = getUrlParameter('phone');
            const package = getUrlParameter('package');
            const total = getUrlParameter('total');

            // Menentukan durasi paket berdasarkan nilai package
            let packageDuration = '';
            if (package === '3') {
                packageDuration = '3 hari';
            } else if (package === '5') {
                packageDuration = '5 hari';
            } else if (package === '7') {
                packageDuration = '1 minggu';
            }

            const invoiceContent = `
                <p>Mobil: ${car}</p>
                <p>Nama: ${name}</p>
                <p>No. KTP: ${ktp}</p>
                <p>Alamat: ${address}</p>
                <p>No. Telp/HP: ${phone}</p>
                <p>Paket: ${packageDuration}</p>
                <p>Metode Pembayaran: ${paymentMethod}</p>
                <p>Total Harga: Rp. ${Number(total).toLocaleString()}</p>
            `;

            document.getElementById('invoiceContent').innerHTML = invoiceContent;
            const modal = document.getElementById('invoicePopup');
            modal.style.display = 'block';
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        }

        function closePopup() {
            const modal = document.getElementById('invoicePopup');
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        function viewOrders() {
            window.location.href = 'list.php';
        }
    </script>
</body>
</html>
