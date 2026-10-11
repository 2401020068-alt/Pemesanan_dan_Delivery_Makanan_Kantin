import { createFileRoute, Link, useNavigate } from "@tanstack/react-router";
import { useState } from "react";
import { ArrowRight, MapPin, ShoppingCart, User } from "lucide-react";
import { useLookup, useStore } from "@/lib/store";
import { Button, Card, EmptyState, Img, InfoRow, Input, PageHeader, Textarea } from "@/components/ui/kit";
import { rp } from "@/lib/format";
import { seo } from "@/lib/seo";
import { useCartLines } from "@/lib/cart";

export const Route = createFileRoute("/buyer/checkout")({
  head: () => seo("Checkout", "Lengkapi alamat pengantaran pesanan."),
  component: Checkout,
});

function Checkout() {
  const { placeOrder } = useStore();
  const me = useLookup().me("buyer");
  const { lines, subtotal, fee, shop } = useCartLines();
  const [address, setAddress] = useState(me.address ?? "");
  const [note, setNote] = useState("");
  const navigate = useNavigate();
  if (!lines.length) return <EmptyState icon={ShoppingCart} title="Tidak ada item untuk checkout" action={<Link to="/buyer/canteens" className="text-sm font-medium text-primary">Pilih menu</Link>} />;
  return (
    <div>
      <PageHeader title="Checkout" subtitle="Pastikan data pengantaran sudah benar." />
      <form className="grid gap-6 lg:grid-cols-3" onSubmit={(e) => { e.preventDefault(); const id = placeOrder({ address, note, paymentMethod: "QRIS" }); navigate({ to: "/buyer/payment/$id", params: { id } }); }}>
        <div className="space-y-6 lg:col-span-2">
          <Card className="p-5">
            <h2 className="mb-4 flex items-center gap-2 font-display font-semibold"><User className="h-4 w-4 text-primary" /> Detail Pembeli</h2>
            <div className="grid gap-4 sm:grid-cols-2">
              <Input label="Nama" defaultValue={me.name} readOnly />
              <Input label="Nomor HP" defaultValue={me.phone} readOnly />
            </div>
          </Card>
          <Card className="p-5">
            <h2 className="mb-4 flex items-center gap-2 font-display font-semibold"><MapPin className="h-4 w-4 text-primary" /> Alamat Pengantaran</h2>
            <Input label="Gedung / ruangan" value={address} onChange={(e) => setAddress(e.target.value)} required placeholder="Contoh: Gedung FT, Ruang 3.12" />
            <Textarea className="mt-4" label="Catatan (opsional)" value={note} onChange={(e) => setNote(e.target.value)} placeholder="Contoh: tidak pedas" />
          </Card>
          <Card className="p-5">
            <h2 className="mb-3 font-display font-semibold">Daftar Pesanan <span className="text-sm font-normal text-muted-foreground">· {shop?.name}</span></h2>
            <div className="divide-y divide-border">
              {lines.map((l) => (
                <div key={l.menuId} className="flex items-center gap-3 py-3">
                  <Img src={l.menu.image} alt={l.menu.name} className="h-12 w-12 rounded-lg" />
                  <div className="flex-1"><p className="text-sm font-medium">{l.menu.name}</p><p className="text-xs text-muted-foreground">{l.qty} x {rp(l.menu.price)}</p></div>
                  <span className="text-sm font-semibold">{rp(l.qty * l.menu.price)}</span>
                </div>
              ))}
            </div>
          </Card>
        </div>
        <Card className="h-fit p-5">
          <h2 className="mb-2 font-display font-semibold">Ringkasan Harga</h2>
          <InfoRow label="Subtotal">{rp(subtotal)}</InfoRow>
          <InfoRow label="Ongkos antar">{rp(fee)}</InfoRow>
          <div className="mt-2 border-t border-border pt-2"><InfoRow label="Total"><span className="font-display text-lg text-primary">{rp(subtotal + fee)}</span></InfoRow></div>
          <Button type="submit" className="mt-4 w-full" size="lg">Lanjut Pembayaran <ArrowRight className="h-4 w-4" /></Button>
        </Card>
      </form>
    </div>
  );
}
