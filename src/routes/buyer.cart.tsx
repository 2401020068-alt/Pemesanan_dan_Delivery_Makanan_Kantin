import { createFileRoute, Link, useNavigate } from "@tanstack/react-router";
import { Minus, Plus, ShoppingCart, Trash2, ArrowRight } from "lucide-react";
import { useStore } from "@/lib/store";
import { Button, Card, EmptyState, Img, InfoRow, PageHeader } from "@/components/ui/kit";
import { rp } from "@/lib/format";
import { seo } from "@/lib/seo";
import { useCartLines } from "@/lib/cart";

export const Route = createFileRoute("/buyer/cart")({
  head: () => seo("Keranjang", "Periksa pesanan sebelum checkout."),
  component: Cart,
});

function Cart() {
  const { setQty } = useStore();
  const { lines, subtotal, shop, fee } = useCartLines();
  const navigate = useNavigate();
  if (!lines.length)
    return (<div><PageHeader title="Keranjang" /><EmptyState icon={ShoppingCart} title="Keranjang masih kosong" desc="Yuk pilih menu dari kantin favoritmu." action={<Link to="/buyer/canteens" className="inline-flex h-10 items-center rounded-lg bg-primary px-4 text-sm font-medium text-primary-foreground">Lihat Kantin</Link>} /></div>);
  return (
    <div>
      <PageHeader title="Keranjang" subtitle={`Pesanan dari ${shop?.name}`} />
      <div className="grid gap-6 lg:grid-cols-3">
        <Card className="divide-y divide-border lg:col-span-2">
          {lines.map((l) => (
            <div key={l.menuId} className="flex gap-4 p-4">
              <Img src={l.menu.image} alt={l.menu.name} className="h-20 w-20 shrink-0 rounded-xl" />
              <div className="flex flex-1 flex-col">
                <div className="flex justify-between gap-2"><p className="font-medium">{l.menu.name}</p><button aria-label="Hapus" onClick={() => setQty(l.menuId, 0)} className="text-muted-foreground hover:text-destructive"><Trash2 className="h-4 w-4" /></button></div>
                <p className="text-sm text-muted-foreground">{rp(l.menu.price)}</p>
                <div className="mt-auto flex items-center justify-between pt-2">
                  <div className="flex items-center gap-1 rounded-lg border border-border">
                    <button aria-label="Kurangi" onClick={() => setQty(l.menuId, l.qty - 1)} className="p-1.5 hover:bg-muted"><Minus className="h-4 w-4" /></button>
                    <span className="w-8 text-center text-sm font-medium">{l.qty}</span>
                    <button aria-label="Tambah" onClick={() => setQty(l.menuId, l.qty + 1)} className="p-1.5 hover:bg-muted"><Plus className="h-4 w-4" /></button>
                  </div>
                  <span className="font-semibold">{rp(l.menu.price * l.qty)}</span>
                </div>
              </div>
            </div>
          ))}
        </Card>
        <Card className="h-fit p-5">
          <h2 className="mb-2 font-display font-semibold">Ringkasan</h2>
          <InfoRow label="Subtotal">{rp(subtotal)}</InfoRow>
          <InfoRow label="Ongkos antar">{rp(fee)}</InfoRow>
          <div className="mt-2 border-t border-border pt-2"><InfoRow label="Total"><span className="font-display text-lg text-primary">{rp(subtotal + fee)}</span></InfoRow></div>
          <Button className="mt-4 w-full" size="lg" onClick={() => navigate({ to: "/buyer/checkout" })}>Checkout <ArrowRight className="h-4 w-4" /></Button>
        </Card>
      </div>
    </div>
  );
}
