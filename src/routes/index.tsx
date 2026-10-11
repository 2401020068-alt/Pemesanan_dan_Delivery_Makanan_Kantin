import { createFileRoute, Link } from "@tanstack/react-router";
import { ArrowRight, ShieldCheck, ShoppingCart, Store, Truck, Clock, CreditCard, Package } from "lucide-react";
import { Logo } from "@/components/layout/AppShell";
import { Img } from "@/components/ui/kit";
import { IMG } from "@/data/mockData";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/")({
  head: () => seo("Pesan Makanan Kantin Kampus", "Pesan makanan dari kantin kampus, bayar online, dan diantar langsung ke kelas atau ruanganmu."),
  component: Landing,
});

const roles = [
  { to: "/buyer", title: "Pembeli", desc: "Pesan makanan dari kantin favorit dan lacak pengantarannya.", icon: ShoppingCart },
  { to: "/seller", title: "Penjual", desc: "Kelola warung, menu, pesanan masuk, dan verifikasi pembayaran.", icon: Store },
  { to: "/driver", title: "Driver", desc: "Ambil pengantaran dan perbarui status secara real time.", icon: Truck },
  { to: "/admin", title: "Admin System", desc: "Setujui penjual dan warung, pantau transaksi dan sengketa.", icon: ShieldCheck },
] as const;

function Landing() {
  return (
    <div className="min-h-screen bg-background">
      <header className="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 md:px-6">
        <Logo />
        <div className="flex gap-2">
          <Link to="/login" className="rounded-lg px-4 py-2 text-sm font-medium hover:bg-muted">Masuk</Link>
          <Link to="/register" className="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90">Daftar</Link>
        </div>
      </header>
      <section className="mx-auto grid max-w-7xl items-center gap-10 px-4 py-10 md:grid-cols-2 md:px-6 md:py-16">
        <div>
          <span className="inline-flex items-center gap-2 rounded-full bg-accent px-3 py-1 text-xs font-medium text-accent-foreground"><Clock className="h-3.5 w-3.5" /> Rata-rata sampai 15 menit</span>
          <h1 className="mt-4 font-display text-4xl font-bold leading-tight tracking-tight md:text-5xl">Makanan kantin kampus, <span className="text-primary">diantar ke kelasmu.</span></h1>
          <p className="mt-4 max-w-lg text-muted-foreground">Pilih menu dari warung kantin, bayar dengan QRIS atau transfer, lalu pantau pesananmu dari dapur sampai tiba di ruangan.</p>
          <div className="mt-8 flex flex-wrap gap-3">
            <Link to="/buyer" className="inline-flex h-12 items-center gap-2 rounded-lg bg-primary px-6 font-medium text-primary-foreground hover:bg-primary/90">Mulai Pesan <ArrowRight className="h-4 w-4" /></Link>
            <Link to="/buyer/canteens" className="inline-flex h-12 items-center gap-2 rounded-lg border border-border bg-card px-6 font-medium hover:bg-muted"><Store className="h-4 w-4" /> Lihat Kantin</Link>
          </div>
          <div className="mt-8 flex gap-6 text-sm text-muted-foreground">
            <span className="flex items-center gap-2"><CreditCard className="h-4 w-4 text-primary" /> Bayar online</span>
            <span className="flex items-center gap-2"><Package className="h-4 w-4 text-primary" /> Lacak pesanan</span>
          </div>
        </div>
        <div className="relative">
          <Img src={IMG.hero} alt="Nasi goreng khas kantin kampus" className="aspect-[4/3] w-full rounded-3xl shadow-card" />
          <div className="absolute -bottom-5 -left-4 hidden rounded-2xl border border-border bg-card p-4 shadow-card sm:block">
            <p className="text-xs text-muted-foreground">Pesanan hari ini</p>
            <p className="font-display text-xl font-semibold">1.248 porsi</p>
          </div>
        </div>
      </section>
      <section className="mx-auto max-w-7xl px-4 pb-16 md:px-6">
        <h2 className="font-display text-xl font-semibold">Masuk sebagai</h2>
        <p className="mb-5 text-sm text-muted-foreground">Mode demo: pilih role untuk menjelajahi setiap panel.</p>
        <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
          {roles.map((r) => (
            <Link key={r.to} to={r.to} className="group rounded-2xl border border-border bg-card p-5 shadow-card transition hover:-translate-y-0.5 hover:border-primary">
              <span className="inline-flex rounded-xl bg-primary/10 p-2.5 text-primary"><r.icon className="h-5 w-5" /></span>
              <p className="mt-4 font-display font-semibold">{r.title}</p>
              <p className="mt-1 text-sm text-muted-foreground">{r.desc}</p>
              <span className="mt-4 inline-flex items-center gap-1 text-sm font-medium text-primary">Buka panel <ArrowRight className="h-4 w-4 transition group-hover:translate-x-0.5" /></span>
            </Link>
          ))}
        </div>
      </section>
    </div>
  );
}
