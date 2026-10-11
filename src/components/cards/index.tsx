import { Link } from "@tanstack/react-router";
import { ChevronRight, Clock, MapPin, Plus } from "lucide-react";
import type { MenuItem, Shop } from "@/types";
import { Badge, Button, Card, Img } from "@/components/ui/kit";
import { rp } from "@/lib/format";
import { useStore } from "@/lib/store";

export function OpenBadge({ open }: { open: boolean }) {
  return <Badge tone={open ? "success" : "neutral"}><span className={open ? "h-1.5 w-1.5 rounded-full bg-success" : "h-1.5 w-1.5 rounded-full bg-muted-foreground"} />{open ? "Buka" : "Tutup"}</Badge>;
}

export function CanteenCard({ shop }: { shop: Shop }) {
  return (
    <Card className="group overflow-hidden transition hover:-translate-y-0.5">
      <div className="relative">
        <Img src={shop.image} alt={shop.name} className="aspect-[16/10] w-full" />
        <div className="absolute left-3 top-3"><OpenBadge open={shop.open} /></div>
      </div>
      <div className="p-4">
        <h3 className="font-display font-semibold">{shop.name}</h3>
        <p className="mt-1 line-clamp-2 text-sm text-muted-foreground">{shop.description}</p>
        <div className="mt-3 flex flex-wrap gap-x-4 gap-y-1 text-xs text-muted-foreground">
          <span className="flex items-center gap-1"><MapPin className="h-3.5 w-3.5" />{shop.location}</span>
          <span className="flex items-center gap-1"><Clock className="h-3.5 w-3.5" />{shop.hours}</span>
        </div>
        <Link to="/buyer/canteens/$id" params={{ id: shop.id }} className="mt-4 inline-flex h-9 w-full items-center justify-center gap-1 rounded-lg border border-border text-sm font-medium transition hover:border-primary hover:text-primary">
          Lihat Kantin <ChevronRight className="h-4 w-4" />
        </Link>
      </div>
    </Card>
  );
}

export function MenuCard({ menu, shop }: { menu: MenuItem; shop?: Shop }) {
  const { addToCart } = useStore();
  const can = menu.available && (shop?.open ?? true);
  return (
    <Card className="flex flex-col overflow-hidden">
      <div className="relative">
        <Img src={menu.image} alt={menu.name} className="aspect-[4/3] w-full" />
        {!menu.available && <div className="absolute inset-0 flex items-center justify-center bg-foreground/50"><Badge>Habis</Badge></div>}
      </div>
      <div className="flex flex-1 flex-col p-4">
        {shop && <p className="text-xs font-medium text-secondary">{shop.name}</p>}
        <h3 className="mt-0.5 font-medium">{menu.name}</h3>
        <p className="mt-1 line-clamp-2 flex-1 text-xs text-muted-foreground">{menu.description}</p>
        <div className="mt-3 flex items-center justify-between">
          <span className="font-display font-semibold text-foreground">{rp(menu.price)}</span>
          <Button size="sm" icon={Plus} disabled={!can} onClick={() => addToCart(menu.id)}>Tambah</Button>
        </div>
      </div>
    </Card>
  );
}
