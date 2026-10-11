import { useState } from "react";
import { createFileRoute } from "@tanstack/react-router";
import { AlertCircle } from "lucide-react";
import { useLookup, useStore } from "@/lib/store";
import { Button, Card, EmptyState, Img, InfoRow, Modal, PageHeader, StatusBadge, Textarea } from "@/components/ui/kit";
import { fmtDateTime, rp } from "@/lib/format";
import { seo } from "@/lib/seo";
import type { Dispute } from "@/types";

export const Route = createFileRoute("/admin/disputes")({
  head: () => seo("Sengketa Pembayaran", "Tinjau dan selesaikan sengketa pembeli."),
  component: Disputes,
});

function Disputes() {
  const { state } = useStore();
  const { user } = useLookup();
  const [sel, setSel] = useState<Dispute | null>(null);
  return (
    <div className="space-y-6">
      <PageHeader title="Sengketa Pembayaran" subtitle="Tinjau laporan pembeli dan tetapkan keputusan." />
      {state.disputes.length === 0 ? <EmptyState title="Tidak ada sengketa" icon={AlertCircle} /> : (
        <div className="grid gap-4 md:grid-cols-2">
          {state.disputes.map((d) => (
            <Card key={d.id} className="space-y-2 p-5">
              <div className="flex items-center justify-between"><p className="font-display font-semibold">{d.id} · {d.orderId}</p><StatusBadge status={d.status} /></div>
              <p className="text-sm font-medium">{d.issue}</p>
              <p className="text-sm text-muted-foreground">{d.description}</p>
              <p className="text-xs text-muted-foreground">{user(d.buyerId)?.name} · {fmtDateTime(d.createdAt)}</p>
              <Button size="sm" variant="outline" onClick={() => setSel(d)}>Tinjau</Button>
            </Card>
          ))}
        </div>
      )}
      {sel && <Review d={sel} onClose={() => setSel(null)} />}
    </div>
  );
}

function Review({ d, onClose }: { d: Dispute; onClose: () => void }) {
  const { setDisputeStatus } = useStore();
  const { order, shop } = useLookup();
  const o = order(d.orderId);
  const [note, setNote] = useState(d.resolution ?? "");
  const act = (s: Dispute["status"]) => { setDisputeStatus(d.id, s, note || undefined); onClose(); };
  return (
    <Modal open onClose={onClose} title={`Tinjau ${d.id}`}>
      <div className="space-y-3">
        {o && <><InfoRow label="Warung">{shop(o.shopId)?.name}</InfoRow><InfoRow label="Total">{rp(o.total)}</InfoRow><InfoRow label="Pembayaran"><StatusBadge status={o.paymentStatus} /></InfoRow></>}
        <p className="text-sm">{d.description}</p>
        {d.proof && <Img src={d.proof} alt="Bukti" className="h-40 w-full rounded-lg" />}
        <Textarea label="Catatan keputusan" value={note} onChange={(e) => setNote(e.target.value)} />
        <div className="flex flex-wrap gap-2">
          <Button size="sm" variant="outline" onClick={() => act("review")}>Tandai Ditinjau</Button>
          <Button size="sm" variant="success" onClick={() => act("resolved")}>Selesaikan</Button>
          <Button size="sm" variant="danger" onClick={() => act("rejected")}>Tolak</Button>
        </div>
      </div>
    </Modal>
  );
}
