import { createFileRoute, Link, useNavigate } from "@tanstack/react-router";
import { useState } from "react";
import { Building2, CreditCard, QrCode, Send, Wallet } from "lucide-react";
import { useLookup, useStore } from "@/lib/store";
import { Button, Card, EmptyState, FileUpload, InfoRow, PageHeader, StatusBadge } from "@/components/ui/kit";
import { fmtDateTime, rp } from "@/lib/format";
import { cn } from "@/lib/utils";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/buyer/payment/$id")({
  head: () => seo("Pembayaran", "Unggah bukti pembayaran pesanan."),
  component: Payment,
});

const METHODS = [
  { id: "QRIS", icon: QrCode, desc: "Scan QR dari aplikasi bank/e-wallet" },
  { id: "Transfer Bank", icon: Building2, desc: "BNI 0123456789 a.n. Kantin Kampus" },
  { id: "E-Wallet", icon: Wallet, desc: "GoPay / OVO / DANA 0812-0000-1111" },
];

function Payment() {
  const { id } = Route.useParams();
  const { submitPayment } = useStore();
  const { order, shop } = useLookup();
  const o = order(id);
  const [method, setMethod] = useState(o?.paymentMethod ?? "QRIS");
  const [proof, setProof] = useState(o?.proof);
  const [err, setErr] = useState("");
  const navigate = useNavigate();
  if (!o) return <EmptyState icon={CreditCard} title="Transaksi tidak ditemukan" />;
  const locked = o.paymentStatus === "pending" || o.paymentStatus === "verified";
  return (
    <div>
      <PageHeader title="Pembayaran" subtitle={`Pesanan ${o.id}`} action={<StatusBadge status={o.paymentStatus} />} />
      <div className="grid gap-6 lg:grid-cols-3">
        <div className="space-y-6 lg:col-span-2">
          <Card className="p-5">
            <h2 className="mb-4 font-display font-semibold">Metode Pembayaran</h2>
            <div className="grid gap-3 sm:grid-cols-3">
              {METHODS.map((m) => (
                <button key={m.id} disabled={locked} onClick={() => setMethod(m.id)} className={cn("rounded-xl border-2 p-4 text-left transition", method === m.id ? "border-primary bg-primary/5" : "border-border hover:border-primary/40")}>
                  <m.icon className={cn("h-5 w-5", method === m.id ? "text-primary" : "text-muted-foreground")} />
                  <p className="mt-2 text-sm font-medium">{m.id}</p>
                  <p className="mt-0.5 text-xs text-muted-foreground">{m.desc}</p>
                </button>
              ))}
            </div>
          </Card>
          <Card className="p-5">
            {locked ? (
              <div>
                <h2 className="mb-3 font-display font-semibold">Bukti Pembayaran</h2>
                {o.proof && <img src={o.proof} alt="Bukti pembayaran" className="max-h-64 rounded-xl" />}
                <p className="mt-3 text-sm text-muted-foreground">{o.paymentStatus === "pending" ? "Bukti sedang diverifikasi oleh penjual." : "Pembayaran telah diverifikasi."}</p>
              </div>
            ) : (
              <>
                <FileUpload label="Upload bukti pembayaran" value={proof} onChange={(v) => { setProof(v); setErr(""); }} />
                {o.paymentStatus === "rejected" && <p className="mt-3 text-sm text-destructive">Pembayaran sebelumnya ditolak. Silakan unggah ulang bukti yang valid.</p>}
                {err && <p className="mt-3 text-sm text-destructive">{err}</p>}
              </>
            )}
          </Card>
        </div>
        <Card className="h-fit p-5">
          <h2 className="mb-2 font-display font-semibold">Detail Transaksi</h2>
          <InfoRow label="No. Transaksi">{o.trxId}</InfoRow>
          <InfoRow label="Warung">{shop(o.shopId)?.name}</InfoRow>
          <InfoRow label="Waktu">{fmtDateTime(o.createdAt)}</InfoRow>
          <InfoRow label="Item">{o.items.reduce((a, b) => a + b.qty, 0)} porsi</InfoRow>
          <div className="mt-2 border-t border-border pt-2"><InfoRow label="Total Pembayaran"><span className="font-display text-lg text-primary">{rp(o.total)}</span></InfoRow></div>
          {locked ? (
            <Link to="/buyer/orders/$id" params={{ id: o.id }} className="mt-4 inline-flex h-11 w-full items-center justify-center rounded-lg border border-border font-medium hover:bg-muted">Lihat Status Pesanan</Link>
          ) : (
            <Button className="mt-4 w-full" size="lg" icon={Send} onClick={() => { if (!proof) return setErr("Unggah bukti pembayaran terlebih dahulu."); submitPayment(o.id, proof, method); navigate({ to: "/buyer/orders/$id", params: { id: o.id } }); }}>Kirim Pembayaran</Button>
          )}
        </Card>
      </div>
    </div>
  );
}
