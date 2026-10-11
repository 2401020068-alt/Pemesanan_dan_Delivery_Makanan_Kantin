import { createFileRoute, Link } from "@tanstack/react-router";
import { ArrowRight, CheckCircle2, Clock, Truck, Wallet } from "lucide-react";
import { useLookup, useStore } from "@/lib/store";
import { CURRENT } from "@/data/mockData";
import { Card, EmptyState, PageHeader, StatCard, StatusBadge } from "@/components/ui/kit";
import { rp } from "@/lib/format";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/driver/")({
  head: () => seo("Dashboard Driver", "Ringkasan pengantaran pesanan kantin hari ini."),
  component: DriverDash,
});

function DriverDash() {
  const { state } = useStore();
  const { me, shop } = useLookup();
  const available = state.orders.filter((o) => o.status === "ready" && !o.driverId);
  const mine = state.orders.filter((o) => o.driverId === CURRENT.driver);
  const active = mine.filter((o) => o.deliveryStatus !== "done");
  const done = mine.filter((o) => o.deliveryStatus === "done");
  return (
    <div className="space-y-6">
      <PageHeader title={`Halo, ${me("driver").name.split(" ")[0]}`} subtitle="Siap mengantar pesanan hari ini?" />
      <div className="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <StatCard label="Siap diambil" value={available.length} icon={Clock} tone="secondary" />
        <StatCard label="Sedang diantar" value={active.length} icon={Truck} tone="info" />
        <StatCard label="Selesai" value={done.length} icon={CheckCircle2} />
        <StatCard label="Pendapatan ongkir" value={rp(done.reduce((a, o) => a + o.deliveryFee, 0))} icon={Wallet} tone="warning" />
      </div>
      <Card className="p-5">
        <div className="mb-3 flex items-center justify-between"><h2 className="font-display font-semibold">Pesanan siap diantar</h2><Link to="/driver/deliveries" className="flex items-center gap-1 text-sm font-medium text-primary">Kelola <ArrowRight className="h-4 w-4" /></Link></div>
        {available.length === 0 ? <EmptyState title="Belum ada pesanan siap" desc="Pesanan akan muncul saat penjual menandai siap diantar." icon={Truck} /> : (
          <div className="divide-y divide-border">
            {available.map((o) => (
              <div key={o.id} className="flex items-center gap-3 py-3">
                <div className="flex-1"><p className="text-sm font-medium">{o.id} · {shop(o.shopId)?.name}</p><p className="text-xs text-muted-foreground">{o.address}</p></div>
                <StatusBadge status={o.deliveryStatus} />
              </div>
            ))}
          </div>
        )}
      </Card>
    </div>
  );
}
