import { createFileRoute, Link, useNavigate } from "@tanstack/react-router";
import { useState } from "react";
import { LogIn, ShieldCheck, ShoppingCart, Store, Truck } from "lucide-react";
import { AuthLayout } from "@/components/layout/AuthLayout";
import { Button, Input } from "@/components/ui/kit";
import { cn } from "@/lib/utils";
import { seo } from "@/lib/seo";
import type { Role } from "@/types";

export const Route = createFileRoute("/login")({
  head: () => seo("Masuk", "Masuk ke KantinKu sebagai pembeli, penjual, driver, atau admin."),
  component: Login,
});

const R = [
  { id: "buyer", label: "Pembeli", icon: ShoppingCart, email: "andi@student.ac.id" },
  { id: "seller", label: "Penjual", icon: Store, email: "siti@warung.id" },
  { id: "driver", label: "Driver", icon: Truck, email: "budi.driver@kantinku.ac.id" },
  { id: "admin", label: "Admin", icon: ShieldCheck, email: "admin@kantinku.ac.id" },
] as const;
const HOME = { buyer: "/buyer", seller: "/seller", driver: "/driver", admin: "/admin" } as const;

function Login() {
  const [role, setRole] = useState<Role>("buyer");
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");
  const navigate = useNavigate();
  const cur = R.find((r) => r.id === role)!;
  return (
    <AuthLayout title="Selamat datang kembali" subtitle="Masuk untuk melanjutkan. Data demo sudah terisi otomatis.">
      <div className="mb-6 grid grid-cols-4 gap-2 rounded-xl bg-muted p-1">
        {R.map((r) => (
          <button key={r.id} onClick={() => setRole(r.id)} className={cn("flex flex-col items-center gap-1 rounded-lg py-2 text-xs font-medium transition", role === r.id ? "bg-card text-primary shadow-card" : "text-muted-foreground hover:text-foreground")}>
            <r.icon className="h-4 w-4" />{r.label}
          </button>
        ))}
      </div>
      <form
        className="space-y-4"
        onSubmit={(e) => {
          e.preventDefault();
          const pw = String(new FormData(e.currentTarget).get("password") ?? "");
          if (pw.length < 4) return setError("Password minimal 4 karakter.");
          setError("");
          setLoading(true);
          setTimeout(() => navigate({ to: HOME[role] }), 500);
        }}
      >
        <Input key={cur.email} id="email" name="email" label="Email" type="email" defaultValue={cur.email} required />
        <Input id="password" name="password" label="Password" type="password" defaultValue="demo1234" required />
        {error && <p className="text-sm text-destructive">{error}</p>}
        <Button type="submit" size="lg" className="w-full" icon={LogIn} disabled={loading}>{loading ? "Memproses..." : `Masuk sebagai ${cur.label}`}</Button>
      </form>
      {(role === "buyer" || role === "seller") && (
        <p className="mt-6 text-center text-sm text-muted-foreground">Belum punya akun? <Link to="/register" className="font-medium text-primary hover:underline">Daftar sekarang</Link></p>
      )}
    </AuthLayout>
  );
}
