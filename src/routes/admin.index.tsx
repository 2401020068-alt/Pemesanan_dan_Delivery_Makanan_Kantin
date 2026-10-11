import { createFileRoute, Link } from "@tanstack/react-router";
import { AlertCircle, ArrowRight, ClipboardList, ShieldCheck, Store, UserCheck, Users, Wallet } from "lucide-react";
import { useStore } from "@/lib/store";
import { Card, PageHeader, StatCard, StatusBadge } from "@/components/ui/kit";
import { fmtDateTime, rp } from "@/lib/format";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/admin/")({
  head: () => seo("Dashboard Admin", "Ringkasan sistem kantin digital kampus."),
  component: AdminDash,
});

function AdminDash() {
  const { state } = useStore();
  const revenue = state.orders.filter((o) => o.paymentStatus === "verified").reduce((a, o) => a + o.total, 0);
  const pendSel = state.users.filter((u) => u.role === "seller" && u.approval === "pending").length;
  const pendShop = state.shops.filter((s) => s.approval === "pending").length;
  const openDsp = state.disputes.filter((d) => d.status === "open" || d.status === "review").length;
  return (
    <div className="space-y-6">
      <PageHeader title="Dashboard Admin" subtitle="Pantau aktivitas kantin digital kampus." />
      <div className="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <StatCard label="Total pengguna" value={state.users.length} icon={Users} />
        <StatCard label="Warung aktif" value={state.shops.filter((s) => s.approval === "approved").length} icon={Store} tone="info" />
        <StatCard label="Total transaksi" value={state.orders.length} icon={ClipboardList} tone="secondary" />
        <StatCard label="Nilai transaksi" value={rp(revenue)} icon={Wallet} tone="warning" />
      </div>
      <div className="grid gap-4 md:grid-cols-3">
        {[
          { to: "/admin/sellers", label: "Penjual menunggu", n: pendSel, icon: UserCheck },
          { to: "/admin/shops", label: "Warung menunggu", n: pendShop, icon: ShieldCheck },
          { to: "/admin/disputes", label: "Sengketa aktif", n: openDsp, icon: AlertCircle },
        ].map((x) => (
          <Link key={x.to} to={x.to}><Card className="flex items-center gap-4 p-5 hover:border-primary">
            <x.icon className="h-8 w-8 text-primary" /><div className="flex-1"><p className="text-2xl font-semibold">{x.n}</p><p className="text-sm text-muted-foreground">{x.label}</p></div><ArrowRight className="h-4 w-4 text-muted-foreground" />
          </Card></Link>
        ))}
      </div>
      <Card className="p-5">
        <h2 className="mb-3 font-display font-semibold">Aktivitas admin terbaru</h2>
        <div className="divide-y divide-border">
          {state.logs.slice(0, 5).map((l) => (
            <div key={l.id} className="flex items-center gap-3 py-3 text-sm"><div className="flex-1"><p className="font-medium">{l.action}</p><p className="text-xs text-muted-foreground">{l.target} · {fmtDateTime(l.time)}</p></div><StatusBadge status={l.status} /></div>
          ))}
        </div>
      </Card>
    </div>
  );
}
