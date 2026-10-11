import { createFileRoute } from "@tanstack/react-router";
import { Check, MapPin, X } from "lucide-react";
import { useLookup, useStore } from "@/lib/store";
import { Button, Card, Img, PageHeader, StatusBadge } from "@/components/ui/kit";
import { fmtDate } from "@/lib/format";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/admin/shops")({
  head: () => seo("Persetujuan Warung", "Verifikasi warung yang diajukan penjual."),
  component: Shops,
});

function Shops() {
  const { state, setShopApproval } = useStore();
  const { user } = useLookup();
  const list = [...state.shops].sort((a) => (a.approval === "pending" ? -1 : 1));
  return (
    <div className="space-y-6">
      <PageHeader title="Persetujuan Warung" subtitle="Tinjau warung sebelum tampil ke pembeli." />
      <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        {list.map((s) => (
          <Card key={s.id} className="overflow-hidden">
            <Img src={s.image} alt={s.name} className="h-36 w-full" />
            <div className="space-y-2 p-4">
              <div className="flex items-center justify-between gap-2"><p className="font-display font-semibold">{s.name}</p><StatusBadge status={s.approval} /></div>
              <p className="text-sm text-muted-foreground">{s.description}</p>
              <p className="flex items-center gap-1 text-xs text-muted-foreground"><MapPin className="h-3.5 w-3.5" />{s.location}</p>
              <p className="text-xs text-muted-foreground">Pemilik: {user(s.ownerId)?.name} · Diajukan {fmtDate(s.submitted)}</p>
              {s.approval === "pending" && <div className="flex gap-2 pt-2"><Button size="sm" variant="success" icon={Check} onClick={() => setShopApproval(s.id, "approved")}>Setujui</Button><Button size="sm" variant="outline" icon={X} onClick={() => setShopApproval(s.id, "rejected")}>Tolak</Button></div>}
            </div>
          </Card>
        ))}
      </div>
    </div>
  );
}
