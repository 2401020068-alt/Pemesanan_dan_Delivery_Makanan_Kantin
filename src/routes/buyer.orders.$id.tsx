import { createFileRoute, Link } from "@tanstack/react-router";
import { AlertCircle, ChevronLeft, ClipboardList, CreditCard, MapPin, Truck } from "lucide-react";
import { useLookup } from "@/lib/store";
import { Card, EmptyState, Img, InfoRow, PageHeader, StatusBadge, Timeline } from "@/components/ui/kit";
import { fmtDateTime, orderStep, rp } from "@/lib/format";
import { ORDER_STEPS } from "@/lib/steps";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/buyer/orders/$id")({
  head: () => seo("Status Pesanan", "Lacak status pesanan secara langsung."),
  component: OrderStatus,
});

function OrderStatus() {
  const { id } = Route.useParams();
  const { order, shop, user } = useLookup();
  const o = order(id);
  if (!o) return <EmptyState icon={ClipboardList} title="Pesanan tidak ditemukan" />;
  const driver = user(o.driverId);
  return (
    <div>
      <Link to="/buyer/orders" className="mb-4 inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground"><ChevronLeft className="h-4 w-4" /> Pesanan Saya</Link>
      <PageHeader title={`Pesanan ${o.id}`} subtitle={fmtDateTime(o.createdAt)} action={<StatusBadge status={o.status} />} />
      <Card className="mb-6 p-6">
        {o.status === "cancelled" ? (
          <p className="flex items-center gap-2 text-sm text-destructive"><AlertCircle className="h-4 w-4" /> Pesanan dibatalkan karena pembayaran ditolak.</p>
        ) : <Timeline steps={ORDER_STEPS} current={orderStep(o)} />}
        {o.paymentStatus === "unpaid" || o.paymentStatus === "rejected" ? (
          <Link to="/buyer/payment/$id" params={{ id: o.id }} className="mt-6 inline-flex h-10 items-center gap-2 rounded-lg bg-primary px-4 text-sm font-medium text-primary-foreground"><CreditCard className="h-4 w-4" /> Bayar Sekarang</Link>
        ) : null}
      </Card>
      <div className="grid gap-6 lg:grid-cols-3">
        <Card className="p-5 lg:col-span-2">
          <h2 className="mb-3 font-display font-semibold">{shop(o.shopId)?.name}</h2>
          <div className="divide-y divide-border">
            {o.items.map((i) => (
              <div key={i.menuId} className="flex items-center gap-3 py-3">
                <Img src={i.image} alt={i.name} className="h-12 w-12 rounded-lg" />
                <div className="flex-1"><p className="text-sm font-medium">{i.name}</p><p className="text-xs text-muted-foreground">{i.qty} x {rp(i.price)}</p></div>
                <span className="text-sm font-semibold">{rp(i.qty * i.price)}</span>
              </div>
            ))}
          </div>
          <div className="mt-2 border-t border-border pt-2">
            <InfoRow label="Subtotal">{rp(o.subtotal)}</InfoRow>
            <InfoRow label="Ongkos antar">{rp(o.deliveryFee)}</InfoRow>
            <InfoRow label="Total"><span className="text-primary">{rp(o.total)}</span></InfoRow>
          </div>
        </Card>
        <div className="space-y-6">
          <Card className="p-5">
            <h3 className="mb-2 flex items-center gap-2 font-medium"><MapPin className="h-4 w-4 text-primary" /> Pengantaran</h3>
            <p className="text-sm">{o.address}</p>
            {o.note && <p className="mt-1 text-xs text-muted-foreground">Catatan: {o.note}</p>}
            <div className="mt-3 flex items-center gap-2 border-t border-border pt-3 text-sm">
              <Truck className="h-4 w-4 text-muted-foreground" />
              {driver ? <span>{driver.name} · <StatusBadge status={o.deliveryStatus} /></span> : <span className="text-muted-foreground">Belum ada driver</span>}
            </div>
          </Card>
          <Card className="p-5">
            <h3 className="mb-1 flex items-center gap-2 font-medium"><CreditCard className="h-4 w-4 text-primary" /> Pembayaran</h3>
            <InfoRow label="Metode">{o.paymentMethod}</InfoRow>
            <InfoRow label="Status"><StatusBadge status={o.paymentStatus} /></InfoRow>
          </Card>
          <Link to="/buyer/disputes" className="flex items-center gap-2 text-sm text-muted-foreground hover:text-destructive"><AlertCircle className="h-4 w-4" /> Ada masalah dengan pesanan ini?</Link>
        </div>
      </div>
    </div>
  );
}
