import { createFileRoute } from "@tanstack/react-router";
import { CheckCircle2, ClipboardList, Download, Wallet, XCircle } from "lucide-react";
import { useLookup, useStore } from "@/lib/store";
import { Button, Card, PageHeader, StatCard, StatusBadge, Table } from "@/components/ui/kit";
import { fmtDateTime, rp } from "@/lib/format";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/admin/reports")({
  head: () => seo("Laporan Kantin Digital", "Laporan transaksi dan performa warung."),
  component: Reports,
});

function Reports() {
  const { state } = useStore();
  const { shop, user } = useLookup();
  const ok = state.orders.filter((o) => o.paymentStatus === "verified");
  const total = ok.reduce((a, o) => a + o.total, 0);
  const perShop = state.shops.filter((s) => s.approval === "approved").map((s) => ({ s, v: ok.filter((o) => o.shopId === s.id).reduce((a, o) => a + o.total, 0) }));
  const max = Math.max(1, ...perShop.map((x) => x.v));
  const exportCsv = () => {
    const rows = [["ID", "Tanggal", "Pembeli", "Warung", "Total", "Status"], ...state.orders.map((o) => [o.id, o.createdAt, user(o.buyerId)?.name ?? "", shop(o.shopId)?.name ?? "", String(o.total), o.status])];
    const a = document.createElement("a");
    a.href = URL.createObjectURL(new Blob([rows.map((r) => r.join(",")).join("\n")], { type: "text/csv" }));
    a.download = "laporan-kantin.csv";
    a.click();
  };
  return (
    <div className="space-y-6">
      <PageHeader title="Laporan Kantin Digital" subtitle="Ringkasan transaksi seluruh warung." action={<Button icon={Download} onClick={exportCsv}>Ekspor CSV</Button>} />
      <div className="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <StatCard label="Pendapatan" value={rp(total)} icon={Wallet} />
        <StatCard label="Transaksi" value={state.orders.length} icon={ClipboardList} tone="info" />
        <StatCard label="Selesai" value={state.orders.filter((o) => o.status === "done").length} icon={CheckCircle2} tone="secondary" />
        <StatCard label="Dibatalkan" value={state.orders.filter((o) => o.status === "cancelled").length} icon={XCircle} tone="error" />
      </div>
      <Card className="p-5">
        <h2 className="mb-4 font-display font-semibold">Pendapatan per warung</h2>
        <div className="space-y-3">
          {perShop.map(({ s, v }) => (
            <div key={s.id}><div className="mb-1 flex justify-between text-sm"><span>{s.name}</span><span className="font-medium">{rp(v)}</span></div><div className="h-2 rounded-full bg-muted"><div className="h-2 rounded-full bg-primary" style={{ width: `${(v / max) * 100}%` }} /></div></div>
          ))}
        </div>
      </Card>
      <Table head={["ID", "Waktu", "Pembeli", "Warung", "Total", "Status"]}>
        {state.orders.map((o) => (
          <tr key={o.id}><td className="font-medium">{o.id}</td><td>{fmtDateTime(o.createdAt)}</td><td>{user(o.buyerId)?.name}</td><td>{shop(o.shopId)?.name}</td><td>{rp(o.total)}</td><td><StatusBadge status={o.status} /></td></tr>
        ))}
      </Table>
    </div>
  );
}
