import { createFileRoute, Link } from "@tanstack/react-router";
import { useState } from "react";
import { Clock, Edit, MapPin, Save, UtensilsCrossed, ArrowRight } from "lucide-react";
import { useStore } from "@/lib/store";
import { CURRENT } from "@/data/mockData";
import { OpenBadge } from "@/components/cards";
import { Button, Card, Img, Input, PageHeader, StatusBadge, Textarea } from "@/components/ui/kit";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/seller/shop")({
  head: () => seo("Kelola Warung", "Atur informasi dan status warung."),
  component: ShopPage,
});

function ShopPage() {
  const { state, updateShop } = useStore();
  const shop = state.shops.find((s) => s.ownerId === CURRENT.seller)!;
  const [edit, setEdit] = useState(false);
  const menuCount = state.menus.filter((m) => m.shopId === shop.id).length;
  return (
    <div className="max-w-4xl space-y-6">
      <PageHeader title="Warung & Menu" subtitle="Kelola informasi warung dan daftar menu." action={<Link to="/seller/menu" className="inline-flex h-10 items-center gap-2 rounded-lg bg-primary px-4 text-sm font-medium text-primary-foreground"><UtensilsCrossed className="h-4 w-4" /> Kelola Menu ({menuCount})</Link>} />
      <Card className="overflow-hidden">
        <Img src={shop.image} alt={shop.name} className="h-56 w-full" />
        <div className="p-6">
          {!edit ? (
            <>
              <div className="flex flex-wrap items-start justify-between gap-3">
                <div><div className="flex items-center gap-2"><h2 className="font-display text-xl font-semibold">{shop.name}</h2><OpenBadge open={shop.open} /></div><p className="mt-1 text-sm text-muted-foreground">Persetujuan admin: <StatusBadge status={shop.approval} /></p></div>
                <Button variant="outline" icon={Edit} onClick={() => setEdit(true)}>Edit Informasi</Button>
              </div>
              <p className="mt-4 text-sm">{shop.description}</p>
              <div className="mt-4 flex flex-wrap gap-4 text-sm text-muted-foreground"><span className="flex items-center gap-1"><MapPin className="h-4 w-4" />{shop.location}</span><span className="flex items-center gap-1"><Clock className="h-4 w-4" />{shop.hours}</span></div>
              <div className="mt-6 flex items-center justify-between rounded-xl bg-muted p-4">
                <div><p className="text-sm font-medium">Status warung</p><p className="text-xs text-muted-foreground">Pembeli hanya dapat memesan ketika warung buka.</p></div>
                <button role="switch" aria-checked={shop.open} aria-label="Status buka" onClick={() => updateShop(shop.id, { open: !shop.open })} className={`relative h-7 w-12 rounded-full transition ${shop.open ? "bg-primary" : "bg-border"}`}><span className={`absolute top-1 h-5 w-5 rounded-full bg-card shadow transition-all ${shop.open ? "left-6" : "left-1"}`} /></button>
              </div>
            </>
          ) : (
            <form className="grid gap-4 sm:grid-cols-2" onSubmit={(e) => { e.preventDefault(); const f = new FormData(e.currentTarget); updateShop(shop.id, { name: String(f.get("name")), description: String(f.get("desc")), location: String(f.get("loc")), hours: String(f.get("hours")), image: String(f.get("image")) }); setEdit(false); }}>
              <Input name="name" label="Nama warung" defaultValue={shop.name} required />
              <Input name="hours" label="Jam operasional" defaultValue={shop.hours} required />
              <Input name="loc" label="Lokasi" defaultValue={shop.location} required className="sm:col-span-2" />
              <Input name="image" label="URL foto warung" defaultValue={shop.image} className="sm:col-span-2" />
              <Textarea name="desc" label="Deskripsi" defaultValue={shop.description} className="sm:col-span-2" />
              <div className="flex gap-2 sm:col-span-2"><Button type="submit" icon={Save}>Simpan</Button><Button type="button" variant="outline" onClick={() => setEdit(false)}>Batal</Button></div>
            </form>
          )}
        </div>
      </Card>
      <Link to="/seller/menu" className="flex items-center justify-between rounded-2xl border border-border bg-card p-5 hover:border-primary"><span className="flex items-center gap-3"><UtensilsCrossed className="h-5 w-5 text-primary" /><span className="font-medium">Kelola menu warung</span></span><ArrowRight className="h-4 w-4" /></Link>
    </div>
  );
}
