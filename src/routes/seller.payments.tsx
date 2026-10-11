import { createFileRoute } from "@tanstack/react-router";
import { useState } from "react";
import { Check, Eye, X } from "lucide-react";
import { useLookup, useStore } from "@/lib/store";
import { CURRENT } from "@/data/mockData";
import { Button, Img, Modal, PageHeader, StatusBadge, Table } from "@/components/ui/kit";
import { rp } from "@/lib/format";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/seller/payments")({
  head: () => seo("Pembayaran", "Verifikasi bukti pembayaran pembeli."),
  component: Payments,
});

function Payments() {
  const { state, verifyPayment } = useStore();
  const { user } = useLookup();
  const [view, setView] = useState<string | null>(null);
  const shop = state.shops.find((s) => s.ownerId === CURRENT.seller)!;
  const list = state.orders.filter((o) => o.shopId === shop.id && o.paymentStatus !== "unpaid");
  return (
    <div>
      <PageHeader title="Pembayaran" subtitle="Periksa bukti pembayaran lalu verifikasi atau tolak." />
      <Table head={["No. Transaksi", "No. Pesanan", "Pembeli", "Total", "Bukti", "Status", "Aksi"]} empty={!list.length}>
        {list.map((o) => (
          <tr key={o.id}>
            <td className="font-medium">{o.trxId}</td>
            <td>{o.id}</td>
            <td>{user(o.buyerId)?.name}</td>
            <td className="font-medium">{rp(o.total)}</td>
            <td>{o.proof ? <button onClick={() => setView(o.proof!)} className="flex items-center gap-2 text-primary"><Img src={o.proof} alt="Bukti" className="h-10 w-10 rounded-md" /><Eye className="h-4 w-4" /></button> : "-"}</td>
            <td><StatusBadge status={o.paymentStatus} /></td>
            <td>{o.paymentStatus === "pending" ? <div className="flex gap-1"><Button size="sm" variant="success" icon={Check} onClick={() => verifyPayment(o.id, true)}>Verifikasi</Button><Button size="sm" variant="outline" icon={X} className="text-destructive" onClick={() => verifyPayment(o.id, false)}>Tolak</Button></div> : <span className="text-xs text-muted-foreground">Selesai diproses</span>}</td>
          </tr>
        ))}
      </Table>
      <Modal open={!!view} onClose={() => setView(null)} title="Bukti pembayaran">
        {view && <img src={view} alt="Bukti pembayaran" className="w-full rounded-xl" />}
        <Button variant="outline" className="mt-4 w-full" onClick={() => setView(null)}>Tutup</Button>
      </Modal>
    </div>
  );
}
