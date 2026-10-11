import { createFileRoute } from "@tanstack/react-router";
import { Check, X } from "lucide-react";
import { useStore } from "@/lib/store";
import { Button, Img, PageHeader, StatusBadge, Table } from "@/components/ui/kit";
import { fmtDate } from "@/lib/format";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/admin/sellers")({
  head: () => seo("Persetujuan Penjual", "Verifikasi pendaftaran penjual kantin."),
  component: Sellers,
});

function Sellers() {
  const { state, setSellerApproval } = useStore();
  const sellers = state.users.filter((u) => u.role === "seller");
  return (
    <div className="space-y-6">
      <PageHeader title="Persetujuan Penjual" subtitle="Setujui atau tolak pendaftaran penjual baru." />
      <Table head={["Penjual", "Kontak", "Daftar", "Status", "Aksi"]} empty={!sellers.length}>
        {sellers.map((u) => (
          <tr key={u.id}>
            <td><div className="flex items-center gap-3"><Img src={u.avatar} alt={u.name} className="h-9 w-9 rounded-full" /><span className="font-medium">{u.name}</span></div></td>
            <td><p>{u.email}</p><p className="text-xs text-muted-foreground">{u.phone}</p></td>
            <td>{fmtDate(u.joined)}</td>
            <td><StatusBadge status={u.approval ?? "pending"} /></td>
            <td>{u.approval === "pending" ? <div className="flex gap-2"><Button size="sm" variant="success" icon={Check} onClick={() => setSellerApproval(u.id, "approved")}>Setujui</Button><Button size="sm" variant="outline" icon={X} onClick={() => setSellerApproval(u.id, "rejected")}>Tolak</Button></div> : <span className="text-xs text-muted-foreground">-</span>}</td>
          </tr>
        ))}
      </Table>
    </div>
  );
}
