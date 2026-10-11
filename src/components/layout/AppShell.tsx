import { useState, type ReactNode } from "react";
import { Link, useNavigate } from "@tanstack/react-router";
import {
  Activity, AlertCircle, BarChart3, Bell, ClipboardList, CreditCard, Home, LayoutDashboard, LogOut, Menu, Package, RotateCcw,
  ShieldCheck, ShoppingCart, Store, Truck, User, UserCheck, Users, UtensilsCrossed, X, type LucideIcon,
} from "lucide-react";
import { cn } from "@/lib/utils";
import { useLookup, useStore } from "@/lib/store";
import { ROLE_LABEL } from "@/lib/format";
import type { Role } from "@/types";
import { Img } from "@/components/ui/kit";

type NavItem = { to: string; label: string; icon: LucideIcon; exact?: boolean };
const NAV: Record<Role, NavItem[]> = {
  buyer: [
    { to: "/buyer", label: "Beranda", icon: Home, exact: true },
    { to: "/buyer/canteens", label: "Daftar Kantin", icon: Store },
    { to: "/buyer/cart", label: "Keranjang", icon: ShoppingCart },
    { to: "/buyer/orders", label: "Pesanan", icon: ClipboardList },
    { to: "/buyer/disputes", label: "Sengketa", icon: AlertCircle },
    { to: "/buyer/profile", label: "Profil", icon: User },
  ],
  seller: [
    { to: "/seller", label: "Dashboard", icon: LayoutDashboard, exact: true },
    { to: "/seller/orders", label: "Pesanan", icon: ClipboardList },
    { to: "/seller/shop", label: "Warung & Menu", icon: Store },
    { to: "/seller/payments", label: "Pembayaran", icon: CreditCard },
    { to: "/seller/profile", label: "Profil", icon: User },
  ],
  driver: [
    { to: "/driver", label: "Dashboard", icon: LayoutDashboard, exact: true },
    { to: "/driver/deliveries", label: "Pengantaran", icon: Truck },
    { to: "/driver/profile", label: "Profil", icon: User },
  ],
  admin: [
    { to: "/admin", label: "Dashboard", icon: LayoutDashboard, exact: true },
    { to: "/admin/sellers", label: "Persetujuan Penjual", icon: UserCheck },
    { to: "/admin/shops", label: "Persetujuan Warung", icon: ShieldCheck },
    { to: "/admin/users", label: "Pengguna", icon: Users },
    { to: "/admin/reports", label: "Laporan Kantin Digital", icon: BarChart3 },
    { to: "/admin/disputes", label: "Sengketa Pembayaran", icon: AlertCircle },
    { to: "/admin/logs", label: "Log Aktivitas", icon: Activity },
    { to: "/admin/profile", label: "Profil", icon: User },
  ],
};
const HOME: Record<Role, string> = { buyer: "/buyer", seller: "/seller", driver: "/driver", admin: "/admin" };

export function Logo({ className }: { className?: string }) {
  return (
    <Link to="/" className={cn("flex items-center gap-2", className)}>
      <span className="flex h-9 w-9 items-center justify-center rounded-xl bg-primary text-primary-foreground"><UtensilsCrossed className="h-5 w-5" /></span>
      <span className="font-display text-lg font-semibold text-foreground">Kantin<span className="text-secondary">Ku</span></span>
    </Link>
  );
}

export function RoleSwitcher() {
  const navigate = useNavigate();
  return (
    <select
      aria-label="Ganti role"
      className="h-9 rounded-lg border border-border bg-card px-2 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/20"
      onChange={(e) => navigate({ to: HOME[e.target.value as Role] })}
      defaultValue=""
    >
      <option value="" disabled>Ganti role</option>
      {(Object.keys(ROLE_LABEL) as Role[]).map((r) => <option key={r} value={r}>{ROLE_LABEL[r]}</option>)}
    </select>
  );
}

export function AppShell({ role, children }: { role: Role; children: ReactNode }) {
  const [open, setOpen] = useState(false);
  const { state, toastMsg, reset } = useStore();
  const { me } = useLookup();
  const user = me(role);
  const navigate = useNavigate();
  const cartCount = state.cart.reduce((a, b) => a + b.qty, 0);
  const items = NAV[role];

  const nav = (
    <nav className="flex flex-1 flex-col gap-1">
      {items.map((it) => (
        <Link
          key={it.to}
          to={it.to}
          activeOptions={{ exact: !!it.exact }}
          onClick={() => setOpen(false)}
          className="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-muted-foreground transition-colors hover:bg-muted hover:text-foreground"
          activeProps={{ className: "!bg-primary/10 !text-primary" }}
        >
          <it.icon className="h-[18px] w-[18px]" />
          <span className="flex-1">{it.label}</span>
          {it.to === "/buyer/cart" && cartCount > 0 && <span className="rounded-full bg-secondary px-2 text-xs text-secondary-foreground">{cartCount}</span>}
        </Link>
      ))}
      <div className="mt-auto space-y-1 border-t border-border pt-3">
        <button onClick={reset} className="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-muted-foreground hover:bg-muted hover:text-foreground">
          <RotateCcw className="h-[18px] w-[18px]" /> Reset data demo
        </button>
        <button onClick={() => navigate({ to: "/login" })} className="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-destructive hover:bg-destructive/10">
          <LogOut className="h-[18px] w-[18px]" /> Logout
        </button>
      </div>
    </nav>
  );

  return (
    <div className="min-h-screen bg-background">
      <aside className="fixed inset-y-0 left-0 z-30 hidden w-64 flex-col border-r border-border bg-card p-4 lg:flex">
        <Logo className="mb-2 px-2 py-2" />
        <p className="mb-4 px-3 text-xs font-medium uppercase tracking-wider text-muted-foreground">Panel {ROLE_LABEL[role]}</p>
        {nav}
      </aside>

      {open && (
        <div className="fixed inset-0 z-40 bg-foreground/40 lg:hidden" onClick={() => setOpen(false)}>
          <aside className="flex h-full w-72 flex-col bg-card p-4" onClick={(e) => e.stopPropagation()}>
            <div className="mb-4 flex items-center justify-between"><Logo /><button aria-label="Tutup menu" onClick={() => setOpen(false)} className="rounded-lg p-2 hover:bg-muted"><X className="h-5 w-5" /></button></div>
            {nav}
          </aside>
        </div>
      )}

      <div className="lg:pl-64">
        <header className="sticky top-0 z-20 flex h-16 items-center gap-3 border-b border-border bg-card/90 px-4 backdrop-blur md:px-6">
          <button aria-label="Buka menu" onClick={() => setOpen(true)} className="rounded-lg p-2 hover:bg-muted lg:hidden"><Menu className="h-5 w-5" /></button>
          <div className="lg:hidden"><Logo /></div>
          <div className="ml-auto flex items-center gap-2">
            <div className="hidden sm:block"><RoleSwitcher /></div>
            {role === "buyer" && (
              <Link to="/buyer/cart" aria-label="Keranjang" className="relative rounded-lg p-2 hover:bg-muted">
                <ShoppingCart className="h-5 w-5" />
                {cartCount > 0 && <span className="absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-secondary px-1 text-[10px] font-semibold text-secondary-foreground">{cartCount}</span>}
              </Link>
            )}
            <button aria-label="Notifikasi" className="rounded-lg p-2 hover:bg-muted"><Bell className="h-5 w-5" /></button>
            <div className="flex items-center gap-2 pl-1">
              <Img src={user?.avatar} alt={user?.name ?? ""} className="h-9 w-9 rounded-full" />
              <div className="hidden leading-tight md:block">
                <p className="text-sm font-medium">{user?.name}</p>
                <p className="text-xs text-muted-foreground">{ROLE_LABEL[role]}</p>
              </div>
            </div>
          </div>
        </header>
        <div className="border-b border-border bg-card px-4 py-2 sm:hidden"><RoleSwitcher /></div>
        <main className={cn("mx-auto max-w-7xl p-4 md:p-6", role === "driver" && "pb-24 lg:pb-6")}>{children}</main>
      </div>

      {role === "driver" && (
        <nav className="fixed inset-x-0 bottom-0 z-30 grid grid-cols-3 border-t border-border bg-card lg:hidden">
          {items.map((it) => (
            <Link key={it.to} to={it.to} activeOptions={{ exact: !!it.exact }} className="flex flex-col items-center gap-1 py-2.5 text-xs text-muted-foreground" activeProps={{ className: "!text-primary" }}>
              <it.icon className="h-5 w-5" />{it.label}
            </Link>
          ))}
        </nav>
      )}

      {toastMsg && (
        <div className="fixed bottom-20 left-1/2 z-50 flex -translate-x-1/2 items-center gap-2 rounded-xl bg-foreground px-4 py-3 text-sm text-background shadow-lg lg:bottom-6">
          <Package className="h-4 w-4" /> {toastMsg}
        </div>
      )}
    </div>
  );
}
