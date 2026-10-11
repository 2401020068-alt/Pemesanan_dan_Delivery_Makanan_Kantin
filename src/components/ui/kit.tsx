import { useState, type ButtonHTMLAttributes, type InputHTMLAttributes, type ReactNode, type SelectHTMLAttributes, type TextareaHTMLAttributes } from "react";
import { Check, ImageOff, Inbox, Upload, type LucideIcon } from "lucide-react";
import { cn } from "@/lib/utils";
import { LABELS, type Tone } from "@/lib/format";

type BtnVariant = "primary" | "secondary" | "outline" | "ghost" | "danger" | "success";
const btn: Record<BtnVariant, string> = {
  primary: "bg-primary text-primary-foreground hover:bg-primary/90",
  secondary: "bg-secondary text-secondary-foreground hover:bg-secondary/90",
  outline: "border border-border bg-card text-foreground hover:bg-muted",
  ghost: "text-foreground hover:bg-muted",
  danger: "bg-destructive text-destructive-foreground hover:bg-destructive/90",
  success: "bg-success text-primary-foreground hover:bg-success/90",
};
export function Button({ variant = "primary", size = "md", icon: Icon, className, children, ...p }: ButtonHTMLAttributes<HTMLButtonElement> & { variant?: BtnVariant; size?: "sm" | "md" | "lg"; icon?: LucideIcon }) {
  return (
    <button
      {...p}
      className={cn(
        "inline-flex items-center justify-center gap-2 rounded-lg font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50",
        size === "sm" ? "h-8 px-3 text-xs" : size === "lg" ? "h-12 px-6 text-base" : "h-10 px-4 text-sm",
        btn[variant],
        className,
      )}
    >
      {Icon && <Icon className={size === "sm" ? "h-3.5 w-3.5" : "h-4 w-4"} />}
      {children}
    </button>
  );
}

export function Card({ className, children }: { className?: string; children: ReactNode }) {
  return <div className={cn("rounded-2xl border border-border bg-card shadow-card", className)}>{children}</div>;
}

const toneCls: Record<Tone, string> = {
  success: "bg-success/10 text-success ring-success/20",
  warning: "bg-warning/15 text-warning-foreground ring-warning/30",
  error: "bg-destructive/10 text-destructive ring-destructive/20",
  info: "bg-info/10 text-info ring-info/20",
  neutral: "bg-muted text-muted-foreground ring-border",
};
export function Badge({ tone = "neutral", children }: { tone?: Tone; children: ReactNode }) {
  return <span className={cn("inline-flex items-center gap-1 whitespace-nowrap rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset", toneCls[tone])}>{children}</span>;
}
export function StatusBadge({ status }: { status: string }) {
  const [label, tone] = LABELS[status] ?? [status, "neutral"];
  return <Badge tone={tone}>{label}</Badge>;
}

export function Img({ src, alt, className }: { src?: string; alt: string; className?: string }) {
  const [err, setErr] = useState(false);
  if (!src || err)
    return (
      <div className={cn("flex items-center justify-center bg-muted text-muted-foreground", className)}>
        <ImageOff className="h-6 w-6" />
      </div>
    );
  return <img src={src} alt={alt} loading="lazy" onError={() => setErr(true)} className={cn("object-cover", className)} />;
}

const field = "w-full rounded-lg border border-input bg-card px-3 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20";
export function Label({ children, htmlFor }: { children: ReactNode; htmlFor?: string }) {
  return <label htmlFor={htmlFor} className="mb-1.5 block text-sm font-medium text-foreground">{children}</label>;
}
export function Input({ label, className, ...p }: InputHTMLAttributes<HTMLInputElement> & { label?: string }) {
  return (
    <div className={className}>
      {label && <Label htmlFor={p.id}>{label}</Label>}
      <input {...p} className={cn(field, "h-10")} />
    </div>
  );
}
export function Textarea({ label, className, ...p }: TextareaHTMLAttributes<HTMLTextAreaElement> & { label?: string }) {
  return (
    <div className={className}>
      {label && <Label htmlFor={p.id}>{label}</Label>}
      <textarea rows={3} {...p} className={cn(field, "py-2")} />
    </div>
  );
}
export function Select({ label, className, children, ...p }: SelectHTMLAttributes<HTMLSelectElement> & { label?: string }) {
  return (
    <div className={className}>
      {label && <Label htmlFor={p.id}>{label}</Label>}
      <select {...p} className={cn(field, "h-10")}>{children}</select>
    </div>
  );
}

export function PageHeader({ title, subtitle, action }: { title: string; subtitle?: string; action?: ReactNode }) {
  return (
    <div className="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
      <div>
        <h1 className="font-display text-2xl font-semibold tracking-tight text-foreground">{title}</h1>
        {subtitle && <p className="mt-1 text-sm text-muted-foreground">{subtitle}</p>}
      </div>
      {action}
    </div>
  );
}

export function StatCard({ label, value, icon: Icon, tone = "primary", hint }: { label: string; value: ReactNode; icon: LucideIcon; tone?: "primary" | "secondary" | "info" | "warning" | "error"; hint?: string }) {
  const t = { primary: "bg-primary/10 text-primary", secondary: "bg-secondary/15 text-secondary", info: "bg-info/10 text-info", warning: "bg-warning/15 text-warning-foreground", error: "bg-destructive/10 text-destructive" }[tone];
  return (
    <Card className="p-5">
      <div className="flex items-start justify-between">
        <div>
          <p className="text-sm text-muted-foreground">{label}</p>
          <p className="mt-2 font-display text-2xl font-semibold text-foreground">{value}</p>
          {hint && <p className="mt-1 text-xs text-muted-foreground">{hint}</p>}
        </div>
        <div className={cn("rounded-xl p-2.5", t)}><Icon className="h-5 w-5" /></div>
      </div>
    </Card>
  );
}

export function EmptyState({ title, desc, icon: Icon = Inbox, action }: { title: string; desc?: string; icon?: LucideIcon; action?: ReactNode }) {
  return (
    <div className="flex flex-col items-center justify-center rounded-2xl border border-dashed border-border bg-card px-6 py-14 text-center">
      <div className="mb-4 rounded-full bg-muted p-4 text-muted-foreground"><Icon className="h-7 w-7" /></div>
      <p className="font-display font-semibold text-foreground">{title}</p>
      {desc && <p className="mt-1 max-w-sm text-sm text-muted-foreground">{desc}</p>}
      {action && <div className="mt-5">{action}</div>}
    </div>
  );
}

export function Table({ head, children, empty }: { head: string[]; children: ReactNode; empty?: boolean }) {
  return (
    <Card className="overflow-hidden">
      <div className="overflow-x-auto">
        <table className="w-full min-w-[640px] text-sm">
          <thead className="bg-muted/60 text-left text-xs uppercase tracking-wide text-muted-foreground">
            <tr>{head.map((h) => <th key={h} className="px-4 py-3 font-medium">{h}</th>)}</tr>
          </thead>
          <tbody className="divide-y divide-border [&_td]:px-4 [&_td]:py-3 [&_tr:hover]:bg-muted/40">{children}</tbody>
        </table>
      </div>
      {empty && <div className="p-10 text-center text-sm text-muted-foreground">Tidak ada data.</div>}
    </Card>
  );
}

export function Timeline({ steps, current, vertical }: { steps: { label: string; icon: LucideIcon }[]; current: number; vertical?: boolean }) {
  return (
    <ol className={cn("flex", vertical ? "flex-col gap-0" : "flex-col gap-0 md:flex-row md:gap-2")}>
      {steps.map((s, i) => {
        const done = i < current, active = i === current;
        const Icon = done ? Check : s.icon;
        return (
          <li key={s.label} className={cn("relative flex items-center gap-3 pb-6 last:pb-0", !vertical && "md:flex-1 md:flex-col md:pb-0 md:text-center")}>
            {i < steps.length - 1 && (
              <span className={cn("absolute left-5 top-10 h-[calc(100%-2.5rem)] w-0.5", done ? "bg-primary" : "bg-border", !vertical && "md:left-[calc(50%+1.5rem)] md:top-5 md:h-0.5 md:w-[calc(100%-3rem)]")} />
            )}
            <span className={cn("relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2", done ? "border-primary bg-primary text-primary-foreground" : active ? "border-primary bg-primary/10 text-primary" : "border-border bg-card text-muted-foreground")}>
              <Icon className="h-4 w-4" />
            </span>
            <span className={cn("text-sm", done || active ? "font-medium text-foreground" : "text-muted-foreground")}>{s.label}</span>
          </li>
        );
      })}
    </ol>
  );
}

export function FileUpload({ value, onChange, label = "Upload bukti" }: { value?: string; onChange: (dataUrl: string) => void; label?: string }) {
  return (
    <div>
      <Label>{label}</Label>
      <label className="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-border bg-muted/40 p-6 text-center transition-colors hover:border-primary hover:bg-primary/5">
        {value ? <img src={value} alt="Preview bukti" className="max-h-56 rounded-lg object-contain" /> : <Upload className="h-7 w-7 text-muted-foreground" />}
        <span className="text-sm text-muted-foreground">{value ? "Klik untuk mengganti file" : "Klik untuk memilih gambar (JPG/PNG)"}</span>
        <input type="file" accept="image/*" className="hidden" onChange={(e) => {
          const f = e.target.files?.[0];
          if (!f) return;
          const r = new FileReader();
          r.onload = () => onChange(String(r.result));
          r.readAsDataURL(f);
        }} />
      </label>
    </div>
  );
}

export function InfoRow({ label, children }: { label: string; children: ReactNode }) {
  return (
    <div className="flex justify-between gap-4 py-2 text-sm">
      <span className="text-muted-foreground">{label}</span>
      <span className="text-right font-medium text-foreground">{children}</span>
    </div>
  );
}

export function Modal({ open, onClose, title, children }: { open: boolean; onClose: () => void; title: string; children: ReactNode }) {
  if (!open) return null;
  return (
    <div className="fixed inset-0 z-50 flex items-end justify-center bg-foreground/40 p-0 sm:items-center sm:p-4" onClick={onClose}>
      <div className="max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-t-2xl bg-card p-6 shadow-xl sm:rounded-2xl" onClick={(e) => e.stopPropagation()}>
        <h2 className="mb-4 font-display text-lg font-semibold">{title}</h2>
        {children}
      </div>
    </div>
  );
}
