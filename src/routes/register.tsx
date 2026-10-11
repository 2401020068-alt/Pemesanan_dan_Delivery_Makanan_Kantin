import { createFileRoute, Link, useNavigate } from "@tanstack/react-router";
import { useState } from "react";
import { CheckCircle2, ShoppingCart, Store, UserPlus } from "lucide-react";
import { AuthLayout } from "@/components/layout/AuthLayout";
import { Button, Input } from "@/components/ui/kit";
import { cn } from "@/lib/utils";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/register")({
  head: () => seo("Daftar Akun", "Buat akun pembeli atau daftarkan warung Anda di kantin kampus."),
  component: Register,
});

function Register() {
  const [role, setRole] = useState<"buyer" | "seller">("buyer");
  const [done, setDone] = useState(false);
  const navigate = useNavigate();
  if (done)
    return (
      <AuthLayout title="Pendaftaran berhasil" subtitle={role === "seller" ? "Akun penjual Anda menunggu persetujuan Admin." : "Akun Anda siap digunakan."}>
        <div className="rounded-2xl border border-border bg-card p-6 text-center">
          <CheckCircle2 className="mx-auto h-12 w-12 text-primary" />
          <p className="mt-3 text-sm text-muted-foreground">{role === "seller" ? "Kami akan memberi tahu Anda setelah data warung diverifikasi." : "Silakan masuk untuk mulai memesan."}</p>
          <Button className="mt-5 w-full" onClick={() => navigate({ to: "/login" })}>Ke halaman masuk</Button>
        </div>
      </AuthLayout>
    );
  return (
    <AuthLayout title="Buat akun baru" subtitle="Daftar sebagai pembeli atau penjual di kantin kampus.">
      <div className="mb-6 grid grid-cols-2 gap-2 rounded-xl bg-muted p-1">
        {([["buyer", "Pembeli", ShoppingCart], ["seller", "Penjual", Store]] as const).map(([id, l, I]) => (
          <button key={id} onClick={() => setRole(id)} className={cn("flex items-center justify-center gap-2 rounded-lg py-2 text-sm font-medium", role === id ? "bg-card text-primary shadow-card" : "text-muted-foreground")}><I className="h-4 w-4" />{l}</button>
        ))}
      </div>
      <form className="space-y-4" onSubmit={(e) => { e.preventDefault(); setDone(true); }}>
        <Input label="Nama lengkap" required placeholder="Nama sesuai KTM/KTP" />
        <Input label="Email" type="email" required placeholder="nama@kampus.ac.id" />
        <Input label="Nomor HP" required placeholder="08xx-xxxx-xxxx" />
        {role === "seller" && <Input label="Nama warung" required placeholder="Contoh: Warung Bu Siti" />}
        <Input label="Password" type="password" required minLength={6} />
        <Button type="submit" size="lg" className="w-full" icon={UserPlus}>Daftar</Button>
      </form>
      <p className="mt-6 text-center text-sm text-muted-foreground">Sudah punya akun? <Link to="/login" className="font-medium text-primary hover:underline">Masuk</Link></p>
    </AuthLayout>
  );
}
