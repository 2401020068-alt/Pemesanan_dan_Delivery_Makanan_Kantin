import type { Order } from "@/types";

export const rp = (n: number) => "Rp" + n.toLocaleString("id-ID");
export const fmtDate = (s: string) =>
  new Date(s).toLocaleDateString("id-ID", { day: "numeric", month: "short", year: "numeric" });
export const fmtDateTime = (s: string) =>
  new Date(s).toLocaleString("id-ID", { day: "numeric", month: "short", hour: "2-digit", minute: "2-digit" });

export type Tone = "success" | "warning" | "error" | "info" | "neutral";

export const LABELS: Record<string, [string, Tone]> = {
  // order
  created: ["Menunggu Pembayaran", "neutral"],
  paid: ["Dibayar", "info"],
  processing: ["Diproses", "info"],
  ready: ["Siap Diantar", "warning"],
  delivering: ["Diantar", "info"],
  done: ["Selesai", "success"],
  cancelled: ["Dibatalkan", "error"],
  // payment
  unpaid: ["Belum Bayar", "neutral"],
  pending: ["Menunggu Verifikasi", "warning"],
  verified: ["Terverifikasi", "success"],
  rejected: ["Ditolak", "error"],
  approved: ["Disetujui", "success"],
  // delivery
  waiting: ["Menunggu Diambil", "neutral"],
  picked: ["Diambil", "info"],
  onway: ["Dalam Pengantaran", "warning"],
  // dispute
  open: ["Terbuka", "warning"],
  review: ["Ditinjau", "info"],
  resolved: ["Selesai", "success"],
  // user
  active: ["Aktif", "success"],
  inactive: ["Nonaktif", "neutral"],
  success: ["Berhasil", "success"],
  failed: ["Gagal", "error"],
};

export const ROLE_LABEL = { admin: "Admin", buyer: "Pembeli", seller: "Penjual", driver: "Driver" } as const;

export function orderStep(o: Order) {
  if (o.status === "created") return o.paymentStatus === "pending" ? 1 : 0;
  return { paid: 2, processing: 2, ready: 3, delivering: 4, done: 6, cancelled: 0 }[o.status];
}
export const deliveryStep = (o: Order) => ({ waiting: 0, picked: 1, onway: 2, done: 4 })[o.deliveryStatus];
