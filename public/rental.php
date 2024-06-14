<?php
include 'koneksi.php';
?>

<?php
session_start();

if (!isset($_SESSION['user_logged_in'])) {
    header('Location: login.php');
    exit();
}


$carName = urldecode($_GET['car']);
$sql = "SELECT stock FROM cars WHERE name=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $carName);
$stmt->execute();
$stmt->bind_result($stock);
$stmt->fetch();
$stmt->close();

if ($stock > 0) {
    $newStock = $stock - 1;
    $updateSql = "UPDATE cars SET stock=? WHERE name=?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("is", $newStock, $carName);
    $updateStmt->execute();
    $updateStmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Form</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/rental.css">
    <link rel="stylesheet" href="css/popup.css">
</head>
<body>
    <div class="rental-container">
        <h1>Transaksi</h1>
        <form id="rentalForm">
            <input type="text" id="car" name="car" placeholder="Mobil" readonly>
            <input type="text" id="name" name="name" placeholder="Nama lengkap" required>
            <input type="text" id="ktp" name="ktp" placeholder="No. KTP" required>
            <input type="text" id="address" name="address" placeholder="Alamat" required>
            <input type="tel" id="phone" name="phone" placeholder="No. telp/hp" required>
            <select id="package" name="package" required>
                <option value="" disabled selected>Paket Pemesanan</option>
                <option value="3">Paket 3 hari</option>
                <option value="5">Paket 5 hari</option>
                <option value="7">Paket 1 minggu</option>
            </select>
            <div class="total-price">Total Price: Rp.0</div>
            <br>
            <input type="hidden" id="packageDescription" name="packageDescription">
            <input type="hidden" id="totalPrice" name="totalPrice">
            <button type="submit">Metode Pembayaran</button>
        </form>
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

        document.getElementById('car').value = getUrlParameter('car');

        document.getElementById('package').addEventListener('change', function () {
            const package = this.value;
            let pricePerDay = 1000000;
            let totalPrice = 0;
            let packageDescription = '';

            if (package === '3') {
                totalPrice = pricePerDay * 3;
                packageDescription = 'Paket 3 hari';
            } else if (package === '5') {
                totalPrice = pricePerDay * 5;
                packageDescription = 'Paket 5 hari';
            } else if (package === '7') {
                totalPrice = pricePerDay * 7;
                packageDescription = 'Paket 1 minggu';
            }

            document.querySelector('.total-price').textContent = `Total Price: Rp.${totalPrice.toLocaleString()}`;
            document.getElementById('packageDescription').value = packageDescription;
            document.getElementById('totalPrice').value = totalPrice;
        });

        document.getElementById('rentalForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('process_rental.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = `payment.php?car=${getUrlParameter('car')}&name=${formData.get('name')}&ktp=${formData.get('ktp')}&address=${formData.get('address')}&phone=${formData.get('phone')}&package=${formData.get('package')}&total=${document.getElementById('totalPrice').value}`;
                } else {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            })
            .catch(error => console.error('Error:', error));
        });

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
