import type { ActivityLog, Dispute, MenuItem, Order, Shop, User } from "@/types";

const u = (id: string, w = 800) => `https://images.unsplash.com/photo-${id}?auto=format&fit=crop&w=${w}&q=70`;

export const IMG = {
  hero: u("1512058564366-18510be2db19", 1400),
  canteen: u("1555396273-367ea4eb4db5", 1200),
  empty: u("1504674900247-0877df9cc836", 600),
};

export const CURRENT: Record<"admin" | "buyer" | "seller" | "driver", string> = {
  admin: "u1",
  buyer: "u2",
  seller: "u3",
  driver: "u4",
};

export const users: User[] = [
  { id: "u1", name: "Rina Kartika", email: "admin@kantinku.ac.id", phone: "0812-1111-0001", role: "admin", status: "active", joined: "2026-01-05", avatar: u("1438761681033-6461ffad8d80", 200) },
  { id: "u2", name: "Andi Pratama", email: "andi@student.ac.id", phone: "0812-2222-0002", role: "buyer", status: "active", joined: "2026-02-10", avatar: u("1500648767791-00dcc994a43e", 200), address: "Gedung Fakultas Teknik, Ruang 3.12" },
  { id: "u3", name: "Siti Aminah", email: "siti@warung.id", phone: "0813-3333-0003", role: "seller", status: "active", approval: "approved", joined: "2026-01-20", avatar: u("1494790108377-be9c29b29330", 200) },
  { id: "u4", name: "Budi Santoso", email: "budi.driver@kantinku.ac.id", phone: "0814-4444-0004", role: "driver", status: "active", joined: "2026-02-01", avatar: u("1500648767791-00dcc994a43e", 200) },
  { id: "u5", name: "Joko Susilo", email: "joko@warung.id", phone: "0815-5555-0005", role: "seller", status: "active", approval: "approved", joined: "2026-01-22", avatar: u("1500648767791-00dcc994a43e", 200) },
  { id: "u6", name: "Rahman Hakim", email: "cakman@warung.id", phone: "0816-6666-0006", role: "seller", status: "active", approval: "approved", joined: "2026-02-03", avatar: u("1500648767791-00dcc994a43e", 200) },
  { id: "u7", name: "Dewi Lestari", email: "dewi@warung.id", phone: "0817-7777-0007", role: "seller", status: "active", approval: "pending", joined: "2026-09-20", avatar: u("1438761681033-6461ffad8d80", 200) },
  { id: "u8", name: "Bagus Wicaksono", email: "bagus@warung.id", phone: "0818-8888-0008", role: "seller", status: "active", approval: "pending", joined: "2026-09-24", avatar: u("1500648767791-00dcc994a43e", 200) },
  { id: "u9", name: "Nadia Putri", email: "nadia@student.ac.id", phone: "0819-9999-0009", role: "buyer", status: "active", joined: "2026-03-14", avatar: u("1494790108377-be9c29b29330", 200), address: "Perpustakaan Pusat Lt. 2" },
  { id: "u10", name: "Rudi Hartono", email: "rudi.driver@kantinku.ac.id", phone: "0821-1010-0010", role: "driver", status: "inactive", joined: "2026-04-02", avatar: u("1500648767791-00dcc994a43e", 200) },
  { id: "u11", name: "Fajar Nugroho", email: "fajar@warung.id", phone: "0822-1111-0011", role: "seller", status: "active", approval: "approved", joined: "2026-02-11", avatar: u("1500648767791-00dcc994a43e", 200) },
];

export const shops: Shop[] = [
  { id: "s1", name: "Warung Bu Siti", ownerId: "u3", description: "Nasi rames, ayam goreng, dan masakan rumahan khas Jawa dengan porsi mahasiswa.", image: u("1555396273-367ea4eb4db5"), location: "Kantin Utama, Blok A-02", hours: "07.00 - 16.00", open: true, approval: "approved", submitted: "2026-01-21" },
  { id: "s2", name: "Mie Ayam Pak Joko", ownerId: "u5", description: "Mie ayam, bakso urat, dan pangsit goreng racikan sejak 2010.", image: u("1517248135467-4c7edcad34c4"), location: "Kantin Utama, Blok A-05", hours: "09.00 - 17.00", open: true, approval: "approved", submitted: "2026-01-23" },
  { id: "s3", name: "Kedai Kopi Kampus", ownerId: "u11", description: "Es kopi susu, teh, dan camilan untuk teman belajar.", image: u("1552566626-52f8b828add9"), location: "Kantin Teknik, Blok B-01", hours: "08.00 - 20.00", open: true, approval: "approved", submitted: "2026-02-12" },
  { id: "s4", name: "Soto & Sate Cak Man", ownerId: "u6", description: "Soto ayam Lamongan dan sate ayam bumbu kacang.", image: u("1414235077428-338989a2e8c0"), location: "Kantin Ekonomi, Blok C-03", hours: "10.00 - 15.00", open: false, approval: "approved", submitted: "2026-02-04" },
  { id: "s5", name: "Warung Sehat Dewi", ownerId: "u7", description: "Salad, gado-gado, dan menu rendah minyak.", image: u("1540189549336-e6e99c3679fe"), location: "Kantin Kedokteran, Blok D-01", hours: "08.00 - 14.00", open: false, approval: "pending", submitted: "2026-09-21" },
  { id: "s6", name: "Ayam Geprek Mas Bagus", ownerId: "u8", description: "Ayam geprek sambal bawang level 1-5.", image: u("1626804475297-41608ea09aeb"), location: "Kantin Utama, Blok A-08", hours: "10.00 - 18.00", open: false, approval: "pending", submitted: "2026-09-25" },
];

export const menus: MenuItem[] = [
  { id: "m1", shopId: "s1", name: "Nasi Goreng Spesial", description: "Nasi goreng telur, ayam suwir, kerupuk.", category: "Makanan", price: 15000, image: u("1512058564366-18510be2db19"), available: true },
  { id: "m2", shopId: "s1", name: "Nasi Ayam Goreng", description: "Ayam goreng bumbu kuning, sambal, lalapan.", category: "Makanan", price: 17000, image: u("1626804475297-41608ea09aeb"), available: true },
  { id: "m3", shopId: "s1", name: "Nasi Rames", description: "Nasi, sayur, tempe orek, telur balado.", category: "Makanan", price: 13000, image: u("1585032226651-759b368d7246"), available: true },
  { id: "m4", shopId: "s1", name: "Es Teh Manis", description: "Teh melati dingin.", category: "Minuman", price: 4000, image: u("1544145945-f90425340c7e"), available: false },
  { id: "m5", shopId: "s2", name: "Mie Ayam Bakso", description: "Mie ayam dengan 2 bakso urat.", category: "Makanan", price: 16000, image: u("1569058242253-92a9c755a0ec"), available: true },
  { id: "m6", shopId: "s2", name: "Mie Goreng Jawa", description: "Mie goreng kecap dengan sayur.", category: "Makanan", price: 14000, image: u("1534422298391-e4f8c172dddb"), available: true },
  { id: "m7", shopId: "s2", name: "Bakso Kuah", description: "Bakso sapi kuah kaldu.", category: "Makanan", price: 15000, image: u("1603133872878-684f208fb84b"), available: true },
  { id: "m8", shopId: "s3", name: "Es Kopi Susu Aren", description: "Espresso, susu segar, gula aren.", category: "Minuman", price: 18000, image: u("1551024709-8f23befc6f87"), available: true },
  { id: "m9", shopId: "s3", name: "Roti Bakar Telur", description: "Roti panggang dengan telur dan keju.", category: "Camilan", price: 12000, image: u("1482049016688-2d3e1b311543"), available: true },
  { id: "m10", shopId: "s3", name: "Pancake Madu", description: "Pancake lembut dengan madu.", category: "Camilan", price: 15000, image: u("1567620905732-2d1ec7ab7445"), available: true },
  { id: "m11", shopId: "s4", name: "Sate Ayam (10 tusuk)", description: "Sate ayam bumbu kacang dan lontong.", category: "Makanan", price: 20000, image: u("1555939594-58d7cb561ad1"), available: true },
  { id: "m12", shopId: "s4", name: "Soto Ayam Lamongan", description: "Soto kuning dengan koya.", category: "Makanan", price: 15000, image: u("1562967914-608f82629710"), available: true },
  { id: "m13", shopId: "s5", name: "Gado-gado", description: "Sayur rebus dengan saus kacang.", category: "Makanan", price: 14000, image: u("1546069901-ba9599a7e63c"), available: true },
  { id: "m14", shopId: "s3", name: "Puding Cokelat", description: "Puding lembut saus vla.", category: "Camilan", price: 8000, image: u("1565958011703-44f9829ba187"), available: true },
];

const it = (m: MenuItem, qty: number) => ({ menuId: m.id, name: m.name, image: m.image, price: m.price, qty });
const mk = (o: Omit<Order, "subtotal" | "total">): Order => {
  const subtotal = o.items.reduce((a, b) => a + b.price * b.qty, 0);
  return { ...o, subtotal, total: subtotal + o.deliveryFee };
};
const M = (id: string) => menus.find((m) => m.id === id)!;

export const orders: Order[] = [
  mk({ id: "ORD-1001", trxId: "TRX-9001", buyerId: "u2", shopId: "s1", items: [it(M("m1"), 2), it(M("m4"), 2)], deliveryFee: 3000, address: "Gedung Fakultas Teknik, Ruang 3.12", note: "Pedas sedang", paymentMethod: "QRIS", paymentStatus: "verified", proof: IMG.empty, status: "done", driverId: "u4", deliveryStatus: "done", createdAt: "2026-09-22T11:20:00" }),
  mk({ id: "ORD-1002", trxId: "TRX-9002", buyerId: "u9", shopId: "s1", items: [it(M("m2"), 1)], deliveryFee: 3000, address: "Perpustakaan Pusat Lt. 2", note: "", paymentMethod: "Transfer Bank", paymentStatus: "pending", proof: IMG.empty, status: "created", deliveryStatus: "waiting", createdAt: "2026-09-27T10:05:00" }),
  mk({ id: "ORD-1003", trxId: "TRX-9003", buyerId: "u2", shopId: "s1", items: [it(M("m3"), 1), it(M("m1"), 1)], deliveryFee: 3000, address: "Gedung Fakultas Teknik, Ruang 3.12", note: "", paymentMethod: "QRIS", paymentStatus: "verified", proof: IMG.empty, status: "processing", deliveryStatus: "waiting", createdAt: "2026-09-27T11:30:00" }),
  mk({ id: "ORD-1004", trxId: "TRX-9004", buyerId: "u9", shopId: "s2", items: [it(M("m5"), 2)], deliveryFee: 3000, address: "Gedung Rektorat, Lobby", note: "Tanpa sawi", paymentMethod: "E-Wallet", paymentStatus: "verified", proof: IMG.empty, status: "ready", deliveryStatus: "waiting", createdAt: "2026-09-27T11:45:00" }),
  mk({ id: "ORD-1005", trxId: "TRX-9005", buyerId: "u2", shopId: "s3", items: [it(M("m8"), 1), it(M("m9"), 1)], deliveryFee: 3000, address: "Gedung Fakultas Teknik, Ruang 3.12", note: "", paymentMethod: "QRIS", paymentStatus: "verified", proof: IMG.empty, status: "delivering", driverId: "u4", deliveryStatus: "onway", createdAt: "2026-09-27T12:10:00" }),
  mk({ id: "ORD-1006", trxId: "TRX-9006", buyerId: "u2", shopId: "s1", items: [it(M("m2"), 1)], deliveryFee: 3000, address: "Asrama Mahasiswa Blok C", note: "", paymentMethod: "Transfer Bank", paymentStatus: "verified", proof: IMG.empty, status: "ready", deliveryStatus: "waiting", createdAt: "2026-09-27T12:25:00" }),
  mk({ id: "ORD-1007", trxId: "TRX-9007", buyerId: "u9", shopId: "s4", items: [it(M("m11"), 1), it(M("m12"), 1)], deliveryFee: 3000, address: "Gedung FEB, Ruang 1.04", note: "", paymentMethod: "E-Wallet", paymentStatus: "rejected", proof: IMG.empty, status: "cancelled", deliveryStatus: "waiting", createdAt: "2026-09-24T13:00:00" }),
  mk({ id: "ORD-1008", trxId: "TRX-9008", buyerId: "u2", shopId: "s2", items: [it(M("m7"), 1)], deliveryFee: 3000, address: "Gedung Fakultas Teknik, Ruang 3.12", note: "", paymentMethod: "QRIS", paymentStatus: "verified", proof: IMG.empty, status: "done", driverId: "u4", deliveryStatus: "done", createdAt: "2026-09-25T12:40:00" }),
  mk({ id: "ORD-1009", trxId: "TRX-9009", buyerId: "u2", shopId: "s1", items: [it(M("m1"), 1)], deliveryFee: 3000, address: "Gedung Fakultas Teknik, Ruang 3.12", note: "", paymentMethod: "QRIS", paymentStatus: "unpaid", status: "created", deliveryStatus: "waiting", createdAt: "2026-09-27T12:50:00" }),
];

export const disputes: Dispute[] = [
  { id: "DSP-501", orderId: "ORD-1008", buyerId: "u2", issue: "Pesanan tidak sesuai", description: "Bakso yang diterima hanya 3 butir, seharusnya 5 butir.", status: "review", createdAt: "2026-09-25T14:00:00" },
  { id: "DSP-502", orderId: "ORD-1007", buyerId: "u9", issue: "Pembayaran ditolak padahal sudah transfer", description: "Saya sudah transfer via e-wallet namun pembayaran ditolak penjual.", proof: IMG.empty, status: "open", createdAt: "2026-09-24T15:10:00" },
  { id: "DSP-503", orderId: "ORD-1001", buyerId: "u2", issue: "Pengantaran terlambat", description: "Pesanan datang 40 menit setelah status siap diantar.", status: "resolved", resolution: "Driver telah diberi teguran.", createdAt: "2026-09-22T13:00:00" },
];

export const logs: ActivityLog[] = [
  { id: "l1", time: "2026-09-27T09:12:00", admin: "Rina Kartika", action: "Menyetujui penjual", target: "Fajar Nugroho (u11)", status: "success" },
  { id: "l2", time: "2026-09-26T15:40:00", admin: "Rina Kartika", action: "Menonaktifkan pengguna", target: "Rudi Hartono (u10)", status: "success" },
  { id: "l3", time: "2026-09-26T10:05:00", admin: "Rina Kartika", action: "Meninjau sengketa", target: "DSP-501", status: "success" },
  { id: "l4", time: "2026-09-25T08:30:00", admin: "Rina Kartika", action: "Ekspor laporan transaksi", target: "Laporan September 2026", status: "failed" },
];
