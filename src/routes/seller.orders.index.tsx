import { createFileRoute, Link } from "@tanstack/react-router";
import { useState } from "react";
import { Eye } from "lucide-react";
import { useLookup, useStore } from "@/lib/store";
import { CURRENT } from "@/data/mockData";
import { PageHeader, StatusBadge, Table } from "@/components/ui/kit";
import { fmtDateTime, rp } from "@/lib/format";
import { cn } from "@/lib/utils";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/seller/orders/")({
  head: () => seo("Pesanan Masuk", "Daftar pesanan yang masuk ke warung."),
  component: SellerOrders,
});

const TABS = [["all", "Semua"], ["new", "Baru"], ["active", "Diproses"], ["done", "Selesai"]] as const;

function SellerOrders() {
  const { state } = useStore();
  const { user } = useLookup();
  const [tab, setTab] = useState<(typeof TABS)[number][0]>("all");
  const shop = state.shops.find((s) => s.ownerId === CURRENT.seller)!;
  const list = state.orders.filter((o) => o.shopId === shop.id).filter((o) =>
    tab === "all" ? true : tab === "new" ? o.status === "created" || o.status === "paid" : tab === "active" ? ["processing", "ready", "delivering"].includes(o.status) : o.status === "done");
  return (
    <div>
      <PageHeader title="Pesanan Masuk" subtitle="Proses pesanan dan perbarui statusnya." />
      <div className="mb-4 flex gap-1 overflow-x-auto rounded-lg bg-muted p-1 sm:w-fit">
        {TABS.map(([k, l]) => <button key={k} onClick={() => setTab(k)} className={cn("rounded-md px-4 py-1.5 text-sm font-medium", tab === k ? "bg-card shadow-card" : "text-muted-foreground")}>{l}</button>)}
      </div>
      <Table head={["No. Pesanan", "Pembeli", "Detail makanan", "Total", "Pembayaran", "Status", "Waktu", ""]} empty={!list.length}>
        {list.map((o) => (
          <tr key={o.id}>
            <td className="font-medium">{o.id}</td>
            <td>{user(o.buyerId)?.name}</td>
            <td className="max-w-[220px] truncate text-muted-foreground">{o.items.map((i) => `${i.qty}x ${i.name}`).join(", ")}</td>
            <td className="font-medium">{rp(o.total)}</td>
            <td><StatusBadge status={o.paymentStatus} /></td>
            <td><StatusBadge status={o.status} /></td>
            <td className="whitespace-nowrap text-muted-foreground">{fmtDateTime(o.createdAt)}</td>
            <td><Link to="/seller/orders/$id" params={{ id: o.id }} className="inline-flex items-center gap-1 text-sm font-medium text-primary"><Eye className="h-4 w-4" /> Detail</Link></td>
          </tr>
        ))}
      </Table>
    </div>
  );
}
