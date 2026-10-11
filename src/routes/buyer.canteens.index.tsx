import { createFileRoute } from "@tanstack/react-router";
import { useState } from "react";
import { Search, Store } from "lucide-react";
import { useStore } from "@/lib/store";
import { CanteenCard } from "@/components/cards";
import { EmptyState, PageHeader } from "@/components/ui/kit";
import { cn } from "@/lib/utils";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/buyer/canteens/")({
  head: () => seo("Daftar Kantin", "Semua warung kantin kampus yang tersedia."),
  component: Canteens,
});

function Canteens() {
  const { state } = useStore();
  const [q, setQ] = useState("");
  const [f, setF] = useState<"all" | "open">("all");
  const list = state.shops.filter((s) => s.approval === "approved" && s.name.toLowerCase().includes(q.toLowerCase()) && (f === "all" || s.open));
  return (
    <div>
      <PageHeader title="Daftar Kantin" subtitle="Pilih warung untuk melihat menu lengkap." />
      <div className="mb-6 flex flex-col gap-3 sm:flex-row">
        <div className="flex flex-1 items-center gap-2 rounded-lg border border-border bg-card px-3">
          <Search className="h-4 w-4 text-muted-foreground" />
          <input value={q} onChange={(e) => setQ(e.target.value)} placeholder="Cari kantin..." className="h-10 flex-1 bg-transparent text-sm focus:outline-none" />
        </div>
        <div className="flex gap-1 rounded-lg bg-muted p-1">
          {(["all", "open"] as const).map((k) => <button key={k} onClick={() => setF(k)} className={cn("rounded-md px-4 text-sm font-medium", f === k ? "bg-card shadow-card" : "text-muted-foreground")}>{k === "all" ? "Semua" : "Sedang Buka"}</button>)}
        </div>
      </div>
      {list.length ? <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">{list.map((s) => <CanteenCard key={s.id} shop={s} />)}</div> : <EmptyState icon={Store} title="Tidak ada kantin" desc="Tidak ada kantin yang sesuai filter." />}
    </div>
  );
}
