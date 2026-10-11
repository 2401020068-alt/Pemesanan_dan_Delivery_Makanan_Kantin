import { createFileRoute } from "@tanstack/react-router";
import { useState } from "react";
import { Search, UtensilsCrossed } from "lucide-react";
import { useStore } from "@/lib/store";
import { MenuCard } from "@/components/cards";
import { EmptyState, PageHeader } from "@/components/ui/kit";
import { cn } from "@/lib/utils";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/buyer/menu")({
  head: () => seo("Daftar Menu", "Semua menu makanan dan minuman dari kantin kampus."),
  component: MenuList,
});

function MenuList() {
  const { state } = useStore();
  const [q, setQ] = useState("");
  const [cat, setCat] = useState("Semua");
  const approved = state.shops.filter((s) => s.approval === "approved");
  const all = state.menus.filter((m) => approved.some((s) => s.id === m.shopId));
  const cats = ["Semua", ...new Set(all.map((m) => m.category))];
  const list = all.filter((m) => m.name.toLowerCase().includes(q.toLowerCase()) && (cat === "Semua" || m.category === cat));
  return (
    <div>
      <PageHeader title="Daftar Menu" subtitle={`${all.length} menu dari ${approved.length} warung`} />
      <div className="mb-4 flex items-center gap-2 rounded-lg border border-border bg-card px-3">
        <Search className="h-4 w-4 text-muted-foreground" />
        <input value={q} onChange={(e) => setQ(e.target.value)} placeholder="Cari menu..." className="h-10 flex-1 bg-transparent text-sm focus:outline-none" />
      </div>
      <div className="mb-6 flex gap-2 overflow-x-auto">
        {cats.map((c) => <button key={c} onClick={() => setCat(c)} className={cn("whitespace-nowrap rounded-full border px-4 py-1.5 text-sm font-medium", cat === c ? "border-primary bg-primary text-primary-foreground" : "border-border bg-card text-muted-foreground hover:text-foreground")}>{c}</button>)}
      </div>
      {list.length ? <div className="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">{list.map((m) => <MenuCard key={m.id} menu={m} shop={state.shops.find((s) => s.id === m.shopId)} />)}</div> : <EmptyState icon={UtensilsCrossed} title="Menu tidak ditemukan" />}
    </div>
  );
}
