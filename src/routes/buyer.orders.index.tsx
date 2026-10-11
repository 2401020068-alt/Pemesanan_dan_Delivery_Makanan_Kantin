import { createFileRoute, Link } from "@tanstack/react-router";
import { ChevronRight, ClipboardList } from "lucide-react";
import { useLookup, useStore } from "@/lib/store";
import { CURRENT } from "@/data/mockData";
import { Card, EmptyState, Img, PageHeader, StatusBadge } from "@/components/ui/kit";
import { fmtDateTime, rp } from "@/lib/format";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/buyer/orders/")({
  head: () => seo("Pesanan Saya", "Riwayat dan status pesanan."),
  component: Orders,
});

function Orders() {
  const { state } = useStore();
  const { shop } = useLookup();
  const list = state.orders.filter((o) => o.buyerId === CURRENT.buyer);
  return (
    <div>
      <PageHeader title="Pesanan Saya" subtitle="Pantau status pesanan dari dapur sampai tiba." />
      {!list.length ? <EmptyState icon={ClipboardList} title="Belum ada pesanan" /> : (
        <div className="space-y-3">
          {list.map((o) => (
            <Link key={o.id} to="/buyer/orders/$id" params={{ id: o.id }}>
              <Card className="mb-3 flex items-center gap-4 p-4 transition hover:border-primary">
                <Img src={o.items[0]?.image} alt={o.items[0]?.name ?? ""} className="h-16 w-16 shrink-0 rounded-xl" />
                <div className="min-w-0 flex-1">
                  <div className="flex flex-wrap items-center gap-2"><p className="font-medium">{shop(o.shopId)?.name}</p><StatusBadge status={o.status} /></div>
                  <p className="truncate text-sm text-muted-foreground">{o.items.map((i) => `${i.qty}x ${i.name}`).join(", ")}</p>
                  <p className="mt-0.5 text-xs text-muted-foreground">{o.id} · {fmtDateTime(o.createdAt)}</p>
                </div>
                <div className="text-right"><p className="font-semibold">{rp(o.total)}</p><ChevronRight className="ml-auto mt-1 h-4 w-4 text-muted-foreground" /></div>
              </Card>
            </Link>
          ))}
        </div>
      )}
    </div>
  );
}
