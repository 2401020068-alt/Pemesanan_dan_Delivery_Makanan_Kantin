import { createFileRoute, Link } from "@tanstack/react-router";
import { ArrowRight, CheckCircle2, ChefHat, ClipboardList, CreditCard, Store } from "lucide-react";
import { useLookup, useStore } from "@/lib/store";
import { CURRENT } from "@/data/mockData";
import { OpenBadge } from "@/components/cards";
import { Button, Card, Img, PageHeader, StatCard, StatusBadge } from "@/components/ui/kit";
import { fmtDateTime, rp } from "@/lib/format";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/seller/")({
  head: () => seo("Dashboard Penjual", "Ringkasan operasional warung hari ini."),
  component: SellerDash,
});

export function useMyShop() {
  const { state } = useStore();
  return state.shops.find((s) => s.ownerId === CURRENT.seller)!;
}

function SellerDash() {
  const { state, updateShop } = useStore();
  const { user } = useLookup();
  const shop = useMyShop();
  const orders = state.orders.filter((o) => o.shopId === shop.id);
  const baru = orders.filter((o) => o.status === "paid" || (o.status === "created" && o.paymentStatus !== "rejected"));
  const proses = orders.filter((o) => o.status === "processing" || o.status === "ready" || o.status === "delivering");
  const selesai = orders.filter((o) => o.status === "done");
  const verif = orders.filter((o) => o.paymentStatus === "pending");
  return (
    <div className="space-y-6">
      <PageHeader title={`Halo, ${user(CURRENT.seller)?.name.split(" ")[0]}`} subtitle="Berikut kondisi operasional warung Anda." />
      <Card className="flex flex-col gap-4 p-5 sm:flex-row sm:items-center">
        <Img src={shop.image} alt={shop.name} className="h-20 w-full rounded-xl sm:w-32" />
        <div className="flex-1"><div className="flex items-center gap-2"><p className="font-display font-semibold">{shop.name}</p><OpenBadge open={shop.open} /></div><p className="text-sm text-muted-foreground">{shop.location} · {shop.hours}</p></div>
        <Button variant={shop.open ? "outline" : "primary"} icon={Store} onClick={() => updateShop(shop.id, { open: !shop.open })}>{shop.open ? "Tutup Warung" : "Buka Warung"}</Button>
      </Card>
      <div className="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <StatCard label="Pesanan baru" value={baru.length} icon={ClipboardList} tone="secondary" />
        <StatCard label="Sedang diproses" value={proses.length} icon={ChefHat} tone="info" />
        <StatCard label="Pesanan selesai" value={selesai.length} icon={CheckCircle2} />
        <StatCard label="Perlu verifikasi" value={verif.length} icon={CreditCard} tone="warning" />
      </div>
      <Card className="p-5">
        <div className="mb-3 flex items-center justify-between"><h2 className="font-display font-semibold">Pesanan terbaru</h2><Link to="/seller/orders" className="flex items-center gap-1 text-sm font-medium text-primary">Semua <ArrowRight className="h-4 w-4" /></Link></div>
        <div className="divide-y divide-border">
          {orders.slice(0, 5).map((o) => (
            <Link key={o.id} to="/seller/orders/$id" params={{ id: o.id }} className="flex items-center gap-3 py-3 hover:bg-muted/40">
              <Img src={o.items[0]?.image} alt="" className="h-11 w-11 rounded-lg" />
              <div className="flex-1"><p className="text-sm font-medium">{o.id} · {user(o.buyerId)?.name}</p><p className="text-xs text-muted-foreground">{fmtDateTime(o.createdAt)} · {rp(o.total)}</p></div>
              <StatusBadge status={o.status} />
            </Link>
          ))}
        </div>
      </Card>
    </div>
  );
}
