import { createFileRoute, Link } from "@tanstack/react-router";
import { Check, ChefHat, ChevronLeft, ClipboardList, PackageCheck, X } from "lucide-react";
import { useLookup, useStore } from "@/lib/store";
import { Button, Card, EmptyState, Img, InfoRow, PageHeader, StatusBadge, Timeline } from "@/components/ui/kit";
import { fmtDateTime, orderStep, rp } from "@/lib/format";
import { ORDER_STEPS } from "@/lib/steps";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/seller/orders/$id")({
  head: () => seo("Detail Pesanan", "Detail pesanan dan pembaruan status."),
  component: SellerOrderDetail,
});

function SellerOrderDetail() {
  const { id } = Route.useParams();
  const { verifyPayment, updateOrderStatus } = useStore();
  const { order, user } = useLookup();
  const o = order(id);
  if (!o) return <EmptyState icon={ClipboardList} title="Pesanan tidak ditemukan" />;
  const buyer = user(o.buyerId);
  return (
    <div>
      <Link to="/seller/orders" className="mb-4 inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground"><ChevronLeft className="h-4 w-4" /> Pesanan Masuk</Link>
      <PageHeader title={`Pesanan ${o.id}`} subtitle={fmtDateTime(o.createdAt)} action={<StatusBadge status={o.status} />} />
      {o.status !== "cancelled" && <Card className="mb-6 p-6"><Timeline steps={ORDER_STEPS} current={orderStep(o)} /></Card>}
      <div className="grid gap-6 lg:grid-cols-3">
        <Card className="p-5 lg:col-span-2">
          <h2 className="mb-2 font-display font-semibold">Detail makanan</h2>
          <div className="divide-y divide-border">
            {o.items.map((i) => (
              <div key={i.menuId} className="flex items-center gap-3 py-3"><Img src={i.image} alt={i.name} className="h-12 w-12 rounded-lg" /><div className="flex-1"><p className="text-sm font-medium">{i.name}</p><p className="text-xs text-muted-foreground">{i.qty} x {rp(i.price)}</p></div><span className="text-sm font-semibold">{rp(i.qty * i.price)}</span></div>
            ))}
          </div>
          <div className="border-t border-border pt-2"><InfoRow label="Total">{rp(o.total)}</InfoRow></div>
          {o.note && <p className="mt-2 rounded-lg bg-muted p-3 text-sm">Catatan: {o.note}</p>}
        </Card>
        <div className="space-y-6">
          <Card className="p-5">
            <h3 className="mb-3 font-medium">Update Status Pesanan</h3>
            {o.paymentStatus === "pending" && (
              <div className="space-y-2"><p className="text-sm text-muted-foreground">Verifikasi pembayaran terlebih dahulu.</p>
                {o.proof && <img src={o.proof} alt="Bukti" className="max-h-40 w-full rounded-lg object-cover" />}
                <div className="flex gap-2"><Button size="sm" variant="success" icon={Check} onClick={() => verifyPayment(o.id, true)}>Verifikasi</Button><Button size="sm" variant="outline" icon={X} className="text-destructive" onClick={() => verifyPayment(o.id, false)}>Tolak</Button></div>
              </div>
            )}
            {o.paymentStatus === "unpaid" && <p className="text-sm text-muted-foreground">Menunggu pembeli membayar.</p>}
            {o.status === "paid" && <Button className="w-full" icon={ChefHat} onClick={() => updateOrderStatus(o.id, "processing")}>Mulai Proses</Button>}
            {o.status === "processing" && <Button className="w-full" icon={PackageCheck} onClick={() => updateOrderStatus(o.id, "ready")}>Tandai Siap Diantar</Button>}
            {["ready", "delivering", "done", "cancelled"].includes(o.status) && <p className="text-sm text-muted-foreground">{o.status === "ready" ? "Menunggu driver mengambil pesanan." : o.status === "delivering" ? "Pesanan sedang diantar driver." : o.status === "done" ? "Pesanan telah selesai." : "Pesanan dibatalkan."}</p>}
          </Card>
          <Card className="p-5">
            <h3 className="mb-1 font-medium">Pembeli</h3>
            <InfoRow label="Nama">{buyer?.name}</InfoRow>
            <InfoRow label="HP">{buyer?.phone}</InfoRow>
            <InfoRow label="Alamat">{o.address}</InfoRow>
            <InfoRow label="Pembayaran"><StatusBadge status={o.paymentStatus} /></InfoRow>
            <InfoRow label="Driver">{user(o.driverId)?.name ?? "-"}</InfoRow>
          </Card>
        </div>
      </div>
    </div>
  );
}
