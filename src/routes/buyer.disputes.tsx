import { createFileRoute } from "@tanstack/react-router";
import { useState } from "react";
import { AlertCircle, Plus } from "lucide-react";
import { useLookup, useStore } from "@/lib/store";
import { CURRENT } from "@/data/mockData";
import { Button, Card, EmptyState, FileUpload, InfoRow, Input, Modal, PageHeader, Select, StatusBadge, Textarea } from "@/components/ui/kit";
import { fmtDate, rp } from "@/lib/format";
import { seo } from "@/lib/seo";
import type { Dispute } from "@/types";

export const Route = createFileRoute("/buyer/disputes")({
  head: () => seo("Sengketa", "Ajukan dan pantau sengketa transaksi."),
  component: Disputes,
});

function Disputes() {
  const { state, addDispute } = useStore();
  const { order, shop } = useLookup();
  const [open, setOpen] = useState(false);
  const [detail, setDetail] = useState<Dispute | null>(null);
  const [proof, setProof] = useState<string>();
  const mine = state.disputes.filter((d) => d.buyerId === CURRENT.buyer);
  const myOrders = state.orders.filter((o) => o.buyerId === CURRENT.buyer && o.paymentStatus !== "unpaid");
  return (
    <div>
      <PageHeader title="Sengketa" subtitle="Laporkan masalah transaksi atau pesanan." action={<Button icon={Plus} onClick={() => setOpen(true)}>Ajukan Sengketa</Button>} />
      {!mine.length ? <EmptyState icon={AlertCircle} title="Belum ada sengketa" desc="Semua transaksi Anda berjalan lancar." /> : (
        <div className="grid gap-4 md:grid-cols-2">
          {mine.map((d) => {
            const o = order(d.orderId);
            return (
              <Card key={d.id} className="p-5">
                <div className="flex items-start justify-between gap-2"><div><p className="text-xs text-muted-foreground">{d.id} · {fmtDate(d.createdAt)}</p><p className="mt-1 font-medium">{d.issue}</p></div><StatusBadge status={d.status} /></div>
                <p className="mt-2 line-clamp-2 text-sm text-muted-foreground">{d.description}</p>
                <div className="mt-3 flex items-center justify-between border-t border-border pt-3 text-sm"><span className="text-muted-foreground">{d.orderId} · {shop(o?.shopId)?.name}</span><button onClick={() => setDetail(d)} className="font-medium text-primary">Detail</button></div>
              </Card>
            );
          })}
        </div>
      )}
      <Modal open={open} onClose={() => setOpen(false)} title="Ajukan Sengketa">
        <form className="space-y-4" onSubmit={(e) => {
          e.preventDefault();
          const f = new FormData(e.currentTarget);
          addDispute({ orderId: String(f.get("order")), issue: String(f.get("issue")), description: String(f.get("desc")), proof });
          setOpen(false); setProof(undefined);
        }}>
          <Select name="order" label="Transaksi" required>{myOrders.map((o) => <option key={o.id} value={o.id}>{o.id} · {shop(o.shopId)?.name} · {rp(o.total)}</option>)}</Select>
          <Input name="issue" label="Masalah" required placeholder="Contoh: Pesanan tidak sesuai" />
          <Textarea name="desc" label="Deskripsi masalah" required rows={4} />
          <FileUpload label="Bukti (opsional)" value={proof} onChange={setProof} />
          <div className="flex justify-end gap-2"><Button type="button" variant="outline" onClick={() => setOpen(false)}>Batal</Button><Button type="submit">Kirim</Button></div>
        </form>
      </Modal>
      <Modal open={!!detail} onClose={() => setDetail(null)} title={`Sengketa ${detail?.id}`}>
        {detail && (() => { const o = order(detail.orderId); return (
          <div>
            <InfoRow label="Status"><StatusBadge status={detail.status} /></InfoRow>
            <InfoRow label="Transaksi">{o?.trxId} ({o?.id})</InfoRow>
            <InfoRow label="Warung">{shop(o?.shopId)?.name}</InfoRow>
            <InfoRow label="Total">{o && rp(o.total)}</InfoRow>
            <p className="mt-3 text-sm font-medium">{detail.issue}</p>
            <p className="mt-1 text-sm text-muted-foreground">{detail.description}</p>
            {detail.proof && <img src={detail.proof} alt="Bukti" className="mt-3 max-h-48 rounded-lg" />}
            {detail.resolution && <p className="mt-3 rounded-lg bg-accent p-3 text-sm text-accent-foreground">Keputusan admin: {detail.resolution}</p>}
            <Button variant="outline" className="mt-5 w-full" onClick={() => setDetail(null)}>Tutup</Button>
          </div>
        ); })()}
      </Modal>
    </div>
  );
}
