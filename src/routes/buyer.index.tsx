import { createFileRoute, Link } from "@tanstack/react-router";
import { useState } from "react";
import { ArrowRight, Search, Store } from "lucide-react";
import { useStore } from "@/lib/store";
import { CanteenCard, MenuCard } from "@/components/cards";
import { EmptyState, Img } from "@/components/ui/kit";
import { IMG } from "@/data/mockData";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/buyer/")({
  head: () => seo("Beranda Pembeli", "Cari makanan dan kantin favorit di kampus."),
  component: BuyerHome,
});

function BuyerHome() {
  const { state } = useStore();
  const [q, setQ] = useState("");
  const shops = state.shops.filter((s) => s.approval === "approved");
  const ql = q.toLowerCase();
  const fShops = shops.filter((s) => s.name.toLowerCase().includes(ql));
  const menus = state.menus.filter((m) => shops.some((s) => s.id === m.shopId) && m.name.toLowerCase().includes(ql)).slice(0, 8);
  return (
    <div className="space-y-10">
      <section className="relative overflow-hidden rounded-3xl">
        <Img src={IMG.hero} alt="Menu kantin kampus" className="absolute inset-0 h-full w-full" />
        <div className="absolute inset-0 bg-gradient-to-r from-foreground/85 via-foreground/60 to-transparent" />
        <div className="relative max-w-xl p-6 text-background md:p-10">
          <h1 className="font-display text-3xl font-bold leading-tight md:text-4xl">Lapar di sela kuliah? Pesan sekarang.</h1>
          <p className="mt-2 text-sm opacity-90 md:text-base">Makanan hangat dari kantin kampus diantar ke ruanganmu.</p>
          <div className="mt-6 flex items-center gap-2 rounded-xl bg-card p-1.5 text-foreground">
            <Search className="ml-2 h-5 w-5 text-muted-foreground" />
            <input value={q} onChange={(e) => setQ(e.target.value)} placeholder="Cari makanan atau kantin..." className="h-10 flex-1 bg-transparent text-sm focus:outline-none" />
          </div>
        </div>
      </section>

      <section>
        <div className="mb-4 flex items-end justify-between">
          <div><h2 className="font-display text-xl font-semibold">Kantin di kampus</h2><p className="text-sm text-muted-foreground">Warung yang sudah terverifikasi</p></div>
          <Link to="/buyer/canteens" className="flex items-center gap-1 text-sm font-medium text-primary">Semua <ArrowRight className="h-4 w-4" /></Link>
        </div>
        {fShops.length ? <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">{fShops.slice(0, 4).map((s) => <CanteenCard key={s.id} shop={s} />)}</div> : <EmptyState icon={Store} title="Kantin tidak ditemukan" desc="Coba kata kunci lain." />}
      </section>

      <section>
        <div className="mb-4 flex items-end justify-between">
          <div><h2 className="font-display text-xl font-semibold">Menu populer</h2><p className="text-sm text-muted-foreground">Paling sering dipesan minggu ini</p></div>
          <Link to="/buyer/menu" className="flex items-center gap-1 text-sm font-medium text-primary">Semua menu <ArrowRight className="h-4 w-4" /></Link>
        </div>
        {menus.length ? (
          <div className="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">{menus.map((m) => <MenuCard key={m.id} menu={m} shop={state.shops.find((s) => s.id === m.shopId)} />)}</div>
        ) : <EmptyState title="Menu tidak ditemukan" />}
      </section>

      <section className="flex flex-col items-start justify-between gap-4 rounded-3xl bg-primary p-8 text-primary-foreground md:flex-row md:items-center">
        <div><h2 className="font-display text-2xl font-semibold">Jelajahi semua kantin</h2><p className="mt-1 text-sm opacity-90">Temukan menu baru dari {shops.length} warung di kampus.</p></div>
        <Link to="/buyer/canteens" className="inline-flex h-11 items-center gap-2 rounded-lg bg-card px-5 font-medium text-foreground hover:bg-muted">Lihat Daftar Kantin <ArrowRight className="h-4 w-4" /></Link>
      </section>
    </div>
  );
}
