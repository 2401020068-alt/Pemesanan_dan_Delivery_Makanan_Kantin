import { CheckCircle2, ChefHat, ClipboardList, CreditCard, Clock, Package, PackageCheck, Truck } from "lucide-react";

export const ORDER_STEPS = [
  { label: "Pesanan Dibuat", icon: ClipboardList },
  { label: "Pembayaran", icon: CreditCard },
  { label: "Diproses", icon: ChefHat },
  { label: "Siap Diantar", icon: PackageCheck },
  { label: "Diantar", icon: Truck },
  { label: "Selesai", icon: CheckCircle2 },
];

export const DELIVERY_STEPS = [
  { label: "Menunggu Diambil", icon: Clock },
  { label: "Diambil", icon: Package },
  { label: "Dalam Pengantaran", icon: Truck },
  { label: "Selesai", icon: CheckCircle2 },
];
