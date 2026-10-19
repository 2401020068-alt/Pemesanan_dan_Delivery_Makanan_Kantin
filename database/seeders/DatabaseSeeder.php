<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Shop;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Dispute;
use App\Models\ActivityLog;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $u = fn($id, $w = 800) => "https://images.unsplash.com/photo-{$id}?auto=format&fit=crop&w={$w}&q=70";

        // 1. Users
        $defaultPassword = Hash::make('password123');

        $users = [
            ['id' => 'u1', 'name' => 'Rina Kartika', 'email' => 'admin@kantinku.ac.id', 'phone' => '0812-1111-0001', 'role' => 'admin', 'status' => 'active', 'avatar' => $u('1438761681033-6461ffad8d80', 200), 'address' => 'Gedung Rektorat Lt. 2'],
            ['id' => 'u2', 'name' => 'Andi Pratama', 'email' => 'andi@student.ac.id', 'phone' => '0812-2222-0002', 'role' => 'buyer', 'status' => 'active', 'avatar' => $u('1500648767791-00dcc994a43e', 200), 'address' => 'Gedung Fakultas Teknik, Ruang 3.12'],
            ['id' => 'u3', 'name' => 'Siti Aminah', 'email' => 'siti@warung.id', 'phone' => '0813-3333-0003', 'role' => 'seller', 'status' => 'active', 'approval' => 'approved', 'avatar' => $u('1494790108377-be9c29b29330', 200), 'address' => 'Kantin Utama, Blok A-02'],
            ['id' => 'u4', 'name' => 'Budi Santoso', 'email' => 'budi.driver@kantinku.ac.id', 'phone' => '0814-4444-0004', 'role' => 'driver', 'status' => 'active', 'avatar' => $u('1500648767791-00dcc994a43e', 200), 'address' => 'Pos Driver Kantin Utama'],
            ['id' => 'u5', 'name' => 'Joko Susilo', 'email' => 'joko@warung.id', 'phone' => '0815-5555-0005', 'role' => 'seller', 'status' => 'active', 'approval' => 'approved', 'avatar' => $u('1500648767791-00dcc994a43e', 200), 'address' => 'Kantin Utama, Blok A-05'],
            ['id' => 'u6', 'name' => 'Rahman Hakim', 'email' => 'cakman@warung.id', 'phone' => '0816-6666-0006', 'role' => 'seller', 'status' => 'active', 'approval' => 'approved', 'avatar' => $u('1500648767791-00dcc994a43e', 200), 'address' => 'Kantin Ekonomi, Blok C-03'],
            ['id' => 'u7', 'name' => 'Dewi Lestari', 'email' => 'dewi@warung.id', 'phone' => '0817-7777-0007', 'role' => 'seller', 'status' => 'active', 'approval' => 'pending', 'avatar' => $u('1438761681033-6461ffad8d80', 200), 'address' => 'Kantin Kedokteran, Blok D-01'],
            ['id' => 'u8', 'name' => 'Bagus Wicaksono', 'email' => 'bagus@warung.id', 'phone' => '0818-8888-0008', 'role' => 'seller', 'status' => 'active', 'approval' => 'pending', 'avatar' => $u('1500648767791-00dcc994a43e', 200), 'address' => 'Kantin Utama, Blok A-08'],
            ['id' => 'u9', 'name' => 'Nadia Putri', 'email' => 'nadia@student.ac.id', 'phone' => '0819-9999-0009', 'role' => 'buyer', 'status' => 'active', 'avatar' => $u('1494790108377-be9c29b29330', 200), 'address' => 'Perpustakaan Pusat Lt. 2'],
            ['id' => 'u10', 'name' => 'Rudi Hartono', 'email' => 'rudi.driver@kantinku.ac.id', 'phone' => '0821-1010-0010', 'role' => 'driver', 'status' => 'inactive', 'avatar' => $u('1500648767791-00dcc994a43e', 200), 'address' => 'Pos Driver Barat'],
            ['id' => 'u11', 'name' => 'Fajar Nugroho', 'email' => 'fajar@warung.id', 'phone' => '0822-1111-0011', 'role' => 'seller', 'status' => 'active', 'approval' => 'approved', 'avatar' => $u('1500648767791-00dcc994a43e', 200), 'address' => 'Kantin Teknik, Blok B-01'],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['id' => $userData['id']],
                array_merge($userData, ['password' => $defaultPassword])
            );
        }

        // 2. Shops
        $shops = [
            ['id' => 's1', 'name' => 'Warung Bu Siti', 'owner_id' => 'u3', 'description' => 'Nasi rames, ayam goreng, dan masakan rumahan khas Jawa dengan porsi mahasiswa.', 'image' => $u('1555396273-367ea4eb4db5'), 'location' => 'Kantin Utama, Blok A-02', 'hours' => '07.00 - 16.00', 'open' => true, 'approval' => 'approved', 'submitted' => '2026-01-21'],
            ['id' => 's2', 'name' => 'Mie Ayam Pak Joko', 'owner_id' => 'u5', 'description' => 'Mie ayam, bakso urat, dan pangsit goreng racikan sejak 2010.', 'image' => $u('1517248135467-4c7edcad34c4'), 'location' => 'Kantin Utama, Blok A-05', 'hours' => '09.00 - 17.00', 'open' => true, 'approval' => 'approved', 'submitted' => '2026-01-23'],
            ['id' => 's3', 'name' => 'Kedai Kopi Kampus', 'owner_id' => 'u11', 'description' => 'Es kopi susu, teh, dan camilan untuk teman belajar.', 'image' => $u('1552566626-52f8b828add9'), 'location' => 'Kantin Teknik, Blok B-01', 'hours' => '08.00 - 20.00', 'open' => true, 'approval' => 'approved', 'submitted' => '2026-02-12'],
            ['id' => 's4', 'name' => 'Soto & Sate Cak Man', 'owner_id' => 'u6', 'description' => 'Soto ayam Lamongan dan sate ayam bumbu kacang.', 'image' => $u('1414235077428-338989a2e8c0'), 'location' => 'Kantin Ekonomi, Blok C-03', 'hours' => '10.00 - 15.00', 'open' => false, 'approval' => 'approved', 'submitted' => '2026-02-04'],
            ['id' => 's5', 'name' => 'Warung Sehat Dewi', 'owner_id' => 'u7', 'description' => 'Salad, gado-gado, dan menu rendah minyak.', 'image' => $u('1540189549336-e6e99c3679fe'), 'location' => 'Kantin Kedokteran, Blok D-01', 'hours' => '08.00 - 14.00', 'open' => false, 'approval' => 'pending', 'submitted' => '2026-09-21'],
            ['id' => 's6', 'name' => 'Ayam Geprek Mas Bagus', 'owner_id' => 'u8', 'description' => 'Ayam geprek sambal bawang level 1-5.', 'image' => $u('1626804475297-41608ea09aeb'), 'location' => 'Kantin Utama, Blok A-08', 'hours' => '10.00 - 18.00', 'open' => false, 'approval' => 'pending', 'submitted' => '2026-09-25'],
        ];

        foreach ($shops as $shopData) {
            Shop::updateOrCreate(['id' => $shopData['id']], $shopData);
        }

        // 3. Menu Items
        $menus = [
            ['id' => 'm1', 'shop_id' => 's1', 'name' => 'Nasi Goreng Spesial', 'description' => 'Nasi goreng telur, ayam suwir, kerupuk.', 'category' => 'Makanan', 'price' => 15000, 'image' => $u('1512058564366-18510be2db19'), 'available' => true],
            ['id' => 'm2', 'shop_id' => 's1', 'name' => 'Nasi Ayam Goreng', 'description' => 'Ayam goreng bumbu kuning, sambal, lalapan.', 'category' => 'Makanan', 'price' => 17000, 'image' => $u('1626804475297-41608ea09aeb'), 'available' => true],
            ['id' => 'm3', 'shop_id' => 's1', 'name' => 'Nasi Rames', 'description' => 'Nasi, sayur, tempe orek, telur balado.', 'category' => 'Makanan', 'price' => 13000, 'image' => $u('1585032226651-759b368d7246'), 'available' => true],
            ['id' => 'm4', 'shop_id' => 's1', 'name' => 'Es Teh Manis', 'description' => 'Teh melati dingin.', 'category' => 'Minuman', 'price' => 4000, 'image' => $u('1544145945-f90425340c7e'), 'available' => false],
            ['id' => 'm5', 'shop_id' => 's2', 'name' => 'Mie Ayam Bakso', 'description' => 'Mie ayam dengan 2 bakso urat.', 'category' => 'Makanan', 'price' => 16000, 'image' => $u('1569058242253-92a9c755a0ec'), 'available' => true],
            ['id' => 'm6', 'shop_id' => 's2', 'name' => 'Mie Goreng Jawa', 'description' => 'Mie goreng kecap dengan sayur.', 'category' => 'Makanan', 'price' => 14000, 'image' => $u('1534422298391-e4f8c172dddb'), 'available' => true],
            ['id' => 'm7', 'shop_id' => 's2', 'name' => 'Bakso Kuah', 'description' => 'Bakso sapi kuah kaldu.', 'category' => 'Makanan', 'price' => 15000, 'image' => $u('1603133872878-684f208fb84b'), 'available' => true],
            ['id' => 'm8', 'shop_id' => 's3', 'name' => 'Es Kopi Susu Aren', 'description' => 'Espresso, susu segar, gula aren.', 'category' => 'Minuman', 'price' => 18000, 'image' => $u('1551024709-8f23befc6f87'), 'available' => true],
            ['id' => 'm9', 'shop_id' => 's3', 'name' => 'Roti Bakar Telur', 'description' => 'Roti panggang dengan telur dan keju.', 'category' => 'Camilan', 'price' => 12000, 'image' => $u('1482049016688-2d3e1b311543'), 'available' => true],
            ['id' => 'm10', 'shop_id' => 's3', 'name' => 'Pancake Madu', 'description' => 'Pancake lembut dengan madu.', 'category' => 'Camilan', 'price' => 15000, 'image' => $u('1567620905732-2d1ec7ab7445'), 'available' => true],
            ['id' => 'm11', 'shop_id' => 's4', 'name' => 'Sate Ayam (10 tusuk)', 'description' => 'Sate ayam bumbu kacang dan lontong.', 'category' => 'Makanan', 'price' => 20000, 'image' => $u('1555939594-58d7cb561ad1'), 'available' => true],
            ['id' => 'm12', 'shop_id' => 's4', 'name' => 'Soto Ayam Lamongan', 'description' => 'Soto kuning dengan koya.', 'category' => 'Makanan', 'price' => 15000, 'image' => $u('1562967914-608f82629710'), 'available' => true],
            ['id' => 'm13', 'shop_id' => 's5', 'name' => 'Gado-gado', 'description' => 'Sayur rebus dengan saus kacang.', 'category' => 'Makanan', 'price' => 14000, 'image' => $u('1546069901-ba9599a7e63c'), 'available' => true],
            ['id' => 'm14', 'shop_id' => 's3', 'name' => 'Puding Cokelat', 'description' => 'Puding lembut saus vla.', 'category' => 'Camilan', 'price' => 8000, 'image' => $u('1565958011703-44f9829ba187'), 'available' => true],
        ];

        foreach ($menus as $menuData) {
            MenuItem::updateOrCreate(['id' => $menuData['id']], $menuData);
        }

        // 4. Orders and OrderItems
        $orders = [
            [
                'id' => 'ORD-1001', 'trx_id' => 'TRX-9001', 'buyer_id' => 'u2', 'shop_id' => 's1', 'driver_id' => 'u4',
                'subtotal' => 38000, 'delivery_fee' => 3000, 'total' => 41000,
                'address' => 'Gedung Fakultas Teknik, Ruang 3.12', 'note' => 'Pedas sedang',
                'payment_method' => 'QRIS', 'payment_status' => 'verified', 'proof' => $u('1555396273-367ea4eb4db5', 400),
                'status' => 'done', 'delivery_status' => 'done', 'created_at' => '2026-09-22 11:20:00',
                'items' => [
                    ['menu_id' => 'm1', 'name' => 'Nasi Goreng Spesial', 'price' => 15000, 'qty' => 2, 'image' => $u('1512058564366-18510be2db19')],
                    ['menu_id' => 'm4', 'name' => 'Es Teh Manis', 'price' => 4000, 'qty' => 2, 'image' => $u('1544145945-f90425340c7e')],
                ]
            ],
            [
                'id' => 'ORD-1002', 'trx_id' => 'TRX-9002', 'buyer_id' => 'u9', 'shop_id' => 's1', 'driver_id' => null,
                'subtotal' => 17000, 'delivery_fee' => 3000, 'total' => 20000,
                'address' => 'Perpustakaan Pusat Lt. 2', 'note' => '',
                'payment_method' => 'Transfer Bank', 'payment_status' => 'pending', 'proof' => $u('1555396273-367ea4eb4db5', 400),
                'status' => 'created', 'delivery_status' => 'waiting', 'created_at' => '2026-09-27 10:05:00',
                'items' => [
                    ['menu_id' => 'm2', 'name' => 'Nasi Ayam Goreng', 'price' => 17000, 'qty' => 1, 'image' => $u('1626804475297-41608ea09aeb')],
                ]
            ],
            [
                'id' => 'ORD-1003', 'trx_id' => 'TRX-9003', 'buyer_id' => 'u2', 'shop_id' => 's1', 'driver_id' => null,
                'subtotal' => 28000, 'delivery_fee' => 3000, 'total' => 31000,
                'address' => 'Gedung Fakultas Teknik, Ruang 3.12', 'note' => '',
                'payment_method' => 'QRIS', 'payment_status' => 'verified', 'proof' => $u('1555396273-367ea4eb4db5', 400),
                'status' => 'processing', 'delivery_status' => 'waiting', 'created_at' => '2026-09-27 11:30:00',
                'items' => [
                    ['menu_id' => 'm3', 'name' => 'Nasi Rames', 'price' => 13000, 'qty' => 1, 'image' => $u('1585032226651-759b368d7246')],
                    ['menu_id' => 'm1', 'name' => 'Nasi Goreng Spesial', 'price' => 15000, 'qty' => 1, 'image' => $u('1512058564366-18510be2db19')],
                ]
            ],
            [
                'id' => 'ORD-1004', 'trx_id' => 'TRX-9004', 'buyer_id' => 'u9', 'shop_id' => 's2', 'driver_id' => null,
                'subtotal' => 32000, 'delivery_fee' => 3000, 'total' => 35000,
                'address' => 'Gedung Rektorat, Lobby', 'note' => 'Tanpa sawi',
                'payment_method' => 'E-Wallet', 'payment_status' => 'verified', 'proof' => $u('1555396273-367ea4eb4db5', 400),
                'status' => 'ready', 'delivery_status' => 'waiting', 'created_at' => '2026-09-27 11:45:00',
                'items' => [
                    ['menu_id' => 'm5', 'name' => 'Mie Ayam Bakso', 'price' => 16000, 'qty' => 2, 'image' => $u('1569058242253-92a9c755a0ec')],
                ]
            ],
            [
                'id' => 'ORD-1005', 'trx_id' => 'TRX-9005', 'buyer_id' => 'u2', 'shop_id' => 's3', 'driver_id' => 'u4',
                'subtotal' => 30000, 'delivery_fee' => 3000, 'total' => 33000,
                'address' => 'Gedung Fakultas Teknik, Ruang 3.12', 'note' => '',
                'payment_method' => 'QRIS', 'payment_status' => 'verified', 'proof' => $u('1555396273-367ea4eb4db5', 400),
                'status' => 'delivering', 'delivery_status' => 'onway', 'created_at' => '2026-09-27 12:10:00',
                'items' => [
                    ['menu_id' => 'm8', 'name' => 'Es Kopi Susu Aren', 'price' => 18000, 'qty' => 1, 'image' => $u('1551024709-8f23befc6f87')],
                    ['menu_id' => 'm9', 'name' => 'Roti Bakar Telur', 'price' => 12000, 'qty' => 1, 'image' => $u('1482049016688-2d3e1b311543')],
                ]
            ],
            [
                'id' => 'ORD-1006', 'trx_id' => 'TRX-9006', 'buyer_id' => 'u2', 'shop_id' => 's1', 'driver_id' => null,
                'subtotal' => 17000, 'delivery_fee' => 3000, 'total' => 20000,
                'address' => 'Asrama Mahasiswa Blok C', 'note' => '',
                'payment_method' => 'Transfer Bank', 'payment_status' => 'verified', 'proof' => $u('1555396273-367ea4eb4db5', 400),
                'status' => 'ready', 'delivery_status' => 'waiting', 'created_at' => '2026-09-27 12:25:00',
                'items' => [
                    ['menu_id' => 'm2', 'name' => 'Nasi Ayam Goreng', 'price' => 17000, 'qty' => 1, 'image' => $u('1626804475297-41608ea09aeb')],
                ]
            ],
            [
                'id' => 'ORD-1007', 'trx_id' => 'TRX-9007', 'buyer_id' => 'u9', 'shop_id' => 's4', 'driver_id' => null,
                'subtotal' => 35000, 'delivery_fee' => 3000, 'total' => 38000,
                'address' => 'Gedung FEB, Ruang 1.04', 'note' => '',
                'payment_method' => 'E-Wallet', 'payment_status' => 'rejected', 'proof' => $u('1555396273-367ea4eb4db5', 400),
                'status' => 'cancelled', 'delivery_status' => 'waiting', 'created_at' => '2026-09-24 13:00:00',
                'items' => [
                    ['menu_id' => 'm11', 'name' => 'Sate Ayam (10 tusuk)', 'price' => 20000, 'qty' => 1, 'image' => $u('1555939594-58d7cb561ad1')],
                    ['menu_id' => 'm12', 'name' => 'Soto Ayam Lamongan', 'price' => 15000, 'qty' => 1, 'image' => $u('1562967914-608f82629710')],
                ]
            ],
            [
                'id' => 'ORD-1008', 'trx_id' => 'TRX-9008', 'buyer_id' => 'u2', 'shop_id' => 's2', 'driver_id' => 'u4',
                'subtotal' => 15000, 'delivery_fee' => 3000, 'total' => 18000,
                'address' => 'Gedung Fakultas Teknik, Ruang 3.12', 'note' => '',
                'payment_method' => 'QRIS', 'payment_status' => 'verified', 'proof' => $u('1555396273-367ea4eb4db5', 400),
                'status' => 'done', 'delivery_status' => 'done', 'created_at' => '2026-09-25 12:40:00',
                'items' => [
                    ['menu_id' => 'm7', 'name' => 'Bakso Kuah', 'price' => 15000, 'qty' => 1, 'image' => $u('1603133872878-684f208fb84b')],
                ]
            ],
            [
                'id' => 'ORD-1009', 'trx_id' => 'TRX-9009', 'buyer_id' => 'u2', 'shop_id' => 's1', 'driver_id' => null,
                'subtotal' => 15000, 'delivery_fee' => 3000, 'total' => 18000,
                'address' => 'Gedung Fakultas Teknik, Ruang 3.12', 'note' => '',
                'payment_method' => 'QRIS', 'payment_status' => 'unpaid', 'proof' => null,
                'status' => 'created', 'delivery_status' => 'waiting', 'created_at' => '2026-09-27 12:50:00',
                'items' => [
                    ['menu_id' => 'm1', 'name' => 'Nasi Goreng Spesial', 'price' => 15000, 'qty' => 1, 'image' => $u('1512058564366-18510be2db19')],
                ]
            ],
        ];

        foreach ($orders as $orderData) {
            $items = $orderData['items'];
            unset($orderData['items']);

            $order = Order::updateOrCreate(['id' => $orderData['id']], $orderData);

            $order->items()->delete();
            foreach ($items as $itemData) {
                $order->items()->create($itemData);
            }
        }

        // 5. Disputes
        $disputes = [
            ['id' => 'DSP-501', 'order_id' => 'ORD-1008', 'buyer_id' => 'u2', 'issue' => 'Pesanan tidak sesuai', 'description' => 'Bakso yang diterima hanya 3 butir, seharusnya 5 butir.', 'proof' => null, 'status' => 'review', 'resolution' => null, 'created_at' => '2026-09-25 14:00:00'],
            ['id' => 'DSP-502', 'order_id' => 'ORD-1007', 'buyer_id' => 'u9', 'issue' => 'Pembayaran ditolak padahal sudah transfer', 'description' => 'Saya sudah transfer via e-wallet namun pembayaran ditolak penjual.', 'proof' => $u('1555396273-367ea4eb4db5', 400), 'status' => 'open', 'resolution' => null, 'created_at' => '2026-09-24 15:10:00'],
            ['id' => 'DSP-503', 'order_id' => 'ORD-1001', 'buyer_id' => 'u2', 'issue' => 'Pengantaran terlambat', 'description' => 'Pesanan datang 40 menit setelah status siap diantar.', 'proof' => null, 'status' => 'resolved', 'resolution' => 'Kurir telah diberi teguran edukasi sistem dan kompensasi ongkir disetujui.', 'created_at' => '2026-09-22 13:00:00'],
        ];

        foreach ($disputes as $disputeData) {
            Dispute::updateOrCreate(['id' => $disputeData['id']], $disputeData);
        }

        // 6. Activity Logs
        $logs = [
            ['id' => 'l1', 'time' => '2026-09-27 09:12:00', 'admin' => 'Rina Kartika', 'action' => 'Menyetujui penjual', 'target' => 'Fajar Nugroho (u11)', 'status' => 'success'],
            ['id' => 'l2', 'time' => '2026-09-26 15:40:00', 'admin' => 'Rina Kartika', 'action' => 'Menonaktifkan pengguna', 'target' => 'Rudi Hartono (u10)', 'status' => 'success'],
            ['id' => 'l3', 'time' => '2026-09-26 10:05:00', 'admin' => 'Rina Kartika', 'action' => 'Meninjau sengketa', 'target' => 'DSP-501', 'status' => 'success'],
            ['id' => 'l4', 'time' => '2026-09-25 08:30:00', 'admin' => 'Rina Kartika', 'action' => 'Ekspor laporan transaksi', 'target' => 'Laporan September 2026', 'status' => 'failed'],
        ];

        foreach ($logs as $logData) {
            ActivityLog::updateOrCreate(['id' => $logData['id']], $logData);
        }
    }
}
