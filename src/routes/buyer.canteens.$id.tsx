import { createFileRoute, Link } from "@tanstack/react-router";
import { ChevronLeft, Clock, MapPin, UtensilsCrossed } from "lucide-react";
import { useStore } from "@/lib/store";
import { MenuCard, OpenBadge } from "@/components/cards";
import { EmptyState, Img } from "@/components/ui/kit";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/buyer/canteens/$id")({
  head: () => seo("Detail Kantin", "Informasi warung dan daftar menu."),
  component: CanteenDetail,
});

function CanteenDetail() {
  const { id } = Route.useParams();
  const { state } = useStore();
  const shop = state.shops.find((s) => s.id === id);
  if (!shop) return <EmptyState title="Kantin tidak ditemukan" action={<Link to="/buyer/canteens" className="text-primary">Kembali</Link>} />;
  const menus = state.menus.filter((m) => m.shopId === id);
  const cats = [...new Set(menus.map((m) => m.category))];
  return (
    <div>
      <Link to="/buyer/canteens" className="mb-4 inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground"><ChevronLeft className="h-4 w-4" /> Daftar Kantin</Link>
      <div className="relative overflow-hidden rounded-3xl">
        <Img src={shop.image} alt={shop.name} className="h-56 w-full md:h-72" />
        <div className="absolute inset-0 bg-gradient-to-t from-foreground/80 to-transparent" />
        <div className="absolute bottom-0 p-6 text-background">
          <OpenBadge open={shop.open} />
          <h1 className="mt-2 font-display text-3xl font-bold">{shop.name}</h1>
          <p className="mt-1 max-w-xl text-sm opacity-90">{shop.description}</p>
          <div className="mt-3 flex flex-wrap gap-4 text-sm opacity-90">
            <span className="flex items-center gap-1"><MapPin className="h-4 w-4" />{shop.location}</span>
            <span className="flex items-center gap-1"><Clock className="h-4 w-4" />{shop.hours}</span>
          </div>
        </div>
      </div>
      {!shop.open && <p className="mt-4 rounded-xl bg-warning/15 p-3 text-sm text-warning-foreground">Warung sedang tutup. Menu belum bisa dipesan.</p>}
      {menus.length === 0 ? <div className="mt-8"><EmptyState icon={UtensilsCrossed} title="Belum ada menu" /></div> : cats.map((c) => (
        <section key={c} className="mt-8">
          <h2 className="mb-4 font-display text-lg font-semibold">{c}</h2>
          <div className="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">{menus.filter((m) => m.category === c).map((m) => <MenuCard key={m.id} menu={m} shop={shop} />)}</div>
        </section>
      ))}
    </div>
  );
}
