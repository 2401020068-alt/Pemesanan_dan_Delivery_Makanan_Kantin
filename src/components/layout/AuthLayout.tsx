import type { ReactNode } from "react";
import { Logo } from "./AppShell";
import { Img } from "@/components/ui/kit";
import { IMG } from "@/data/mockData";

export function AuthLayout({ title, subtitle, children }: { title: string; subtitle: string; children: ReactNode }) {
  return (
    <div className="grid min-h-screen bg-background lg:grid-cols-2">
      <div className="flex flex-col justify-center px-6 py-10 sm:px-12">
        <div className="mx-auto w-full max-w-md">
          <Logo className="mb-10" />
          <h1 className="font-display text-2xl font-semibold">{title}</h1>
          <p className="mb-8 mt-1 text-sm text-muted-foreground">{subtitle}</p>
          {children}
        </div>
      </div>
      <div className="relative hidden lg:block">
        <Img src={IMG.canteen} alt="Suasana kantin kampus" className="absolute inset-0 h-full w-full" />
        <div className="absolute inset-0 bg-gradient-to-t from-foreground/70 to-transparent" />
        <div className="absolute bottom-10 left-10 right-10 text-background">
          <p className="font-display text-2xl font-semibold">Satu aplikasi untuk seluruh kantin kampus.</p>
          <p className="mt-2 text-sm opacity-90">Pembeli, penjual, driver, dan admin terhubung dalam satu sistem.</p>
        </div>
      </div>
    </div>
  );
}
