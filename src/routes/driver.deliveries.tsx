import { useState } from "react";
import { createFileRoute } from "@tanstack/react-router";
import { CheckCircle2, MapPin, Package, Store, Truck } from "lucide-react";
import { useLookup, useStore } from "@/lib/store";
import { CURRENT } from "@/data/mockData";
import { Button, Card, EmptyState, PageHeader, StatusBadge, Timeline } from "@/components/ui/kit";
import { DELIVERY_STEPS } from "@/lib/steps";
import { deliveryStep, fmtDateTime, rp } from "@/lib/format";
import { cn } from "@/lib/utils";
import { seo } from "@/lib/seo";
import type { Order } from "@/types";

export const Route = createFileRoute("/driver/deliveries")({
  head: () => seo("Pengantaran", "Ambil dan perbarui status pengantaran pesanan."),
  component: Deliveries,
});

const TABS = [["available", "Tersedia"], ["active", "Aktif"], ["done", "Riwayat"]] as const;

function Deliveries() {
  const { state } = useStore();
  const [tab, setTab] = useState<(typeof TABS)[number][0]>("available");
  const list = state.orders.filter((o) =>
    tab === "available" ? o.status === "ready" && !o.driverId
      : o.driverId === CURRENT.driver && (tab === "done" ? o.deliveryStatus === "done" : o.deliveryStatus !== "done"),
  );
  return (
    <div className="space-y-6">
      <PageHeader title="Pengantaran" subtitle="Ambil pesanan dan perbarui status pengantaran." />
      <div className="flex gap-2 overflow-x-auto">
        {TABS.map(([k, l]) => (
          <button key={k} onClick={() => setTab(k)} className={cn("rounded-full px-4 py-2 text-sm font-medium", tab === k ? "bg-primary text-primary-foreground" : "bg-card text-muted-foreground border border-border")}>{l}</button>
        ))}
      </div>
      {list.length === 0 ? <EmptyState title="Tidak ada pengantaran" icon={Truck} /> : (
        <div className="grid gap-4 md:grid-cols-2">{list.map((o) => <DeliveryCard key={o.id} o={o} />)}</div>
      )}
    </div>
  );
}

function DeliveryCard({ o }: { o: Order }) {
  const { takeDelivery, setDelivery } = useStore();
  const { shop, user } = useLookup();
  const s = shop(o.shopId);
  return (
    <Card className="space-y-4 p-5">
      <div className="flex items-start justify-between gap-2">
        <div><p className="font-display font-semibold">{o.id}</p><p className="text-xs text-muted-foreground">{fmtDateTime(o.createdAt)}</p></div>
        <StatusBadge status={o.deliveryStatus} />
      </div>
      <div className="space-y-2 text-sm">
        <p className="flex gap-2"><Store className="h-4 w-4 shrink-0 text-primary" />{s?.name} · {s?.location}</p>
        <p className="flex gap-2"><MapPin className="h-4 w-4 shrink-0 text-secondary" />{user(o.buyerId)?.name} · {o.address}</p>
        <p className="text-muted-foreground">{o.items.map((i) => `${i.qty}x ${i.name}`).join(", ")}</p>
        <p className="font-medium">Ongkir {rp(o.deliveryFee)}</p>
      </div>
      {o.driverId && <Timeline steps={DELIVERY_STEPS} current={deliveryStep(o)} />}
      {!o.driverId && <Button className="w-full" icon={Package} onClick={() => takeDelivery(o.id)}>Ambil Pesanan</Button>}
      {o.deliveryStatus === "picked" && <Button className="w-full" icon={Truck} onClick={() => setDelivery(o.id, "onway")}>Mulai Antar</Button>}
      {o.deliveryStatus === "onway" && <Button variant="success" className="w-full" icon={CheckCircle2} onClick={() => setDelivery(o.id, "done")}>Pesanan Sampai</Button>}
    </Card>
  );
}
